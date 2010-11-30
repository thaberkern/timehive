<?php

/**
 * adminRole actions.
 *
 * @package    timeboxx
 * @subpackage adminRole
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adminRoleActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('adminRole', 'list');
    }

    public function executeList(sfWebRequest $request)
    {
        
    }

}
