<?php

class Version27 extends Doctrine_Migration_Base
{

    public function up()
    {
        $this->addColumn('ts_credential', 'sort_order', 'integer', '8', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('ts_credential', 'sort_order');
    }

}
