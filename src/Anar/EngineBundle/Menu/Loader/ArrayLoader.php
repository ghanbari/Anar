<?php

namespace Anar\EngineBundle\Menu\Loader;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Loader importing a menu tree from an array.
 *
 * The array should match the output of MenuManipulator::toArray
 */
class ArrayLoader implements LoaderInterface
{
    private $factory;

    private $addressType;

    public function __construct(FactoryInterface $factory, $addressType)
    {
        $this->factory = $factory;
        $this->addressType = $addressType;
    }

    public function load($data)
    {
        if (!$this->supports($data)) {
            throw new \InvalidArgumentException(sprintf('Unsupported data. Expected an array but got ', is_object($data) ? get_class($data) : gettype($data)));
        }

        return $this->fromArray($data);
    }

    public function supports($data)
    {
        return is_array($data);
    }

    /**
     * @param array       $data
     * @param string|null $name (the name of the item, used only if there is no name in the data themselves)
     *
     * @return ItemInterface
     */
    private function fromArray(array $data, $name = null)
    {
        $name = isset($data['name']) ? $data['name'] : $name;
        $data['label'] = $data['title'];
        $data['route'] = $this->addressType == 'domain' ? 'anar_home_homepage' : 'anar_home_homepage_path';
        $data['routeParameters'] = array('blogName' => $data['name']);
        $data['display'] = $data['active'];

        if (isset($data['children'])) {
            $children = $data['children'];
            unset($data['children']);
        } else {
            $children = array();
        }

        $item = $this->factory->createItem($name, $data);

        foreach ($children as $name => $child) {
            $item->addChild($this->fromArray($child, $name));
        }

        return $item;
    }
}
