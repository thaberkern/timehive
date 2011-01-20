<?php


class TimeLogItemTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TimeLogItem');
    }

    public function getLastTimeItems($user_id, $amount)
    {
        return Doctrine_Query::create()
                            ->from('TimeLogItem i')
                            ->where('i.user_id=?', array($user_id))
                            ->orderBy('itemdate DESC')
                            ->limit($amount)
                            ->execute();
    }

    public function updateMissedBookingsForWeek($week_number, $year, $user)
    {
        for($day=1; $day<=7; $day++) {
            $timestamp = strtotime($year."W".$week_number.$day);

            if ($timestamp <= time()) {
                $this->updateMissedBookings($timestamp, $user);
            }
        }
    }

    public function getFilterQuery($filter, $user_id = null)
    {
        $query = Doctrine_Query::create()
                    ->from('TimeLogItem e')
                    ->orderBy('e.itemdate DESC');

        if (array_key_exists('user', $filter)) {
            if ($filter['user'] != -1) {
                $query->andWhere('e.user_id=?', array($filter['user']));
            }
        }
        else {
            if ($user_id != null) {
                $query->andWhere('e.user_id=?', array($user_id));
            }
        }

        if (array_key_exists('project', $filter)) {
            if ($filter['project'] != -1) {
                $query->andWhere('e.project_id=?', array($filter['project']));
            }
        }

        if (array_key_exists('dateFrom', $filter)) {
            $query->andWhere('e.itemdate>=?', array($filter['dateFrom']));
        }
        if (array_key_exists('dateTo', $filter)) {
            $query->andWhere('e.itemdate<=?', array($filter['dateTo']));
        }

        return $query;
    }

    public function prepareTotalReport($filter, $projects, $user)
    {
        $result = array();
        return $result;
    }

    public function updateMissedBookings($day, $user)
    {
        Doctrine_Query::create()
                        ->delete()
                        ->from('MissingTimeItemEntry e')
                        ->where('e.day = ?', array(date('Y-m-d')))
                        ->execute();

        if (count($user->getTimeEntriesByDay($day)) == 0) {
            $entry = new MissingTimeItemEntry();
            $entry->day = date('Y-m-d');
            $entry->user_id = $user->id;
            $entry->save();

            return false;
        }

        return true;
    }
}