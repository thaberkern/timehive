<?php

class Addbasecredentials extends Doctrine_Migration_Base
{

    public function up()
    {
        $credential = new Credential();
        $credential->name = 'credential.timetracking.edit';
        $credential->group_name = 'credential.group.timetracking';
        $credential->sort_order = 1;
        $credential->save();

        $credential = new Credential();
        $credential->name = 'credential.report.last_bookings.other';
        $credential->group_name = 'credential.group.report';
        $credential->sort_order = 3;
        $credential->save();

        $credential = new Credential();
        $credential->name = 'credential.report.project_total.self';
        $credential->group_name = 'credential.group.report';
        $credential->sort_order = 4;
        $credential->save();

        $credential = new Credential();
        $credential->name = 'credential.report.last_bookings.self';
        $credential->group_name = 'credential.group.report';
        $credential->sort_order = 2;
        $credential->save();

        $credential = new Credential();
        $credential->name = 'credential.report.project_total.other';
        $credential->group_name = 'credential.group.report';
        $credential->sort_order = 5;
        $credential->save();
    }

    public function down()
    {
        Doctrine_Query::create()->delete('Credential')->where('name=?', 'credential.timetracking.edit');
        Doctrine_Query::create()->delete('Credential')->where('name=?', 'credential.report.last_bookings.other');
        Doctrine_Query::create()->delete('Credential')->where('name=?', 'credential.report.project_total.self');
        Doctrine_Query::create()->delete('Credential')->where('name=?', 'credential.report.last_bookings.self');
        Doctrine_Query::create()->delete('Credential')->where('name=?', 'credential.report.project_total.other');
    }

}
