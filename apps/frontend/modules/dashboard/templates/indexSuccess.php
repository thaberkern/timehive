<?php use_helper('Text', 'timeboxx');?>

<?php $sf_response->setTitle('TimeHive - '.__('Dashboard'));?>

<div class="box box-50"><!-- box 50% width -->
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('My last time bookings');?></h3>
        </div>
        <div class="content">
            <table cellspacing="0">
                <thead><!-- universal table heading -->
                    <tr>
                        <td class="tc"><?php echo __('Date');?></td>
                        <th><?php echo __('Project');?></th>
                        <td class="tc"><?php echo __('Amount (hours)');?></td>
                        <td class="tc"><?php echo __('Type');?></td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <form class="plain" action="<?php echo url_for('dashboard/index');?>" method="post">
                                <label>
                                    <?php echo __('Show');?>
                                    <select name="timeitemcount">
                                        <option value="10" <?php echo $sf_request->getParameter('timeitemcount', 20) == 10? 'selected' : '';?>>10</option>
                                        <option value="20" <?php echo $sf_request->getParameter('timeitemcount', 20) == 20? 'selected' : '';?>>20</option>
                                        <option value="50" <?php echo $sf_request->getParameter('timeitemcount', 20) == 50? 'selected' : '';?>>50</option>
                                    </select>
                                    <?php echo __('entries');?>
                                </label>
                                <input class="button altbutton" type="submit" value="<?php echo __('OK');?>" />
                            </form>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach($last_items as $time_item):?>
                        <tr>
                            <td class="tc"><?php echo format_date($time_item->itemdate, 'p');?></td>
                            <th><?php echo $time_item->Project->name;?></th>
                            <td class="tc"><?php echo $time_item->value;?></td>
                            <td class="tc"><span class="tag tag-gray"><?php echo $time_item->TimeItemType->name;?></span></td>
                        </tr>
                    <?php endforeach;?>                    
                </tbody>
            </table>
        </div>
    </div>    
</div>
<div class="box box-50"><!-- box 50% width -->
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('My total time per project');?></h3>
        </div>
        <div class="content">
            <ul class="simple">
                <?php foreach ($project_totals as $project): ?>
                    <li>
                        <strong><?php echo $project->name;?></strong>
                        <span><?php echo $project->total;?> <?php echo ('hour(s)');?></span>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="content">
            <table cellspacing="0">
                <tfoot>
                    <tr>
                        <td>
                            <form class="plain" action="<?php echo url_for('dashboard/index');?>" method="post">
                                <label>
                                    <?php echo __('Show for');?>
                                    <select name="total_filter_by">
                                        <option value="overall" <?php echo $sf_request->getParameter('total_filter_by', 'this_month') == 'overall' ? 'selected' : '';?>><?php echo __('overall');?></option>
                                        <option value="this_week" <?php echo $sf_request->getParameter('total_filter_by', 'this_month') == 'this_week' ? 'selected' : '';?>><?php echo __('this week');?></option>
                                        <option value="last_week" <?php echo $sf_request->getParameter('total_filter_by', 'this_month') == 'last_week' ? 'selected' : '';?>><?php echo __('last week');?></option>
                                        <option value="this_month" <?php echo $sf_request->getParameter('total_filter_by', 'this_month') == 'this_month' ? 'selected' : '';?>><?php echo __('this month');?></option>
                                        <option value="last_month" <?php echo $sf_request->getParameter('total_filter_by', 'this_month') == 'last_month' ? 'selected' : '';?>><?php echo __('last month');?></option>
                                    </select>
                                </label>
                                <input class="button altbutton" type="submit" value="<?php echo __('OK');?>" />
                            </form>
                        </td>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
    <br/>
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Days without bookings');?></h3>
        </div>
        <div class="content">
            <?php if ($no_bookings_pager->getResults()->count() == 0):?>
                <div class="msg msg-info"><p><?php echo __('There is no day without bookings');?></p></div>
            <?php else: ?>
                <ul class="simple">
                    <?php foreach($no_bookings_pager->getResults() as $booking):?>
                        <li>
                            <a href="<?php echo url_for('timesheet/index?week='.week_number($booking->day).'&year='.date('Y', strtotime($booking->day)));?>"><?php echo format_date($booking->day, 'P');?></a>
                            <span><a href="<?php echo url_for('dashboard/ignoreMissingBooking?id='.$booking->id.'&missing_page='.$sf_request->getParameter('missing_page'));?>">ignore</a></span>
                        </li>
                    <?php endforeach;?>
                </ul>
                <?php $current = $sf_request->getParameter('missing_page', 1);?>
                <?php include_partial('missingPager', array('current'=>$current, 'no_bookings_pager'=>$no_bookings_pager));?>
            <?php endif; ?>
        </div>
        
    </div>
</div>
