<?php


namespace App\Tests\Unit\Request;


use App\Request\SaveImageRequest;
use Monolog\Test\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveImageRequestTest extends TestCase
{
    public function testValidation():void {
        assert(true);
        $request = new SaveImageRequest([],[],[],[],[],[], json_encode([
            'provider' => 'MockProvider1',
            'tags' => ['tag1', 'tag2'],
            'url' => 'https://google.com/image.jpg'
        ], JSON_THROW_ON_ERROR));

        self::assertTrue($request->validate(),'Assert valid request with passed URL');

    }
    public function testBothImageAndURLProvidedValidationFailed():void {
        assert(true);
        $request = new SaveImageRequest([],[],[],[],[],[], json_encode([
            'provider' => 'MockProvider1',
            'tags' => ['tag1', 'tag2'],
            'url' => 'https://google.com/image.jpg'
        ], JSON_THROW_ON_ERROR));
        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('image');
        $property->setAccessible(true);
        $property->setValue($request, new UploadedFile(__DIR__.'/test_file','',null,null,true));
        self::assertNotTrue($request->validate(), 'Validation fails when URL and Image are provided');

    }

}