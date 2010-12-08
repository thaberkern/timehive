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
        $this->year = $request->getParameter('year', date('Y'));
        $days = DateTimeHelper::create()->getDaysOfWeek($this->week, $this->year);
        $this->weekstart = $days[1];

        $account_id = $this->getUser()->getAttribute('account_id');
        $this->projects = ProjectTable::getInstance()
                                ->findByAccountId($account_id);

        $this->item_types = TimeItemTypeTable::getInstance()
                                ->findByAccountId($account_id);

        $items = Doctrine_Query::create()
                        ->from('TimeLogItem ti')
                        ->where('ti.itemdate >= ? and itemdate <= ? and ti.user_id = ?',
                                array(date('Y-m-d', $days[1]),
                                    date('Y-m-d', $days[1] + (5 * 24 * 60 * 60)),
                                    $this->getUser()->getAttribute('uid')
                                )
                        )
                        ->execute();

        $this->time_items = new TimeItemSelector($items);
    }

    public function executeField(sfWebRequest $request)
    {
        $query = new Doctrine_Query();
        $project = ProjectTable::getInstance()
                                ->find($request->getParameter('project_id'));

        $this->setLayout(false);
        return $this->renderPartial('timeitem', array(
            'project' => $project,
            'weekday' => $request->getParameter('weekday')
        ));
    }
}
