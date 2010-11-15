<?php use_helper('Text', 'timeboxx');?>

<?php $sf_response->setTitle('Timeboxx - '.__('Dashboard'));?>

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
                                        <option value="10" <?php echo $sf_request->getParameter('timeitemcount', 10) == 10? 'selected' : '';?>>10</option>
                                        <option value="20" <?php echo $sf_request->getParameter('timeitemcount', 20) == 20? 'selected' : '';?>>20</option>
                                        <option value="50" <?php echo $sf_request->getParameter('timeitemcount', 50) == 50? 'selected' : '';?>>50</option>
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
                <li>
                    <strong>SmartDispatch</strong>
                    <span>20 <?php echo ('hour(s)');?></span>
                </li>
                <li>
                    <strong>SmartDispatch</strong>
                    <span>20 <?php echo ('hour(s)');?></span>
                </li>
                <li>
                    <strong>SmartDispatch</strong>
                    <span>20 <?php echo ('hour(s)');?></span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="box box-50 altbox"><!-- box 50% width -->
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
                            <a href="<?php echo url_for('timesheet/index?week='.week_number($booking->day));?>"><?php echo format_date($booking->day, 'P');?></a>
                            <span><a href="<?php echo url_for('dashboard/ignoreMissingBooking?id='.$booking->id);?>">ignore</a></span>
                        </li>
                    <?php endforeach;?>
                </ul>

                <?php if ($no_bookings_pager->haveToPaginate()):?>
                    <div class="pagination">
                        <ul>
                            <li><a href="#">previous</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><strong>3</strong></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">next</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
    </div>
</div>
