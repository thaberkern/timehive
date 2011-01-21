<?php

/**
 * adminRole actions.
 *
 * * @package    sutimeboxx
 * @subpackage adminRole
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminRoleActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('adminRole', 'list');
    }

    public function executeList(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->roles = RoleTable::getInstance()
                                    ->findByAccountId($account_id);
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->credentials = CredentialTable::getGroupedCredentials();
        
        $this->forward404Unless($role = Doctrine::getTable('Role')->find(array($request->getParameter('id'))), sprintf('Object role does not exist (%s).', $request->getParameter('id')));
        $this->form = new RoleForm($role);
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($role = Doctrine::getTable('Role')->find(array($request->getParameter('id'))), sprintf('Object role does not exist (%s).', $request->getParameter('id')));

        if ($role->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $this->form = new RoleForm($role);
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->credentials = CredentialTable::getGroupedCredentials();
        $this->form = new RoleForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $this->form = new RoleForm();
        $this->processForm($request, $this->form);

        $this->credentials = CredentialTable::getGroupedCredentials();
        $this->setTemplate('new');
    }
    
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($role = Doctrine::getTable('Role')->find(array($request->getParameter('id'))), sprintf('Role does not exist (%s).', $request->getParameter('id')));

        if ($role->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $role->deleted_at = date('Y-m-d H:i:s');
        $role->save();

        $this->redirect('adminRole/list');
    }

    public function executeBulk(sfWebRequest $request)
    {
        $ids = array_keys($request->getParameter('rl-check', array()));

        $query = Doctrine_Query::create();

        $query->update('Role r')
              ->set('deleted_at', '?', date('Y-m-d H:i:s'))
              ->whereIn('r.id', $ids)
              ->execute();

        $this->redirect('adminRole/list');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid()) {
            $form->setValue('account_id', $this->getUser()->getAttribute('account_id'));
            $role = $form->save();

            unset($role->Credentials);
            $role->save();

            foreach ($request->getParameter('credential') as $credential_id=>$value) {
                $roleCredential = new RoleCredential();
                $roleCredential->role_id = $role->id;
                $roleCredential->credential_id = $credential_id;
                $roleCredential->save();
            }

            $this->getUser()->setFlash('saved.success', 1);
            $this->redirect('adminRole/edit?id=' . $role->getId());
        }
    }
}
