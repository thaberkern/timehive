<?php

/**
 * timesheet actions.
 *
 * @package    timeboxx
 * @subpackage timesheet
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class timesheetActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->week = $request->getParameter('week', date('W'));
        $days = DateTimeHelper::create()->getDaysOfWeek($this->week, date("Y"));
        $this->weekstart = $days[1];

        $account_id = $this->getUser()->getAttribute('account_id');
        $this->projects = ProjectTable::getInstance()
                                ->findByAccountId($account_id);

        $this->item_types = Doctrine_Query::create()
                                ->from('TimeItemType tit')
                                ->orderBy('name ASC')
                                ->execute();
    }

}
