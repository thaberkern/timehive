<?php

/**
 * Project form.
 *
 * * @package    sutimeboxx
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectForm extends BaseProjectForm
{

    public function configure()
    {
        $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '60'));
        $this->widgetSchema['number'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'size' => '60'));

        $this->widgetSchema['account_id'] = new sfWidgetFormInputHidden();

        $account_id = sfContext::getInstance()->getUser()->getAttribute('account_id');
        $query = Doctrine_Query::create()
                            ->from('User u')
                            ->where('u.account_id=? AND deleted_at IS NULL AND locked <>?',
                                            array($account_id, true))
                            ->orderBy('u.username ASC');

        $this->widgetSchema['owner_id'] = new sfWidgetFormDoctrineChoice(
                                                    array('model' => $this->getRelatedModelName('Owner'),
                                                          'query' => $query,
                                                          'add_empty' => false));

        $this->widgetSchema->setLabels(array(
            'deactivated' => 'Locked'
        ));


        $this->validatorSchema['name']->setOption('required', true);
        $this->validatorSchema['name']->setMessage('required', 'Projectname is required');

        $this->validatorSchema->setPostValidator(
                new sfValidatorDoctrineUnique(array(
                    // check that projectname is not present in the database
                    'model' => 'Project',
                    'column' => 'name',
                    'required' => true,
                    'throw_global_error' => false
                        ),
                        array('invalid' => 'Projectname already in use. Please try another one.')
                )
        );

        unset($this['created_at'], $this['updated_at'], $this['deleted_at'], $this['assigned_user_list']);
    }

    public function setValue($field, $value)
    {
        $this->values[$field] = $value;
        $this->taintedValues[$field] = $value;
        $this->resetFormFields();
    }
}
