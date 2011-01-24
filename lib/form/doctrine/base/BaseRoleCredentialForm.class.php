<?php

/**
 * RoleCredential form base class.
 *
 * @method RoleCredential getObject() Returns the current form's model object
 *
 * @package    timehive
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRoleCredentialForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'       => new sfWidgetFormInputHidden(),
      'credential_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'role_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('role_id')), 'empty_value' => $this->getObject()->get('role_id'), 'required' => false)),
      'credential_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('credential_id')), 'empty_value' => $this->getObject()->get('credential_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_credential[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RoleCredential';
  }

}
