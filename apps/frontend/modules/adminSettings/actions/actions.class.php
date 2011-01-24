<?php

/**
 * adminSettings actions.
 *
 * @package    timehive
 * @subpackage adminSettings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminSettingsActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->redirect('adminSettings/edit');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $account = AccountTable::getInstance()->find($this->getUser()->getAttribute('account_id'));
        $this->forward404Unless($account, 'Account not found');

        $this->form = new AccountForm($account);
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $account = AccountTable::getInstance()->find($this->getUser()->getAttribute('account_id'));
        $this->forward404Unless($account, 'Account not found');
        
        $this->form = new AccountForm($account);
        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        if ($this->form->isValid()) {

            $workingdays = $request->getParameter('workingday', array());
            $value = 0;
            foreach ($workingdays as $code=>$ignore) {
                $value |= $code;
            }
            $this->form->getObject()->workingdays = $value;
            $account = $this->form->save();
            
            $this->getUser()->setFlash('saved.success', 1);
            $this->getUser()->setAttribute('account_name', $account->name);

            $this->redirect('adminSettings/edit');
        }

        $this->setTemplate('edit');
    }
}
