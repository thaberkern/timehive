<?php $sf_response->setTitle('TimeBoxx - Report');?>

<div class="box box-100">
    <div class="boxin">
        <?php include_partial('headerbar');?>
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
                    
                </tbody>
            </table>
            <?php $current = $sf_request->getParameter('missing_page', 1);?>
            <?php include_partial('dashboard/missingPager', array('current'=>$current, 'no_bookings_pager'=>$no_bookings_pager));?>
        </div>
        
    </div>
</div>