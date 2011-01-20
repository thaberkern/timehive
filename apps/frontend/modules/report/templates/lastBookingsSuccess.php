<?php $sf_response->setTitle('ProjectTimeBoxx - Report');?>

<?php use_helper('Text');?>
<?php use_javascript('jquery.min.js');?>
<?php use_javascript('jquery-ui.min.js');?>
<?php use_stylesheet('ui-lightness/jquery-ui.custom.css');?>

<div class="box box-100">
    <div class="boxin">
        <?php include_partial('headerbar');?>
        <div class="content">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <?php include_partial('filterbar', array('destination_action' => 'lastBookings', 'users' => $users, 'user' => $user, 'show_project_select' => true, 'projects'=>$projects)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="tl"><?php echo __('Date');?></td>
                        <td class="tl"><?php echo __('Project');?></td>
                        <td class="tc"><?php echo __('Amount (hours)');?></td>
                        <td class="tc"><?php echo __('Type');?></td>
                        <td class="tl"><?php echo __('Comment');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($last_bookings_pager->getResults()->count() == 0):?>
                        <tr>
                            <td colspan="5">
                                 <div class="msg msg-info"><p><?php echo __('There are no bookings for this filter settings');?></p></div>
                            </td>
                        </tr>
                    <?php else:?>
                        <?php foreach($last_bookings_pager->getResults() as $booking):?>
                            <tr>
                                <td class="tl"><?php echo format_date($booking->itemdate, 'P');?></td>
                                <td class="tl"><?php echo $booking->Project;?></td>
                                <td class="tr"><?php echo $booking->value;?></td>
                                <td class="tc"><span class="tag tag-gray"><?php echo $booking->TimeItemType->name;?></span></td>
                                <td class="tl"><?php echo truncate_text($booking->note, 80);?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
            <?php $current = $sf_request->getParameter('page', 1);?>
            <?php include_partial('lastPager', array('current'=>$current, 'last_bookings_pager'=>$last_bookings_pager));?>
        </div>
        
    </div>
</div>