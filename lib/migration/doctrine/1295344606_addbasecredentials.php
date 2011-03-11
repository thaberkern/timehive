<?php

class Addbasecredentials extends Doctrine_Migration_Base
{

    public function up()
    {
        $conn = Doctrine_Manager::connection();

        $conn->exec("INSERT INTO ts_credential VALUES(NULL, 'credential.timetracking.edit', 'credential.group.timetracking', 1)");
        $conn->exec("INSERT INTO ts_credential VALUES(NULL, 'credential.report.other', 'credential.group.report', 3)");
        $conn->exec("INSERT INTO ts_credential VALUES(NULL, 'credential.report.project_total.self', 'credential.group.report', 4)");
        $conn->exec("INSERT INTO ts_credential VALUES(NULL, 'credential.report.last_bookings.self', 'credential.group.report', 5)");
    }

    public function down()
    {
        $conn = Doctrine_Manager::connection();

        $conn->exec('DELETE FROM ts_credential WHERE name="credential.timetracking.edit"');
        $conn->exec('DELETE FROM ts_credential WHERE name="credential.report.last_bookings.self"');
        $conn->exec('DELETE FROM ts_credential WHERE name="credential.report.project_total.self"');
        $conn->exec('DELETE FROM ts_credential WHERE name="credential.report.other"');
    }

}
