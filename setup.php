<?php

// Autoloader

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Setup RedBean

class R extends RedBean_Facade{} // simple reference to facade

R::setup('mysql:host=localhost;dbname=silex_redbean_security','root','');

// Create Application Instance

$app = new \Silex\Application();

// Rgister Security Provider

$app->register(new \Silex\Provider\SecurityServiceProvider());

// Create User

// R::nuke(); // Completely empties database if necessary.

$roles = array('ROLE_MEMBER','ROLE_ADMIN');

foreach($roles as $role){
    $r = \R::dispense('role');
    $r->name = $role;
    R::store($r);
}

$u = R::dispense('user');
$u->username = 'fabien';
$u->email = 'fabien@email.com';
$u->sharedRole[] = R::findOne('role', 'name = ?',array('ROLE_MEMBER'));
$u->salt = md5(mcrypt_create_iv(22,MCRYPT_RAND));
$u->password = $app['security.encoder.digest']->encodePassword('foo',$u->salt);
R::store($u);
