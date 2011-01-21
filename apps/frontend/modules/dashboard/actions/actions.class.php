<?php

/**
 * dashboard actions.
 *
 * * @package    sutimeboxx
 * @subpackage dashboard
 * @author     Timo Haberkern
 */
class dashboardActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->last_items = TimeLogItemTable::getInstance()
                                ->getLastTimeItems(
                                        $this->getUser()->getId(),
                                        $request->getParameter('timeitemcount', 10));

        $this->no_bookings_pager = new sfDoctrinePager('MissingTimeItemEntry', 10);
        $this->no_bookings_pager->setQuery(MissingTimeItemEntryTable::getInstance()
                                            ->getForUserQuery($this->getUser()->getId()));
        $this->no_bookings_pager->setPage($request->getParameter('missing_page', 1));
        $this->no_bookings_pager->init();

        $time_range = $request->getParameter('total_filter_by', 'this_month');

        $this->project_totals = ProjectTable::getInstance()
                                ->getTimeTotals($this->getUser()->getId(), $time_range);
    }


    public function executeIgnoreMissingBooking(sfWebRequest $request)
    {
        $missing_item = MissingTimeItemEntryTable::getInstance()->find($request->getParameter('id'));
        if ($missing_item) {
            $missing_item->ignored_at = date('Y-m-d H:i:s');
            $missing_item->save();
        }

        $this->redirect('dashboard/index?missing_page='.$request->getParameter('missing_page'));
    }
}
