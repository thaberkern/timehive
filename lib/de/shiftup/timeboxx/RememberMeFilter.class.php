<?php

class RememberMeFilter extends sfFilter
{
    /**
     * @see sfFilter
     */
    public function execute($filterChain)
    {

        if ($this->isFirstCall() &&
                $this->context->getUser()->isAnonymous()) {

            if ($this->context->getRequest()->getCookie('autologin')) {

                $autologin = $this->context->getRequest()->getCookie('autologin');
                $token = Doctrine::getTable('Token')->findOneByValue($autologin);

                if (isset($token)) {
                    sfContext::getInstance()->getLogger()->info('load user');
                    $user = Doctrine::getTable('User')->find($token->user_id);

                    $this->context->getUser()->signIn($user);
                }
            }
        }

        $filterChain->execute();
    }
}