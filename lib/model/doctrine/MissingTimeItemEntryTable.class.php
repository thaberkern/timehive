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
                        ->where('e.user_id=? AND e.ignored_at IS NULL', array($user_id));
    }
}