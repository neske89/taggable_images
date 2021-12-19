<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
    //ToDo::Find better way to have root dir available
    define('ROOT_DIR', $kernel->getProjectDir());
    return $kernel;
};
