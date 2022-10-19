#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\Command\DecodeCommand;
use App\Command\EncodeCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/config/.env');

$application = new Application();

$application->add(new DecodeCommand());
$application->add(new EncodeCommand());

$application->run();