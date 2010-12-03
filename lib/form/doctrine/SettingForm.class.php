<?php

/**
 * Setting form.
 *
 * @package    timeboxx
 * @subpackage form
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SettingForm extends BaseSettingForm
{
  public function configure()
  {
      $this->widgetSchema['theme'] = new sfWidgetFormChoice(array('choices'=>array('green'=>'green', 'black'=>'black', 'blue'=>'blue', 'orange'=>'orange', 'purple'=>'purple', 'red'=>'red')), array('default'=>'green'));
      
      $this->widgetSchema['culture'] = new sfWidgetFormI18nChoiceLanguage(
                                            array('culture' => sfContext::getInstance()->getUser()->getCulture(),
                                                  'languages'=>sfConfig::get('app_user_cultures')));

      $this->widgetSchema->setLabels(array(
          'theme' => 'Layout theme',
          'culture' => 'Interface language'
      ));
  }
}
