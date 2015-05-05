<?php

namespace Anar\EngineBundle\Uploader\Naming;

use Anar\EngineBundle\Doctrine\BlogManager;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class DirectoryNamer implements DirectoryNamerInterface
{
    /**
     * @var \Anar\EngineBundle\Entity\Blog
     */
    private $blog;

    public function __construct(BlogManager $blogManager)
    {
        $this->blog = $blogManager->getBlog();
    }

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param object $object The object the upload is attached to.
     * @param Propertymapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The directory name.
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        $arrayName = explode('\\', get_class($object));
        $ds = DIRECTORY_SEPARATOR;
        $path = $this->blog->getName() .$ds. strtolower(array_pop($arrayName)) .$ds. $object->getCreatedAt()->format('Y');
        return $path;
    }

}