<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends BaseFixture
{


    protected function loadData(ObjectManager $manager)
    {
        $tags = $this->faker->words(1000);
        $providers = [];
        for ($i = 0; $i < 10; $i++) {
            $providers[] = $this->faker->company();
        }
        $images = $this->faker->words(500);

        $this->createMany(Image::class, 1000 * 10*2, function (Image $image, $count) use ($tags, $providers, $images) {
            $image->setFilename('images_.' . $this->faker->randomElement($images) . '_' . uniqid('', true) . '.jpg');
            $image->setProvider($this->faker->randomElement($providers));
            $tagNumber = $this->faker->numberBetween(5, 30);

            $tags = $this->faker->randomElements($tags, $tagNumber);
            $tagsString = implode('  ', $tags);
            $tagsString = ' ' . $tagsString . ' ';
            $image->setTags($tagsString);

        });
        $this->manager->flush();
    }
}
