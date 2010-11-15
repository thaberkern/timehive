<?php


class ProjectTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Project');
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
            case 'this_month':  $date_from = null;
                                $date_to = null;
                                break;
            case 'last_month':  $date_from = null;
                                $date_to = null;
                                break;
        }

        echo $date_to." ---- ".$date_from;
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