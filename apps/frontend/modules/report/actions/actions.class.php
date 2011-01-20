<?php

/**
 * report actions.
 *
 * @package    projecttimeboxx
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
        $filter = $this->checkFilter($request);

        $account_id = $this->getUser()->getAttribute('account_id');
        $this->users = UserTable::getInstance()
                                    ->findByAccountId($account_id);

        $this->user = UserTable::getInstance()->find($this->getUser()->getAttribute('uid'));
        $this->projects = $this->user->Projects;
        
        $pagesize = $request->getParameter('pagesize', 20);
        $this->last_bookings_pager = new sfDoctrinePager('TimeLogItem', $pagesize);
        $this->last_bookings_pager->setQuery(TimeLogItemTable::getInstance()
                                            ->getFilterQuery($filter, $this->getUser()->getAttribute('uid')));
        $this->last_bookings_pager->setPage($request->getParameter('page', 1));
        $this->last_bookings_pager->init();

        $this->last_items = TimeLogItemTable::getInstance()
                                ->getLastTimeItems(
                                        $this->getUser()->getId(),
                                        $request->getParameter('timeitemcount', 10));
    }

    public function executeMissingBookings(sfWebRequest $request)
    {
        $filter = $this->checkFilter($request);

        $pagesize = $request->getParameter('pagesize', 20);
        $this->no_bookings_pager = new sfDoctrinePager('MissingTimeItemEntry', $pagesize);
        $this->no_bookings_pager->setQuery(MissingTimeItemEntryTable::getInstance()
                                            ->getFilterQuery($filter, $this->getUser()->getAttribute('uid')));
        $this->no_bookings_pager->setPage($request->getParameter('page', 1));
        $this->no_bookings_pager->init();

        $account_id = $this->getUser()->getAttribute('account_id');
        $this->users = UserTable::getInstance()
                                    ->findByAccountId($account_id);

        $this->user = UserTable::getInstance()->find($this->getUser()->getAttribute('uid'));
    }

    public function executeProjectTotal(sfWebRequest $request)
    {
        $filter = $this->checkFilter($request);

        $account_id = $this->getUser()->getAttribute('account_id');
        $this->users = UserTable::getInstance()
                                    ->findByAccountId($account_id);

        $this->user = UserTable::getInstance()->find($this->getUser()->getAttribute('uid'));
        $this->projects = $this->user->Projects;

        $this->project_totals = TimeLogItemTable::getInstance()->prepareTotalReport($filter, $this->projects, $this->user);
    }

    public function executeClearFilter(sfWebRequest $request)
    {
        $this->getUser()->clearFilter('report_filter');
        $this->redirect('report/'.$request->getParameter('target').'?page='.$request->getParameter('page', 1).'&pagesize='.$request->getParameter('pagesize', 20));
    }

    protected function checkFilter(sfWebRequest $request)
    {
        $filter = $request->getParameter('filter', null);
        if ($filter != null) {
            $this->getUser()->setFilter($filter, 'report_filter');
        }
        
        return $filter = $this->getUser()->getFilter('report_filter');
    }
}
