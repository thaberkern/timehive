<?php
class myUser extends sfBasicSecurityUser {
    /**
     * Checks if a user is allowed to access a given action
     *
     * @param Integer $action
     * @return Boolean Returns true if the user is allowed to do the given
     *                  action
     */
    public function isAllowedTo($action) {
        return ($this->getAttribute('user_rights', 0) & $action) == $action;
    }

    public function isAdministrator() {
        return $this->hasCredential('admin');
    }

    public function isAnonymous() {
        return !$this->isAuthenticated();
    }

    public function isFirstRequest() {
        if ($this->is_first_request) {
            $this->is_first_request = false;
            return true;
        }

        return $this->is_first_request;
    }

    /**
     * TODO: Documentation
     * @param User $user
     */
    public function signIn(User $user) {
        $this->setAuthenticated(true);

        $this->setAttribute('uid', $user->getId());
        $this->setAttribute('username', $user->getUsername());
        $this->setAttribute('firstname', $user->getFirstName());
        $this->setAttribute('lastname', $user->getLastName());

        if ($user->administrator == true) {
            $this->addCredential('admin');
        }
    }

    private $is_first_request = true;
}
