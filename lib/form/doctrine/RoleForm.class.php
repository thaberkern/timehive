<?php

/**
 * Role form.
 *
 * @package    timeboxx
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RoleForm extends BaseRoleForm
{

    public function configure()
    {
        unset($this['created_at'], $this['updated_at'], $this['deleted_at']);
    }

    public function setValue($field, $value)
    {
        $this->values[$field] = $value;
        $this->taintedValues[$field] = $value;
        $this->resetFormFields();
    }

}
