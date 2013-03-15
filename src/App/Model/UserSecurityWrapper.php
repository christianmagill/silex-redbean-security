<?php

namespace App\Model{

    use Symfony\Component\Security\Core\User\UserInterface;

    class UserSecurityWrapper implements UserInterface{

        protected $bean = null;
        protected $id = null;
        protected $password = null;

        function __construct($bean){
            $this->bean = $bean;
        }

        function __get($prop){
            return $this->bean->$prop;
        }

        function __set($prop, $val){
            $this->bean->$prop = $val;
        }

        function __isset($prop){
            return isset($this->bean->$prop);
        }

        function __unset($prop){
            unset($this->bean->$prop);
        }

        function __call($method, $args){
            return call_user_func_array(array($this->bean,$method),$args);
        }

        function store(){
            \R::store($this->bean);
        }

        function trash(){
            \R::trash($this->bean);
        }

        function getRoles(){
            $roles = $this->bean->sharedRole;
            $r = array();
            foreach($roles as $role){
                $r[] = $role->name;
            }
            return $r;
        }

        function getPassword(){
            return $this->bean->password;
        }

        function getSalt(){
            return $this->bean->salt;
        }

        function getUsername(){
            return $this->bean->username;
        }

        function eraseCredentials(){

        }

        function __sleep(){
            $this->id = $this->bean->getID();
            $this->password = $this->bean->password;
            return array('id','password');
        }

        function __wakeup(){
            $this->bean = \R::load('user',$this->id);
            // if password hashes don't match, dispense empty bean
            if($this->bean->password != $this->password){
                $this->bean = \R::dispense('user');
            }
        }
    }
}