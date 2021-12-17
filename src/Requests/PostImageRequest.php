<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PostImageRequest extends BaseRequest
{
     #[Assert\Type('string')]
     #[Assert\Url()]
     protected ?string $url;

     #[Assert\Image()]
     protected ?UploadedFile $image;

     #[Assert\Type('array')]
     #[NotBlank()]
     protected array $tags;


    public function validate(array $stackedErrors = []):void {
        $errors = [];
        //dd($this->image);
        if (isset($this->url, $this->image)) {
            $errors[] = ['property' => 'url and image',
                'value' => 'not null',
                'message' => 'Please supply either image or url;'];
        }
        parent::validate($errors);

    }


}