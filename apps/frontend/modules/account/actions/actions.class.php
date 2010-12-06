<?php

/**
 * account actions.
 *
 * @package    timeboxx
 * @subpackage account
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accountActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        
    }

    public function executeNewPassword(sfWebRequest $request)
    {
        $this->errors = "";
        if ($request->hasParameter('token')) {
            $this->token = Doctrine::getTable('Token')
                                ->findOneByValue($request->getParameter('token'));

            if ($this->token) {
                $this->user = $this->token->getUser();
                $this->setLayout('login');
                $this->setTemplate('newPassword');
                return sfView::SUCCESS;
            }
        }

        $this->getUser()->setFlash('send_pwd_failure',
                         $this->getContext()->getI18N()->__('Something went wrong with your password request. Please try again'));

        $this->redirect('login/index');
    }

    public function executeCreatePassword(sfWebRequest $request) {

        $this->setLayout('login');

        if ($request->hasParameter('token')) {
            $this->token = Doctrine::getTable('Token')
                                ->findOneByValue($request->getParameter('token'));

            if ($this->token) {
                $this->user = $this->token->getUser();

                // doing validation
                if (strlen($request->getParameter('new_password')) < 6) {
                    $this->errors = $this->getContext()->getI18N()->__('Password must be at least 6 characters long');
                    $this->setTemplate('newPassword');
                    return sfView::SUCCESS;
                }

                if (strcmp($request->getParameter('new_password'), $request->getParameter('new_password_confirmation')) != 0) {
                    $this->errors = $this->getContext()->getI18N()->__('Password and confirmation must be identical');
                    $this->setTemplate('newPassword');
                    return sfView::SUCCESS;
                }

                // save the new user data
                $this->user->setPassword(md5($request->getParameter('new_password')));
                $this->user->save();

                $this->token->delete();

                // redirect to login page
                $this->getUser()->setFlash('notice_message',
                         $this->getContext()->getI18N()->__('Your password was changed successfully. Please login again.'));
                $this->redirect('login/index');
            }
        }

        $this->errors = $this->getContext()->getI18N()->__('There is a problem with your token. Password can not be changed');
        $this->setTemplate('newPassword');
        return sfView::SUCCESS;
    }

    public function executeSendPassword(sfWebRequest $request) {
        // try to find the user by the given E-Mail-Address
        $user = Doctrine::getTable('User')
                            ->findOneByEmail($request->getParameter('email'));

        if ($user) {
            // delete all previous recovery tokens
            Doctrine_Query::create()->delete('Token t')
                                    ->where('t.user_id=? AND action=?',
                                                array($user->getId(),
                                                        Token::$ACTION_RECOVER))
                                    ->execute();

            // generate recover token
            $token = new Token();
            $token->setUserId($user->getId());
            $token->setAction(Token::$ACTION_RECOVER);
            $token->save();

            // sending user email
            $html = $this->getPartial('recoverEmail', array('user'=>$user,
                                                        'token'=>$token));
            $subject = sfContext::getInstance()->getI18N()
                              -> __('Your TimeBoxx password');

            MailSender::createInstance()
                                ->send(
                                        $user['email'],
                                        $subject,
                                        $html
                                    );

            $this->getUser()->setFlash('send_pwd_failure',
                         $this->getContext()->getI18N()->__('An email with instructions to choose a new password has been sent to you.'));
            $this->redirect('login/index');
        }
        else {
            $this->getUser()->setFlash('send_pwd_failure',
                        $this->getContext()->getI18N()->__('There is no such e-mail address in the our database!'));
            $this->redirect('login/index');
        }
    }

}
