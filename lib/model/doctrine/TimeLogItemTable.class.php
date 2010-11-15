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
}