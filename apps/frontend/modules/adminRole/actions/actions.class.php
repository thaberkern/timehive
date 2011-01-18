<?php

/**
 * adminRole actions.
 *
 * @package    timeboxx
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

        $this->forward404Unless($user = Doctrine::getTable('Role')->find(array($request->getParameter('id'))), sprintf('Role does not exist (%s).', $request->getParameter('id')));

        if ($user->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $role->deleted_at = date('Y-m-d H:i:s');
        $role->save();

        $this->redirect('adminRole/list');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        $role = $request->getParameter('role');
        if ($form->isValid()) {
            $role = $form->save();

            $this->getUser()->setFlash('saved.success', 1);
            $this->redirect('adminRole/edit?id=' . $role->getId());
        }
    }
}
