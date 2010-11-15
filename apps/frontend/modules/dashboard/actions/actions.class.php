<?php

/**
 * dashboard actions.
 *
 * @package    timeboxx
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

        $this->project_totals = ProjectTable::getInstance()
                                ->getTimeTotals($this->getUser()->getId());
    }

}
