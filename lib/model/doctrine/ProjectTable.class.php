<?php
class ProjectTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Project');
    }

    public function findByAccountId($account_id)
    {
        return Doctrine_Query::create()
                    ->from('Project p')
                    ->where('p.account_id=? AND deactivated=0',
                                array($account_id))
                    ->execute();
    }

    public function getTimeTotals($user_id, $time_range)
    {
        switch ($time_range) {
            case 'overall':     $date_from = null;
                                $date_to = null;
                                break;
            case 'this_week':   $days = DateTimeHelper::create()
                                            ->getDaysOfWeek(date('W'), date('Y'));
                                $date_from = date('Y-m-d 00:00:00', $days[1]);
                                $date_to = date('Y-m-d 23:59:59', $days[7]);
                                break;
            case 'last_week':   $days = DateTimeHelper::create()
                                            ->getDaysOfWeek(date('W')-1, date('Y'));
                                $date_from = date('Y-m-d 00:00:00', $days[1]);
                                $date_to = date('Y-m-d 23:59:59', $days[7]);
                                break;
            case 'this_month':  $date_from = date('Y-m-d 00:00:00', mktime(00, 00, 00, date('m'), 01));
                                $date_to = date('Y-m-d 23:59:59', strtotime($date_from.'+1 MONTH -1 SECOND'));
                                break;
            case 'last_month':  $month = strtotime('last month');

                                $date_from = date('Y-m-d 00:00:00', mktime(00, 00, 00, date('m', $month), 01));
                                $date_to = date('Y-m-d 23:59:59', strtotime($date_from.'+1 MONTH -1 SECOND'));
                                break;
        }

        $query = Doctrine_Query::create()
                                   ->select('p.*, i.*, SUM(i.value) as total')
                                   ->from('Project p')
                                   ->where('i.user_id=?', $user_id)
                                   ->innerJoin('p.TimeLogItems i')
                                   ->groupBy('p.id')
                                   ->orderBy('p.name');

        if ($date_from != null && $date_to != null) {
            $query->andWhere('i.itemdate >= ? AND i.itemdate <= ?', array($date_from, $date_to));
        }

        return $query->execute();
    }
}