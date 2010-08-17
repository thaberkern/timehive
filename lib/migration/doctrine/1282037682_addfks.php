<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addfks extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('tb_project', 'tb_project_owner_id_tb_user_id', array(
             'name' => 'tb_project_owner_id_tb_user_id',
             'local' => 'owner_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_user',
             ));
        $this->createForeignKey('tb_project_user', 'tb_project_user_project_id_tb_project_id', array(
             'name' => 'tb_project_user_project_id_tb_project_id',
             'local' => 'project_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_project',
             ));
        $this->createForeignKey('tb_settings', 'tb_settings_user_id_tb_user_id', array(
             'name' => 'tb_settings_user_id_tb_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_user',
             ));
        $this->createForeignKey('tb_timeitem_type', 'tb_timeitem_type_account_id_tb_account_id', array(
             'name' => 'tb_timeitem_type_account_id_tb_account_id',
             'local' => 'account_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_account',
             ));
        $this->createForeignKey('tb_timelog_item', 'tb_timelog_item_type_id_tb_timeitem_type_id', array(
             'name' => 'tb_timelog_item_type_id_tb_timeitem_type_id',
             'local' => 'type_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_timeitem_type',
             ));
        $this->createForeignKey('tb_timelog_item', 'tb_timelog_item_user_id_tb_user_id', array(
             'name' => 'tb_timelog_item_user_id_tb_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_user',
             ));
        $this->createForeignKey('tb_timelog_item', 'tb_timelog_item_project_id_tb_project_id', array(
             'name' => 'tb_timelog_item_project_id_tb_project_id',
             'local' => 'project_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_project',
             ));
        $this->createForeignKey('tb_user', 'tb_user_account_id_tb_account_id', array(
             'name' => 'tb_user_account_id_tb_account_id',
             'local' => 'account_id',
             'foreign' => 'id',
             'foreignTable' => 'tb_account',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('tb_project', 'tb_project_owner_id_tb_user_id');
        $this->dropForeignKey('tb_project_user', 'tb_project_user_project_id_tb_project_id');
        $this->dropForeignKey('tb_settings', 'tb_settings_user_id_tb_user_id');
        $this->dropForeignKey('tb_timeitem_type', 'tb_timeitem_type_account_id_tb_account_id');
        $this->dropForeignKey('tb_timelog_item', 'tb_timelog_item_type_id_tb_timeitem_type_id');
        $this->dropForeignKey('tb_timelog_item', 'tb_timelog_item_user_id_tb_user_id');
        $this->dropForeignKey('tb_timelog_item', 'tb_timelog_item_project_id_tb_project_id');
        $this->dropForeignKey('tb_user', 'tb_user_account_id_tb_account_id');
    }
}