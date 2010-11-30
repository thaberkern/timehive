<?php

class myUser extends sfBasicSecurityUser
{

    /**
     * Checks if a user is allowed to access a given action
     *
     * @param Integer $action
     * @return Boolean Returns true if the user is allowed to do the given
     *                  action
     */
    public function isAllowedTo($action)
    {
        return ($this->getAttribute('user_rights', 0) & $action) == $action;
    }

    /**
     * @return boolean
     */
    public function isAdministrator()
    {
        return $this->hasCredential('admin');
    }

    /**
     * @return boolean
     */
    public function isAnonymous()
    {
        return!$this->isAuthenticated();
    }

    /**
     * @return boolean
     */
    public function isFirstRequest()
    {
        if ($this->is_first_request) {
            $this->is_first_request = false;
            return true;
        }

        return $this->is_first_request;
    }

    public function getId()
    {
        return $this->getAttribute('uid', -1);
    }

    /**
     * @param User $user
     */
    public function signIn(User $user)
    {
        $this->setAuthenticated(true);

        $this->setAttribute('uid', $user->getId());
        $this->setAttribute('username', $user->getUsername());
        $this->setAttribute('firstname', $user->getFirstName());
        $this->setAttribute('lastname', $user->getLastName());
        //$this->setAttribute('theme', $user->Setting->theme);

        if ($user->administrator == true) {
            $this->addCredential('admin');
        }

        /*if ($user->Setting->culture != "") {
            $this->setCulture($user->Setting->culture);
        }*/
    }

    private $is_first_request = true;

}
