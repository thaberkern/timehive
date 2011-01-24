<?php

/**
 * adminUser actions.
 *
 * @package    timehive
 * @subpackage adminUser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminUserActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('adminUser', 'list');
    }

    public function executeList(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->users = UserTable::getInstance()
                                    ->findByAccountId($account_id);
    }

    public function executeLock(sfWebRequest $request)
    {
        $user = UserTable::getInstance()->find($request->getParameter('id'));
        $this->forward404Unless($user);

        if ($user->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $user->locked = true;
        $user->save();

        $this->redirect('adminUser/list');
    }

    public function executeNew(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $account = AccountTable::getInstance()->find($account_id);
        
        if ($account->hasEnoughLicensesToAddUser() == false) {
            $this->getUser()->setFlash('error.license_count', 1);
            $this->redirect('adminUser/list');
        }

        $this->form = new UserForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new UserForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeBulk(sfWebRequest $request)
    {
        $ids = array_keys($request->getParameter('usr-check', array()));

        $query = Doctrine_Query::create()
                    ->update('User u');

        switch ($request->getParameter('usr-groupaction')) {
            case 'deactivate': $query->set('locked', '?', true); break;
            case 'delete': $query->set('deleted_at', '?', date('Y-m-d H:i:s')); break;
        }

        $query->whereIn('u.id', $ids);
        $query->execute();

        $this->redirect('adminUser/list');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('id'))), sprintf('User does not exist (%s).', $request->getParameter('id')));
        $this->form = new UserForm($user);
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('id'))), sprintf('User does not exist (%s).', $request->getParameter('id')));
        $this->form = new UserForm($user);

        if ($user->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('id'))), sprintf('User does not exist (%s).', $request->getParameter('id')));

        if ($user->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();

        $this->redirect('adminUser/list');
    }

    public function executeUnlock(sfWebRequest $request)
    {
        $user = UserTable::getInstance()->find($request->getParameter('id'));
        $this->forward404Unless($user);

        if ($user->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        if ($user->Account->hasEnoughLicensesToAddUser() == false) {
            $this->getUser()->setFlash('error.license_count', 1);
        }
        else {
            $user->locked = false;
            $user->save();
        }

        $this->redirect('adminUser/list');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        $user = $request->getParameter('user');
        if ($form->isValid()) {
            $org_password = $user['password'];
            if (strlen($user['password']) != 32) {
                $user['password'] = md5($user['password']);
                $this->form->bind($user);
            }

            $user = $form->save();
            $user->Setting->user_id = $user->id;
            $user->Setting->save();

            $user->account_id = $this->getUser()->getAttribute('account_id');
            $user->save();

            $this->getUser()->setFlash('saved.success', 1);
            //$this->redirect('adminUser/edit?id=' . $user->getId());
        }
    }
}
