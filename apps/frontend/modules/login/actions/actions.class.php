<?php

/**
 * login actions.
 *
 * @package    taskboxx
 * @subpackage login
 * @author     Timo Haberkern <timo.haberkern@shift-up.de>
 * @version    SVN: $Id: actions.class.php 39 2009-09-03 07:47:30Z thaberkern $
 */
class loginActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex($request)
    {
        $this->getUser()->setComeFromRoute($request);
    }

    /**
     * Action Login implementation
     *
     * @param sfWebRequest $request
     */
    public function executeLogin($request)
    {
        $username = $request->getParameter('username', '');
        $password = $request->getParameter('pwd', '');

        $user = UserTable::getInstance()->login($username, $password);

        if ($user) {
            $this->getUser()->signIn($user);

            if ($request->getParameter('autologin', 0) == 1) {
                $token = TokenTable::getInstance()->createAutologinToken($user->id);
                $token->save();

                $this->response->setCookie('autologin', 
                                           $token->value,
                                           time() + sfConfig::get('app_autologin_expiration'));
            }

            $comes_from = $this->getUser()->getAndClearComesFromRoute();
            $this->redirect($comes_from);
        }
        else {
            $this->getUser()->setAuthenticated(false);
            $this->getUser()->setFlash('login_failure', true);
            $this->forward('login', 'index');
        }
    }

    /**
     * Action Logout implementation
     *
     * @param sfWebRequest $request
     */
    public function executeLogout($request)
    {
        $this->getUser()->setAuthenticated(false);

        TokenTable::getInstance()->deleteAutologinTokens($this->getUser()->getAttribute('uid'));

        // Delete the autologin-cookie by setting the expiration date to the past
        $this->getResponse()->setCookie('autologin', 0, 0);

        $this->redirect('login/index');
    }

    /**
     * Action Credential implementation. Action is called if the user doesn't
     * have the needed user rights to access a function
     *
     * @param sfWebRequest $request
     */
    public function executeCredential($request)
    {
        // does nothing at the moment
    }

}
