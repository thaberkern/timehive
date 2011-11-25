<?php

/**
 * Account form.
 *
 * @package    timehive
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AccountForm extends BaseAccountForm
{

    public function configure()
    {
        $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '60'));
        $this->widgetSchema['max_hours_per_day'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '20'));
        $this->widgetSchema['default_working_time'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '20'));

        $this->validatorSchema['name']->setOption('required', true);
        $this->validatorSchema['name']->setMessage('required', 'Accountname is required');
        
        $this->setValidator('max_hours_per_day', new sfValidatorNumber(
                array('min'=>1, 'max'=> 24),
                array('min'=>'Max hours per day must be at minimum 1 hour',
                      'max'=>'Max hours per day can not more than 24 hours')));
        $this->setValidator('default_working_time', new sfValidatorNumber(
                array('min'=>1, 'max'=> 24),
                array('min'=>'Default working time must be at minimum 1 hour',
                      'max'=>'Default working time can not more than 24 hours')));
        

        unset($this['created_at'], $this['updated_at'], $this['type'], $this['valid_until'], $this['workingdays']);
    }

}
