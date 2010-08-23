<?php

/**
 * report actions.
 *
 * @package    timeboxx
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->filter = $request->getParameter('filter', null);
    }

}
