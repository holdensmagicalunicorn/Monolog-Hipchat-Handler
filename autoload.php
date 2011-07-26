<?php

require_once __DIR__.'/vendors/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
    'Palleas' => __DIR__.'/src',
    'Monolog' => __DIR__.'/vendors/monolog/src'
));

$loader->registerPrefixes(array(
    'HipChat' => __DIR__.'/vendors/hipchat-php'
));

$loader->register();

return $loader;