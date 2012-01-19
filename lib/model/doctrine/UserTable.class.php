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
                        ->from('User u')
                        ->where('u.username=? AND u.password=?',
                                    array($username, $password_hash))
                        ->andWhere('u.deleted_at IS NULL')
                        ->fetchOne();

        if ($user &&
            $user->getUsername() == $username && $user->getPassword() == $password_hash) {

            return $user;
        }

        return null;
    }

    public function findAllUnlocked()
    {
        return Doctrine_Query::create()
                            ->from('User u')
                            ->where('u.locked <> ?', true)
                            ->andWhere('u.deleted_at IS NULL')
                            ->execute();
    }

    public function findByAccountId($account_id)
    {
        return Doctrine_Query::create()
                            ->from('User u')
                            ->where('u.account_id=? AND deleted_at IS NULL',
                                            array($account_id))
                            ->orderBy('u.username')
                            ->execute();
    }
}