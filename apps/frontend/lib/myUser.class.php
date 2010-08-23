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

        if ($user->administrator == true) {
            $this->addCredential('admin');
        }

        if ($user->Setting->culture != "") {
            $this->setCulture($user->Setting->culture);
        }
    }

    /**
     * @param sfWebRequest $request
     */
    public function setComesFromRoute(sfWebRequest $request)
    {
        if ($request->getParameter('module') != 'login') {
            $this->setAttribute('comes_from',
                        array('action'=>$request->getParameter('action'),
                              'module'=>$request->getParameter('module')));
        }
    }

    /**
     * @return String
     */
    public function getAndClearComesFromRoute()
    {
        $route_info = $this->getAttribute('comes_from',
                                    array('action'=>'',
                                          'module'=>''));

        $route = $route_info['module'].'/'.$route_info['action'];

        $this->getAttributeHolder()->remove('comes_from');

        return $route;
    }

    private $is_first_request = true;

}
