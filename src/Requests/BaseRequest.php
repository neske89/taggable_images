<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\Validator\Constraints as Assert;


abstract class BaseRequest extends Request
{
    protected ValidatorInterface $validator;


    public function __construct(array $query = [], array $request = [], array $attributes = [],
                                array $cookies = [], array $files = [], array $server = [],
                                $content = null, )
    {

        parent::__construct($query,$request,$attributes,$cookies,$files,$server,$content);
        //$this->validator = Validation::createValidator();
        $this->validator =Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $this->populate();

        if ($this->autoValidateRequest()) {

            $this->validate();
        }
    }

    public function validate(array $stackedErrors = []): void
    {

        //dd($this->id);
        //$errors= $this->validator->validateProperty($this,'id',[new Assert\NotNull()]);
        //$validator = $this->get('validator');

        $errors = $this->validator->validate($this);
        $messages = ['message' => 'validation_failed', 'errors' => []];

        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }
        foreach ($stackedErrors as $error) {
            $messages['errors'][] = $error;
        }

        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages, 201);
            $response->send();
            exit;
        }
    }

    protected function populate(): void
    {
        $content = [];

        if (!empty($this->getContent())) {
           $content = $this->toArray();
        }
        else if (!empty($this->request)) {
            $content = $this->request->all();
        }
        //dd($this->toArray());
        $params = array_merge($content,$this->files->all());
        foreach ($params as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected function autoValidateRequest(): bool
    {
        return true;
    }
}