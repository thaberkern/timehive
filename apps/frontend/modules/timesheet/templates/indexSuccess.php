<?php use_javascript('jquery.min.js');?>
<?php use_javascript('jquery-ui.min.js');?>
<?php use_javascript('jquery.tools.min.js');?>
<?php use_javascript('jquery.number_format.js');?>

<?php use_javascript('tb_timesheet.js');?>

<?php $sf_response->setTitle('Timeboxx - Timesheet');?>

<script type="text/javascript">
    $(document).ready(function() {
        for (wd=1; wd <=7; wd++) {
            recalcTotalHours(wd);
        }
    });
</script>

<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Timesheet');?></h3>
        </div>
        <div class="content" id="timesheet">
            <table class="calendar" cellspacing="0">
                <thead>
                    <tr>
                        <th class="tc month" colspan="8">
                            <a href="<?php echo url_for('timesheet/index?week='.($week-1));?>"><?php echo image_tag('cal-left.png'); ?></a>
                            <?php echo __('%1 to %2', array('%1'=>format_date($weekstart, 'p'),
                                                            '%2'=>format_date($weekstart + (6 * 24 * 60 * 60), 'p')));?>
                            
                            <a href="<?php echo url_for('timesheet/index?week='.($week+1));?>"><?php echo image_tag('cal-right.png'); ?></a>
                        </th>
                    </tr>
                    <tr>
                        <th class="tc"><?php echo __('Project');?></th>
                        <th class="tc" nowrap>
                            <?php echo __('Monday');?><br/>
                            <?php echo format_date($weekstart, 'p'); ?>
                        </th>
                        <th class="tc" nowrap>
                            <?php echo __('Tuesday');?><br/>
                            <?php echo format_date($weekstart + (1 * 24 * 60 * 60), 'p'); ?>
                        </th>
                        <th class="tc" nowrap>
                            <?php echo __('Wednesday');?><br/>
                            <?php echo format_date($weekstart + (2 * 24 * 60 * 60), 'p'); ?>
                        </th>
                        <th class="tc" nowrap>
                            <?php echo __('Thursday');?><br/>
                            <?php echo format_date($weekstart + (3 * 24 * 60 * 60), 'p'); ?>
                        </th>
                        <th class="tc" nowrap>
                            <?php echo __('Friday');?><br/>
                            <?php echo format_date($weekstart + (4 * 24 * 60 * 60), 'p'); ?>
                        </th>
                        <th class="tc" nowrap>
                            <?php echo __('Saturday');?><br/>
                            <?php echo format_date($weekstart + (5 * 24 * 60 * 60), 'p'); ?>
                        </th>
                        <th class="tc" nowrap>
                            <?php echo __('Sunday');?><br/>
                            <?php echo format_date($weekstart + (6 * 24 * 60 * 60), 'p'); ?>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td><?php echo __('Totals');?> (<?php echo __('hours');?>)</td>
                        <td><div id="total-1"></div></td>
                        <td><div id="total-2"></div></td>
                        <td><div id="total-3"></div></td>
                        <td><div id="total-4"></div></td>
                        <td><div id="total-5"></div></td>
                        <td><div id="total-6"></div></td>
                        <td><div id="total-7"></div></td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <input class="button altbutton" type="submit" value="<?php echo __('Speichern');?>" />
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($projects as $project):?>
                    <tr>
                        <td><?php echo $project->name;?></td>
                        <td>

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
   </div>
</div>
