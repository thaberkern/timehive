<?php

/**
 * adminTimeItemType actions.
 *
 * @package    timehive
 * @subpackage adminTimeItemType
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminTimeItemTypeActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('adminTimeItemType', 'list');
    }

    public function executeList(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        $this->time_item_types = TimeItemTypeTable::getInstance()
                                    ->findByAccountId($account_id);
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = new TimeItemTypeForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new TimeItemTypeForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeDefault(sfWebRequest $request)
    {
        $account_id = $this->getUser()->getAttribute('account_id');
        TimeItemTypeTable::getInstance()->setAsDefault($request->getParameter('id'), $account_id);

        $this->redirect('adminTimeItemType/list');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($time_item_type = Doctrine::getTable('TimeItemType')->find(array($request->getParameter('id'))), sprintf('Object time_item_type does not exist (%s).', $request->getParameter('id')));
        $this->form = new TimeItemTypeForm($time_item_type);
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($time_item_type = Doctrine::getTable('TimeItemType')->find(array($request->getParameter('id'))), sprintf('Object time_item_type does not exist (%s).', $request->getParameter('id')));

        if ($time_item_type->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }
        
        $this->form = new TimeItemTypeForm($time_item_type);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($time_item_type = Doctrine::getTable('TimeItemType')->find(array($request->getParameter('id'))), sprintf('Object time_item_type does not exist (%s).', $request->getParameter('id')));
        if ($time_item_type->account_id != $this->getUser()->getAttribute('account_id')) {
            $this->redirect('default/secure');
        }

        $time_item_type->delete();
        $this->redirect('adminTimeItemType/list');
    }

    public function executeBulk(sfWebRequest $request)
    {
        $ids = array_keys($request->getParameter('tit-check', array()));

        $query = Doctrine_Query::create();
        
        $query->update('TimeItemType it')
              ->set('deleted_at', '?', date('Y-m-d H:i:s'))
              ->whereIn('it.id', $ids)
              ->execute();

        $this->redirect('adminTimeItemType/list');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $form->setValue('account_id', $this->getUser()->getAttribute('account_id'));
            $time_item_type = $form->save();

            $this->getUser()->setFlash('saved.success', 1);
            $this->redirect('adminTimeItemType/edit?id=' . $time_item_type->getId());
        }
    }

}
