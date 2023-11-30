<?php

// Версия PHP
$minPHPVersion = '7.2';
if (phpversion() < $minPHPVersion)
{
    die("Your PHP version must be {$minPHPVersion} or higher to run application. Current version: " . phpversion());
}
unset($minPHPVersion);

// Приложение
require_once '../application/application.php';
