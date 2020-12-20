<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $language = new Language();
        $language->setName('Русский');
        $manager->persist($language);

        $language = new Language();
        $language->setName('Qazaq');
        $manager->persist($language);

        $manager->flush();
    }
}
