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

    public function prepareTotalReport($filter, Doctrine_Collection $projects, $user, $account_id)
    {
        print_r($filter);
        $result = array();

        $query = Doctrine_Query::create()
                        ->select('p.*, u.*, ti.*, ty.*, SUM(ti.value) as sum')
                        ->from('Project p')
                        ->innerJoin('p.TimeLogItems ti')
                        ->innerJoin('ti.User u')
                        ->innerJoin('ti.TimeItemType ty');

        if (array_key_exists('dateFrom', $filter)) {
            $query->andWhere('ti.itemdate>=?', array($filter['dateFrom']));
        }
        if (array_key_exists('dateTo', $filter)) {
            $query->andWhere('ti.itemdate<=?', array($filter['dateTo']));
        }
        if (array_key_exists('project', $filter)) {
            if ($filter['project'] != -1) {
                $query->andWhere('p.id=?', array($filter['project']));
            }
        }

        if (array_key_exists('user', $filter)) {
            if ($filter['user'] != -1) {
                $query->andWhere('ti.user_id=?', array($filter['user']));
            }
            else if (($user != null) && ($filter['user'] != -1)) {
                $query->andWhere('ti.user_id=?', array($user->id));
            }
        }
        else {
            if ($user != null) {
                $query->andWhere('ti.user_id=?', array($user->id));
            }
        }

        $query->andWhere('p.deactivated = ? AND p.deleted_at IS NULL', array(false));
        $query->andWhere('p.account_id=?', array($account_id));

        $result = $query->orderBy('p.name ASC')
                                    ->groupBy('ti.type_id, ti.user_id, p.id')
                                    ->execute();

        $project_totals = array();
	foreach ($result as $project) {
            $project_totals[$project->id]['project'] = $project;
            foreach ($project->TimeLogItems as $time_item) {
                $project_totals[$project->id]['items'][$time_item->user_id]['user'] = $time_item->User;
                $project_totals[$project->id]['items'][$time_item->user_id]['time'][$time_item->type_id] = $time_item;
            }
        }

        return $project_totals;
    }

    public function updateMissedBookings($day, $user)
    {
        Doctrine_Query::create()
                        ->delete()
                        ->from('MissingTimeItemEntry e')
                        ->where('e.day = ?', array(date('Y-m-d')))
                        ->andWhere('e.user_id = ?', array($user->id))
                        ->execute();

        $item_count = count($user->getTimeEntriesByDay($day));
        if ($item_count == 0) {
            $entry = new MissingTimeItemEntry();
            $entry->day = date('Y-m-d');
            $entry->user_id = $user->id;
            $entry->save();

            return false;
        }

        return true;
    }
}