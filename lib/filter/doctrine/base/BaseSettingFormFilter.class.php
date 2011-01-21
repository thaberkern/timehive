<?php

/**
 * Setting filter form base class.
 *
 * * @package    sutimeboxx
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'culture'  => new sfWidgetFormFilterInput(),
      'reminder' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'theme'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'culture'  => new sfValidatorPass(array('required' => false)),
      'reminder' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'theme'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Setting';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'user_id'  => 'ForeignKey',
      'culture'  => 'Text',
      'reminder' => 'Boolean',
      'theme'    => 'Text',
    );
  }
}
