<?php

namespace Anar\FileManagerBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $app = $this->getReference('AnarFileManagerBundle');
        $index = new Role('لیست فایل ها', 'ANAR_FILEMANAGER_DEFAULT_INDEX', $app);
        $delete_file = new Role('حذف فایل ها', 'ANAR_FILEMANAGER__DELETE_FILES', $app);
        $create_folder = new Role('ساخت پوشه', 'ANAR_FILEMANAGER__CREATE_FOLDERS', $app);
        $delete_folder = new Role('حذف پوشه ها', 'ANAR_FILEMANAGER__DELETE_FOLDERS', $app);
        $upload_file = new Role('بارگذاری فایل', 'ANAR_FILEMANAGER__UPLOAD_FILES', $app);
        $rename_file = new Role('تغییرنام فایل ها', 'ANAR_FILEMANAGER__RENAME_FILES', $app);
        $rename_folder = new Role('تغییرنام پوشه ها', 'ANAR_FILEMANAGER__RENAME_FOLDERS', $app);
        $duplicate_file = new Role('پشتیبان گیری فایل ها', 'ANAR_FILEMANAGER__DUPLICATE_FILES', $app);
        $copy_file = new Role('کپی فایل ها', 'ANAR_FILEMANAGER__COPY_FILES', $app);
        $copy_folder = new Role('کپی پوشه ها', 'ANAR_FILEMANAGER__COPY_FOLDERS', $app);
        $create_txt = new Role('ساخت فایل متنی', 'ANAR_FILEMANAGER__CREATE_TXT', $app);
        $edit_txt = new Role('ویرایش فایل متنی', 'ANAR_FILEMANAGER__EDIT_TXT', $app);

        $manager->persist($index);
        $manager->persist($delete_file);
        $manager->persist($create_folder);
        $manager->persist($delete_folder);
        $manager->persist($upload_file);
        $manager->persist($rename_file);
        $manager->persist($rename_folder);
        $manager->persist($duplicate_file);
        $manager->persist($copy_file);
        $manager->persist($copy_folder);
        $manager->persist($create_txt);
        $manager->persist($edit_txt);
        $manager->flush();

        $this->setReference('fileManagerIndex', $index);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 71;
    }
}