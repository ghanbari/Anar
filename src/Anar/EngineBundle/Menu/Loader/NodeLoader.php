<?php

namespace Anar\EngineBundle\Menu\Loader;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Loader\LoaderInterface;
use Knp\Menu\NodeInterface;

class NodeLoader implements LoaderInterface
{
    private $factory;

    private $nameGetter;

    public function __construct(FactoryInterface $factory, $nameProperty)
    {
        $this->factory = $factory;
        $this->nameGetter = 'get' . ucfirst($nameProperty);
    }

    public function load($data)
    {
        if (!$data instanceof NodeInterface) {
            throw new \InvalidArgumentException(sprintf('Unsupported data. Expected Knp\Menu\NodeInterface but got ', is_object($data) ? get_class($data) : gettype($data)));
        }

        $item = $this->factory->createItem($data->{$this->nameGetter}(), $data->getOptions());

        foreach ($data->getChildren() as $childNode) {
            $item->addChild($this->load($childNode));
        }

        return $item;
    }

    public function supports($data)
    {
        return $data instanceof NodeInterface;
    }
}