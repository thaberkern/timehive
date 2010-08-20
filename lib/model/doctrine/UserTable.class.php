<?php

class UserTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('User');
    }

    /**
     * @param string $username
     * @param string $password
     * @return User
     */
    public function login($username, $password)
    {
        $password_hash = md5($password);

        $user = Doctrine_Query::create()
                        ->from('User')
                        ->where('username=? AND password=?',
                                    array($username, $password_hash))
                        ->fetchOne();

        if ($user &&
            $user->getUsername() == $username && $user->getPassword() == $password_hash) {

            return $user;
        }

        return null;
    }

}