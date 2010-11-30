<?php


class TimeItemTypeTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TimeItemType');
    }

    public function findByAccountId($account_id)
    {
        return Doctrine_Query::create()
                    ->from('TimeItemType it')
                    ->where('it.account_id=? AND it.deleted_at IS NULL',
                                array($account_id))
                    ->execute();
    }
}