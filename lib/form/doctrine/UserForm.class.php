<?php

/**
 * User form.
 *
 * @package    timeboxx
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm
{

    public function configure()
    {
        $this->widgetSchema['first_name'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '40'));
        $this->widgetSchema['last_name'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '40'));
        $this->widgetSchema['username'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '40'));
        $this->widgetSchema['email'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '40'));
        $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array('always_render_empty' => false), array('class' => 'txt', 'size' => '40'));

        $this->widgetSchema['account_id'] = new sfWidgetFormInputHidden();

        $this->widgetSchema->setLabels(array(
            'first_name' => 'Firstname',
            'last_name' => 'Lastname'
        ));

        // validators
        $this->validatorSchema['username'] = new sfValidatorAnd(array(
                    new sfValidatorString(array('required' => true))
                        )
        );

        $this->validatorSchema->setPostValidator(
                new sfValidatorDoctrineUnique(array(
                    // check that username is not present in the database
                    'model' => 'User',
                    'column' => 'username',
                    'required' => true,
                    'throw_global_error' => false
                        ),
                        array('invalid' => 'Username already in use. Please try another one.')
                )
        );

        $this->validatorSchema['username']->setOption('required', true);
        $this->validatorSchema['username']->setMessage('required', 'Loginname is required');

        $this->validatorSchema['first_name']->setOption('required', true);
        $this->validatorSchema['first_name']->setMessage('required', 'Firstname is required');

        $this->validatorSchema['last_name']->setOption('required', true);
        $this->validatorSchema['last_name']->setMessage('required', 'Lastname is required');

        $this->validatorSchema['email'] = new sfValidatorEmail();
        $this->validatorSchema['email']->setOption('required', true);
        $this->validatorSchema['email']->setMessage('required', 'EMail address is required');
        $this->validatorSchema['email']->setMessage('invalid', 'EMail address is not valid');

        $this->validatorSchema['password']->setOption('required', true);
        $this->validatorSchema['password']->setMessage('required', 'Password is required');
        $this->validatorSchema['password']->setOption('min_length', 6);
        $this->validatorSchema['password']->setMessage('min_length', 'Password must be at least 6 characters long');

        $this->embedForm('settings', new SettingForm($this->getObject()->getSetting()));

        unset($this['created_at'], $this['updated_at'], $this['deleted_at'], $this['assigned_user_list'], $this['owner_id']);
    }

    public function setValue($field, $value)
    {
        $this->values[$field] = $value;
        $this->taintedValues[$field] = $value;
        $this->resetFormFields();
    }
}
