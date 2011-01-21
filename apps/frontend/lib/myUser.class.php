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

    public function setFilter($filter, $namespace)
    {
        if (array_key_exists('dateFrom', $filter)) {
            $this->setAttribute('date-from', $filter['dateFrom'], $namespace);
        }

        if (array_key_exists('dateTo', $filter)) {
            $this->setAttribute('date-to', $filter['dateTo'], $namespace);
        }

        if (array_key_exists('user', $filter)) {
            $this->setAttribute('user', $filter['user'], $namespace);
        }

        if (array_key_exists('project', $filter)) {
            $this->setAttribute('project', $filter['project'], $namespace);
        }
    }

    public function getFilter($namespace)
    {
        $result = array();

        if ($this->getAttribute('date-from', null, $namespace) != null) {
            $date_from = trim($this->getAttribute('date-from', null, $namespace));
            if ($date_from != '') {
                $result['dateFrom'] = $date_from;
            }
        }
        if ($this->getAttribute('date-to', null, $namespace) != null) {
            $date_to = trim($this->getAttribute('date-to', null, $namespace));
            if ($date_to != '') {
                $result['dateTo'] = $date_to;
            }
        }
        if ($this->getAttribute('user', null, $namespace) != null) {
            $result['user'] = $this->getAttribute('user', null, $namespace);
        }
        if ($this->getAttribute('project', null, $namespace) != null) {
            $result['project'] = $this->getAttribute('project', null, $namespace);
        }

        return $result;
    }

    public function hasProjectCredential($name, $project)
    {
        $user = $this->getUserObject();
        return $user->hasProjectCredential($name, $project->id);
    }

    public function getUserObject()
    {
        if ($this->user != null) {
            return $this->user;
        }

        return UserTable::getInstance()->find($this->getAttribute('uid'));
    }

    public function clearFilter($namespace)
    {
        $this->getAttributeHolder()->removeNamespace($namespace);
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
        $this->setAttribute('theme', $user->Setting->theme);
        $this->setAttribute('account_id', $user->Account->id);
        $this->setAttribute('account_name', $user->Account->name);

        if ($user->administrator == true) {
            $this->addCredential('admin');
        }

        if ($user->boss_mode == true) {
            $this->setAttribute('overlord', 1);
        }
        else {
            $this->setAttribute('overlord', 0);
        }

        if ($user->Setting->culture != "") {
            $this->setCulture($user->Setting->culture);
        }

    }

    private $user = null;
    private $is_first_request = true;

}
