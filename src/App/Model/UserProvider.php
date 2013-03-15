<?php

namespace App\Model{

    use Symfony\Component\Security\Core\User\UserProviderInterface;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
    use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

    class UserProvider implements UserProviderInterface
    {

        public function loadUserByUsername($username){
            $user = \R::findOne('user','username = ?', array(strtolower($username)));
            if(!$user){
                throw new UsernameNotFoundException(sprintf('Usernam e "%s" does not exist.', $username));
            }
            return new UserSecurityWrapper($user);
        }

        public function refreshUser(UserInterface $user){
            return $this->loadUserByUsername($user->getUsername());
        }

        public function supportsClass($class)
        {
            return $class === 'UserSecurityWrapper';
        }

    }

}