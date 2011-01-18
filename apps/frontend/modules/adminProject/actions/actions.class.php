<?php

/**
 * adminProject actions.
 *
 * @package    timeboxx
 * @subpackage adminProject
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminProjectActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('adminProject', 'list');
    }

    public function executeList(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->projects = ProjectTable::getInstance()
                                ->findByAccountId($account_id, true);
    }

    public function executeLock(sfWebRequest $request)
    {
        $project = ProjectTable::getInstance()->find($request->getParameter('id'));
        $this->forward404Unless($project);

        if ($project->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $project->deactivated = true;
        $project->save();

        $this->redirect('adminProject/list');
    }

    public function executeUnlock(sfWebRequest $request)
    {
        $project = ProjectTable::getInstance()->find($request->getParameter('id'));
        $this->forward404Unless($project);

        if ($project->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        if ($project->Account->hasEnoughLicensesToAddProject() == false) {
            $this->getUser()->setFlash('error.license_count', 1);
        }
        else {
            $project->deactivated = false;
            $project->save();
        }

        $this->redirect('adminProject/list');
    }

    public function executeBulk(sfWebRequest $request)
    {
        $ids = array_keys($request->getParameter('prj-check', array()));

        $query = Doctrine_Query::create()
                    ->update('Project p');

        switch ($request->getParameter('prj-groupaction')) {
            case 'lock': $query->set('deactivated', '?', true); break;
            case 'delete': $query->set('deleted_at', '?', date('Y-m-d H:i:s')); break;
        }

        $query->whereIn('p.id', $ids);
        $query->execute();

        $this->redirect('adminProject/list');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Project does not exist (%s).', $request->getParameter('id')));

        if ($project->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $project->deleted_at = date('Y-m-d H:i:s');
        $project->save();

        $this->redirect('adminProject/list');
    }

    public function executeNew(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->roles = RoleTable::getInstance()
                                    ->findByAccountId($account_id);
        
        $this->form = new ProjectForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->roles = RoleTable::getInstance()
                                    ->findByAccountId($account_id);
        
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $this->form = new ProjectForm();
        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
        $this->form = new ProjectForm($project);

        $this->project_user = $project->AssignedUser;
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($project = Doctrine::getTable('Project')->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));

        if ($project->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $this->form = new ProjectForm($project);
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid()) {
            $form->setValue('account_id', $this->getUser()->getAttribute('account_id'));
            $project = $form->save();

            $project->save();

            $this->getUser()->setFlash('saved.success', 1);
            $this->redirect('adminProject/edit?id=' . $project->getId());
        }
    }
}
