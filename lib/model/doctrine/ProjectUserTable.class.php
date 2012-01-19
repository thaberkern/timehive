<?php


class ProjectUserTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ProjectUser');
    }

    /**
     *
     * @param array $users
     * @param integer $project_id 
     */
    public function removeUserProjectRelations($users, $project_id)
    {
        Doctrine_Query::create()
                            ->delete('ProjectUser pu')
                            ->where('pu.project_id=?',
                                            array($project_id))
                            ->andWhereIn('pu.user_id', array_keys($users))
                            ->execute();
    }

    /**
     *
     * @param array $user
     * @param integer $project_id
     * @param array $roles 
     */
    public function addRoles($users, $project_id, $roles)
    {
        foreach ($users as $user_id=>$value) {
            foreach ($roles as $role_id=>$value) {
                $item = new ProjectUser();
                $item->user_id = $user_id;
                $item->project_id = $project_id;
                $item->role_id = $role_id;
                $item->save();
            }
        }
    }
}