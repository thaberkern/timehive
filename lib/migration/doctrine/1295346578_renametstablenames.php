<?php

class Renametstablenames extends Doctrine_Migration_Base
{

    public function up()
    {
        $this->renameTable('ts_credential', 'tb_credential');
        $this->renameTable('ts_role_credential', 'tb_role_credential');
    }

    public function down()
    {
        $this->renameTable('tb_credential', 'ts_credential');
        $this->renameTable('tb_role_credential', 'ts_role_credential');
    }

}
