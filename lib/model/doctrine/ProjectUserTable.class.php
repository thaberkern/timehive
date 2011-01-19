<?php


class ProjectUserTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ProjectUser');
    }

    public function removeUserProjectRelations($user_id, $project_id)
    {
        Doctrine_Query::create()
                            ->delete('ProjectUser pu')
                            ->where('pu.project_id=? AND pu.user_id=?',
                                            array($project_id, $user_id))
                            ->execute();
    }

    public function addRoles($user_id, $project_id, $roles)
    {
        foreach ($roles as $role_id=>$value) {
            $item = new ProjectUser();
            $item->user_id = $user_id;
            $item->project_id = $project_id;
            $item->role_id = $role_id;
            $item->save();
        }
    }
}