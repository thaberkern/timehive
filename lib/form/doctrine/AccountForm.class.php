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

        $this->validatorSchema['name']->setOption('required', true);
        $this->validatorSchema['name']->setMessage('required', 'Accountname is required');

        unset($this['created_at'], $this['updated_at'], $this['type'], $this['valid_until'], $this['workingdays']);
    }

}
