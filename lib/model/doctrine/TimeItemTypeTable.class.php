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
                    ->orderBy('it.name ASC')
                    ->execute();
    }

    public function findDefaultForAccount($account_id)
    {
        return Doctrine_Query::create()
                    ->from('TimeItemType it')
                    ->where('it.account_id=? AND it.default_item=?',
                                array($account_id, true))
                    ->fetchOne();
    }

    public function setAsDefault($type_id, $account_id)
    {
        Doctrine_Query::create()
                            ->update('TimeItemType i')
                            ->set('i.default_item,', '?', 0)
                            ->where('i.account_id=?', array($account_id))
                            ->execute();

        Doctrine_Query::create()
                            ->update('TimeItemType i')
                            ->set('i.default_item,', '?', 1)
                            ->where('i.account_id=? AND i.id=?', array($account_id, $type_id))
                            ->execute();
    }
}