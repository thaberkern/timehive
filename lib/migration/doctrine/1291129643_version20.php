<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version20 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('tb_project', 'deactivated', 'boolean', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('tb_project', 'deactivated');
    }
}