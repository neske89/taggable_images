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

        $factory = function(array $query, array $request, array $attributes,
                            array $cookies, array $files, array $server, $content) use ($requestClass) {
            return new $requestClass($query, $request, $attributes, $cookies, $files, $server, $content);
        };
        Request::setFactory($factory);

        $req = Request::createFromGlobals();
        $req->setSession($request->getSession());
        yield $req;
    }
}