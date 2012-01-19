<?php

/**
 * TimeItemType form.
 *
 * @package    timehive
 * @subpackage form
 */
class TimeItemTypeForm extends BaseTimeItemTypeForm
{

    public function configure()
    {
        $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('class'=>'txt', 'size'=>'80'));
        $this->widgetSchema['account_id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['default_item'] = new sfWidgetFormInputHidden();

        $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 255, 'required' => true));
        
        unset($this['created_at']);
        unset($this['deleted_at']);
        unset($this['updated_at']);
    }

    public function setValue($field, $value)
    {
        $this->values[$field] = $value;
        $this->taintedValues[$field] = $value;
        $this->resetFormFields();
    }

}
