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
    public function executeIndex(sfWebRequest $request)
    {
        $this->redirect('report/lastBookings');
    }

    public function executeLastBookings(sfWebRequest $request)
    {
        $this->checkFilter($request);

        $this->last_items = TimeLogItemTable::getInstance()
                                ->getLastTimeItems(
                                        $this->getUser()->getId(),
                                        $request->getParameter('timeitemcount', 10));

        
    }

    public function executeMissingBookings(sfWebRequest $request)
    {
        $this->checkFilter($request);

        $pagesize = $request->getParameter('pagesize', 20);
        $this->no_bookings_pager = new sfDoctrinePager('MissingTimeItemEntry', $pagesize);
        $this->no_bookings_pager->setQuery(MissingTimeItemEntryTable::getInstance()
                                            ->getForUserQuery($this->getUser()->getId()));
        $this->no_bookings_pager->setPage($request->getParameter('page', 1));
        $this->no_bookings_pager->init();

        $account_id = $this->getUser()->getAttribute('account_id');
        $this->users = UserTable::getInstance()
                                    ->findByAccountId($account_id);

        $this->user = UserTable::getInstance()->find($this->getUser()->getAttribute('uid'));
    }

    public function executeProjectTotal(sfWebRequest $request)
    {
        $this->checkFilter($request);
    }

    protected function checkFilter(sfWebRequest $request)
    {
        $filter = $request->getParameter('filter', null);

        if ($filter != null) {
            $this->getUser()->setFilter($filter);
        }
    }
}
