<?php

declare(strict_types=1);

namespace Prooph\Demo;

if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

error_reporting(E_ALL & ~E_NOTICE);
chdir(dirname(__DIR__));

require 'vendor/autoload.php';

(function () {
    /** @var \Interop\Container\ContainerInterface $container */
    $container = require 'config/container.php';
    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);
    require 'config/pipeline.php';
    require 'config/routes.php';
    $app->run();
})();
