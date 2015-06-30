#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

// Nette loader
$loader = new Nette\Loaders\RobotLoader;

// Add directories for RobotLoader to index
$loader->addDirectory('app');

// And set caching to the 'temp' directory on the disc
$loader->setCacheStorage(new Nette\Caching\Storages\FileStorage('temp'));
$loader->register(); // Run the RobotLoader

// Symfony console
$application = new Symfony\Component\Console\Application('PrestaMigration', '0.1');
$application->add(new App\Console\Command\ExportCommand());
$application->run();