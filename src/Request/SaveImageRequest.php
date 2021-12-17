<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class SaveImageRequest extends BaseRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank()]
    protected string $provider;

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return isset($this->url) ? $this->url : null;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return isset($this->image) ? $this->image : null;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

     #[Assert\Type('string')]
     #[Assert\Url()]
     protected ?string $url;

     #[Assert\Image()]
     protected ?UploadedFile $image;

     #[Assert\Type('array')]
     #[NotBlank()]
     protected array $tags;

     private array $supportedImageTypes = array(
         'gif',
         'jpg',
         'jpeg',
         'png'
     );

    public function validate(array $stackedErrors = []):void {
        $errors = [];
        //validate if url represents image
        if (isset($this->url)) {
            //strip query params
            $url = strtok($this->url, '?');
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            if (!in_array($extension, $this->supportedImageTypes, true)) {
                $extensions = implode(', ',$this->supportedImageTypes);
                $errors[] = ['property' => 'url',
                    'value' => $this->url,
                    'message' => "Please supply url to the image of extension $extensions"];
            }
        }
        if (isset($this->url, $this->image)) {
            $errors[] = ['property' => 'url and image',
                'value' => 'not null',
                'message' => 'Please supply either image or url;'];
        }
        parent::validate($errors);
    }


}