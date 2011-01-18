<?php

/**
 * Credential filter form base class.
 *
 * @package    timeboxx
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCredentialFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(),
      'group_name' => new sfWidgetFormFilterInput(),
      'roles_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'group_name' => new sfValidatorPass(array('required' => false)),
      'roles_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('credential_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRolesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.RoleCredential RoleCredential')
      ->andWhereIn('RoleCredential.role_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Credential';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'group_name' => 'Text',
      'roles_list' => 'ManyKey',
    );
  }
}
