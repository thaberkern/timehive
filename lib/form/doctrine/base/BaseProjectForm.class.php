<?php

/**
 * Project form base class.
 *
 * @method Project getObject() Returns the current form's model object
 *
 * @package    timehive
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProjectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'number'             => new sfWidgetFormInputText(),
      'deactivated'        => new sfWidgetFormInputCheckbox(),
      'owner_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Owner'), 'add_empty' => true)),
      'account_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'add_empty' => true)),
      'deleted_at'         => new sfWidgetFormDateTime(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'assigned_user_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'User')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number'             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'deactivated'        => new sfValidatorBoolean(array('required' => false)),
      'owner_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Owner'), 'required' => false)),
      'account_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'required' => false)),
      'deleted_at'         => new sfValidatorDateTime(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'assigned_user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('project[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Project';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['assigned_user_list']))
    {
      $this->setDefault('assigned_user_list', $this->object->AssignedUser->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveAssignedUserList($con);

    parent::doSave($con);
  }

  public function saveAssignedUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['assigned_user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->AssignedUser->getPrimaryKeys();
    $values = $this->getValue('assigned_user_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('AssignedUser', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('AssignedUser', array_values($link));
    }
  }

}
