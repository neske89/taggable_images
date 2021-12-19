<?php

namespace App\Tests\Application\Image;

use App\Repository\ImageRepository;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FilterImagesTest extends WebTestCase
{
    public function testImageFilter(): void
    {
        $client = static::createClient();
        $imageRepository = static::getContainer()->get(ImageRepository::class);
        $id = $imageRepository->save('Provider',' tag1  tag2 ','image.jpg');
        $response = $client->xmlHttpRequest('GET', '/images?&provider=Provider&tags[]=tag1&tags[]=tag2');

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent());
        $image = $response->images[0];

        self::assertSame($image->provider,'Provider','asserting provider');
        self::assertContains('tag1',$image->tags,'asserting tag1');
        self::assertContains('tag2',$image->tags,'asserting tag2');

        $em= self::$kernel->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($em);
        // Purger mode 2 truncates, resetting autoincrements
        $purger->setPurgeMode(2);
        $purger->purge();

       // dd($response);

    }
}
