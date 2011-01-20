<?php
class MissingTimeItemEntryTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MissingTimeItemEntry');
    }

    public function getForUserQuery($user_id)
    {
        return Doctrine_Query::create()
                        ->from('MissingTimeItemEntry e')
                        ->where('e.user_id=? AND e.ignored_at IS NULL', array($user_id))
                        ->orderBy('e.day DESC');
    }

    public function getFilterQuery($filter, $user_id = null)
    {
        $query = Doctrine_Query::create()
                    ->from('MissingTimeItemEntry e')
                    ->orderBy('e.day DESC');

        if (array_key_exists('user', $filter)) {
            $query->andWhere('e.user_id=?', array($filter['user']));
        }
        else {
            if ($user_id != null) {
                $query->andWhere('e.user_id=?', array($user_id));
            }
        }

        if (array_key_exists('dateFrom', $filter)) {
            $query->andWhere('e.day>=?', array($filter['dateFrom']));
        }
        if (array_key_exists('dateTo', $filter)) {
            $query->andWhere('e.day<=?', array($filter['dateTo']));
        }

        return $query;
    }
}