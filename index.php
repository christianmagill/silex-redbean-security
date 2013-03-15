<?php

// Autoloader

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Setup RedBean

class R extends RedBean_Facade{} // simple reference to facade

R::setup('mysql:host=localhost;dbname=silex_redbean_security','root','');

$test = new \App\Test\RememberMeRedBeanServiceProviderTest;
$test->testRememberMeRedBeanAuthentication();