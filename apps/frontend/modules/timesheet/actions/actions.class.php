<?php

/**
 * timesheet actions.
 *
 * @package    timehive
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

        $this->user = UserTable::getInstance()->find($this->getUser()->getAttribute('uid'));

        $this->item_types = TimeItemTypeTable::getInstance()
                        ->findByAccountId($account_id);

        $this->default_item_type = TimeItemTypeTable::getInstance()->findDefaultForAccount($account_id);
        if ($this->default_item_type) {
            $this->default_item_type_name = $this->default_item_type->getName();
        }
        else {
            $this->default_item_type_name = null;
        }

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
        $this->account = AccountTable::getInstance()->find($account_id);
    }

    public function executeField(sfWebRequest $request)
    {
        $this->weekstart = $request->getParameter('weekstart');
        
        $account_id = $this->getUser()->getAttribute('account_id');

        $query = new Doctrine_Query();
        $project = ProjectTable::getInstance()
                        ->find($request->getParameter('project_id'));

        $item_types = TimeItemTypeTable::getInstance()
                        ->findByAccountId($account_id);

        $this->default_item_type = TimeItemTypeTable::getInstance()->findDefaultForAccount($account_id);
        if ($this->default_item_type) {
            $this->default_item_type_name = $this->default_item_type->getName();
        }
        else {
            $this->default_item_type_name = null;
        }
        
        $this->setLayout(false);
        return $this->renderPartial('timeitem', array(
            'item_types' => $item_types,
            'weekstart' => $this->weekstart,
            'project' => $project,
            'weekday' => $request->getParameter('weekday'),
            'default_item_type_name' => $this->default_item_type_name
        ));
    }

    public function executeUpdate($request)
    {
        $time_values = $request->getParameter('time', array());
        
        $user = UserTable::getInstance()->find($this->getUser()->getAttribute('uid'));

        $this->time_values = $time_values;

        for ($i = 1; $i <= 7; $i++) {
            if (!array_key_exists($i, $time_values)) {
                continue;
            }
            
            $projects = $time_values[$i];

            $booking_timestamp = $request->getParameter('weekstart') + ($i - 1) * 24 * 60 * 60;
            $booking_date = date("Y-m-d", $booking_timestamp);

            if ($booking_timestamp < time()) {
                foreach ($projects as $pid => $project) {
                    $query = new Doctrine_Query();
                    $query->delete('TimeLogItem ti')->where('ti.user_id=? AND ti.project_id=? AND ti.itemdate=?',
                                    array($this->getUser()->getAttribute('uid'),
                                        $pid,
                                        $booking_date))
                            ->execute();

                    for ($time_index = 0; $time_index < count($project['time']); $time_index++) {
                        $time_value = $project['time'][$time_index];
                        $time_type = $project['type'][$time_index];
                        $time_comment = $project['comment'][$time_index];

                        if (($time_value != "") && ($time_value != 0)) {
                            $type_query = new Doctrine_Query();
                            $type = $type_query->from('TimeItemType tit')
                                            ->where('tit.name=?', array($time_type))
                                            ->fetchOne();

                            $current_value = new TimeLogItem();

                            $current_value->value = $time_value;
                            $current_value->itemdate = $booking_date;
                            $current_value->user_id = $this->getUser()->getAttribute('uid');
                            $current_value->project_id = $pid;
                            $current_value->type_id = $type->id;
                            $current_value->note = $time_comment;
                            $current_value->save();
                        }
                    }
                }

                TimeLogItemTable::getInstance()->updateMissedBookings($booking_timestamp, 
                                                                        $user);
            }
        }

        $this->getUser()->setFlash('saved.success', 1);
        $this->redirect('timesheet/index?year='.$request->getParameter('year', date('Y')).'&week='.$request->getParameter('week', date('W')));
    }

}
