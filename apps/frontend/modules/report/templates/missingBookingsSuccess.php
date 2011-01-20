<?php use_helper('Text', 'timeboxx');?>

<?php use_javascript('jquery.min.js');?>
<?php use_javascript('jquery-ui.min.js');?>
<?php use_stylesheet('ui-lightness/jquery-ui.custom.css');?>

<?php $sf_response->setTitle('ProjectTimeBoxx - Report');?>

<div class="box box-100">
    <div class="boxin">
         <?php include_partial('headerbar');?>
         <div class="content">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="2">
                            <?php include_partial('filterbar', array('destination_action' => 'missingBookings', 'users' => $users, 'user' => $user, 'show_project_select' => false)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="tl" width="250px"><?php echo __('Date');?></td>
                        <td class="tl"><?php echo __('User');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($no_bookings_pager->getResults()->count() == 0):?>
                        <tr>
                            <td colspan="2">
                                <div class="msg msg-info"><p><?php echo __('There is no day without bookings');?></p></div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($no_bookings_pager->getResults() as $booking):?>
                            <tr>
                                <td class="tl"><a href="<?php echo url_for('timesheet/index?week='.week_number($booking->day).'&year='.date('Y', strtotime($booking->day)));?>"><?php echo format_date($booking->day, 'P');?></a></td>
                                <td class="tl"><?php echo $booking->User;?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php $current = $sf_request->getParameter('page', 1);?>
            <?php include_partial('missingPager', array('current'=>$current, 'no_bookings_pager'=>$no_bookings_pager));?>
        </div>
    </div>
</div>