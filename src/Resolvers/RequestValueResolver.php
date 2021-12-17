<?php

namespace App\Resolvers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class RequestValueResolver implements ArgumentValueResolverInterface {
    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument):bool {
        return is_subclass_of($argument->getType(), Request::class);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument):iterable {
        $requestClass = $argument->getType();

        yield forward_static_call([$requestClass, 'createFromGlobals']);
    }
}