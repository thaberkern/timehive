<?php use_javascript('jquery.min.js');?>
<?php use_javascript('jquery-ui.min.js');?>
<?php use_javascript('jquery.form.js');?>
<?php use_javascript('jquery.validate.js');?>
<?php use_javascript('additional-methods.js');?>
<?php use_javascript('jquery.tools.min.js');?>
<?php use_javascript('jquery.number_format.js');?>

<?php use_javascript('tb_timesheet.js');?>
<?php use_stylesheet('ui-lightness/jquery-ui.custom.css');?>

<?php $sf_response->setTitle('TimeHive - Timesheet');?>

<script type="text/javascript">
    var currentUniqueId = null;
    var currentWeekday = 0;
    
    $(document).ready(function() {
        
        for (wd=1; wd <=7; wd++) {
            recalcTotalHours(0, null, wd);
        }
        
        var editForm = $("#edit-form").validate({
	    errorContainer: "#errorblock-div1, #errorblock-div2",
	    errorLabelContainer: "#errorblock-div2 ul",
	    wrapper: "li",
	    
            // rules/messages are for the validation
            rules: {
	        'form-amount': {
	            required: true,
                    number: true,
                    max: 24
                }
	    },
	    messages: {
	        'form-amount': {
	            required: "<?php echo __('Please enter an amount of time');?>",
                    number: "<?php echo __('Please enter a valid number');?>",
                    max: "<?php echo __('The maximum value is 24 hours');?>"
                }
	    },
            
            submitHandler: function(form) {
	        // dont send the form, update the field instead
                $('#time_hidden_'+currentUniqueId).val($('#form-amount').val());
                $('#type_hidden_'+currentUniqueId).val($('#form-type :selected').text());
                $('#comment_hidden_'+currentUniqueId).val($('#form-comment').val());
                
                $('#container_'+currentUniqueId).html($().number_format($('#form-amount').val(), {numberOfDecimals: 2, decimalSeparator: '.', thousandsSeparator: ','}));
                recalcTotalHours(currentUniqueId, $('#time_hidden_'+currentUniqueId), currentWeekday);
        
                $("#edit-modal-form").dialog('close'); 
                editForm.resetForm(); 
            }
	}); 
        
        var modalEditWindow = $("#edit-modal-form").dialog({
	   autoOpen: false,
	   height: 300,
	   width: 300,
	   modal: true,
           resizable: false,
	   buttons: {
	      '<?php echo __('Save');?>': function() 
		  { 
                    $("#edit-form").submit(); 
		  },
	      Cancel: function() 
		  { 
		    $(this).dialog('close'); 
                    editForm.resetForm(); 
		  }
	   }
	});
    });
    
    function editTimeItem(unique_id, weekday) {
        currentUniqueId = unique_id;
        currentWeekday = weekday;
        
        // getting the value of the field and add it to the form
        $('#form-amount').val($('#time_hidden_'+currentUniqueId).val());
        $('#form-type').val($('#type_hidden_'+currentUniqueId).val());
        $('#form-comment').val($('#comment_hidden_'+currentUniqueId).val());
        
        // open the form
        $("#edit-modal-form").dialog('open');
        
    }

    function addTimeEntry(weekday, project_id) {
        new $.ajax(
                {
                  url:'<?php echo url_for('timesheet/field');?>',
                  data: {'project_id': project_id, 'weekday': weekday, 'weekstart': <?php echo $weekstart;?> },
                  success: function(html) {
                      $('#timeitem_container_'+weekday+'_'+project_id).append(html);
                  }
                });
    }
</script>

<form id="timetrack" class="simple" onSubmit="return hasNoTotalOverMaxErrors();" action="<?php echo url_for('timesheet/update');?>" method="POST">
    <div class="box box-100">
        <div class="boxin">
            <div class="header">
                <h3><?php echo __('Timesheet');?></h3>
            </div>
            <div class="content" id="timesheet">
                <?php if ($sf_user->getFlash('saved.success', 0) != 0):?>
                    <div class="msg msg-ok">
                        <p><?php echo __('Saved element(s) successfully');?>!</p>
                    </div>
                <?php endif;?>
                <div id="warn-total-over-max" class="msg msg-error" style="display: none;">
                    <p><?php echo __('You have days with more than 24 hours worktime! You can not save this timesheet until this problem is resolved');?>!</p>
                </div>
                <table class="calendar" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="tc month" colspan="8">
                                <?php $prev_week = date('W', $weekstart - (7 * 24 * 60 * 60)); ?>
                                <?php $prev_year = date('Y', $weekstart - (7 * 24 * 60 * 60)); ?>
                                <a href="<?php echo url_for('timesheet/index?week='.$prev_week.'&year='.$prev_year);?>"><?php echo image_tag('cal-left.png'); ?></a>
                                <?php echo __('%1 to %2', array('%1'=>format_date($weekstart, 'p'),
                                                                '%2'=>format_date($weekstart + (6 * 24 * 60 * 60), 'p')));?>

                                <?php $next_week = date('W', $weekstart + (7 * 24 * 60 * 60)); ?>
                                <?php $next_year = date('Y', $weekstart + (7 * 24 * 60 * 60)); ?>
                                <a href="<?php echo url_for('timesheet/index?week='.$next_week.'&year='.$next_year);?>"><?php echo image_tag('cal-right.png'); ?></a>
                            </th>
                        </tr>
                        <tr>
                            <th class="tc"><?php echo __('Project');?></th>
                            <?php if (($account->workingdays & 1) == 1):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Monday');?><br/>
                                    <?php echo format_date($weekstart, 'd'); ?>
                                </th>
                            <?php endif;?>
                            <?php if (($account->workingdays & 2) == 2):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Tuesday');?><br/>
                                    <?php echo format_date($weekstart + (1 * 24 * 60 * 60), 'd'); ?>
                                </th>
                            <?php endif;?>
                            <?php if (($account->workingdays & 4) == 4):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Wednesday');?><br/>
                                    <?php echo format_date($weekstart + (2 * 24 * 60 * 60), 'd'); ?>
                                </th>
                            <?php endif;?>
                            <?php if (($account->workingdays & 8) == 8):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Thursday');?><br/>
                                    <?php echo format_date($weekstart + (3 * 24 * 60 * 60), 'd'); ?>
                                </th>
                            <?php endif;?>
                            <?php if (($account->workingdays & 16) == 16):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Friday');?><br/>
                                    <?php echo format_date($weekstart + (4 * 24 * 60 * 60), 'd'); ?>
                                </th>
                            <?php endif;?>
                            <?php if (($account->workingdays & 32) == 32):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Saturday');?><br/>
                                    <?php echo format_date($weekstart + (5 * 24 * 60 * 60), 'd'); ?>
                                </th>
                            <?php endif;?>
                            <?php if (($account->workingdays & 64) == 64):?>
                                <th class="tc" nowrap>
                                    <?php echo __('Sunday');?><br/>
                                    <?php echo format_date($weekstart + (6 * 24 * 60 * 60), 'd'); ?>
                                </th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td><?php echo __('Totals');?> (<?php echo __('hours');?>)</td>
                            <?php if (($account->workingdays & 1) == 1):?><td class="tl"><div id="total-1" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                            <?php if (($account->workingdays & 2) == 2):?><td class="tl"><div id="total-2" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                            <?php if (($account->workingdays & 4) == 4):?><td class="tl"><div id="total-3" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                            <?php if (($account->workingdays & 8) == 8):?><td class="tl"><div id="total-4" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                            <?php if (($account->workingdays & 16) == 16):?><td class="tl"><div id="total-5" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                            <?php if (($account->workingdays & 32) == 32):?><td class="tl"><div id="total-6" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                            <?php if (($account->workingdays & 64) == 64):?><td class="tl"><div id="total-7" style="width: 50px; text-align: right;"></div></td><?php endif;?>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <input class="button altbutton" id ="form-submit-btn" type="submit" value="<?php echo __('Save');?>" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($projects as $project):?>
                            <?php if ($user->hasProjectCredential(Credential::TIMETRACKING_EDIT, $project->id)):?>
                            <tr>
                                <td class="ttop"><?php echo $project->name;?></td>
                                <?php $days = array(1=>1, 2=>2, 3=>4, 4=>8, 5=>16, 6=>32, 7=>64);?>

                                <?php foreach ($days as $day=>$code):?>
                                    <?php if (($account->workingdays & $code) == $code):?>
                                        <td id="cell_<?php echo $project->getId();?>_<?php echo $day;?>" class="tc ttop" nowrap>
                                            <?php include_partial('projecttimeitems', array('weekday'=>$day,
                                                            'weekstart' => $weekstart,
                                                            'project'=>$project,
                                                            'time_items'=>$time_items,
                                                            'item_types'=>$item_types,
                                                            'default_item_type'=>$default_item_type,
                                                            'default_item_type_name'=>$default_item_type_name));?>
                                        </td>
                                    <?php endif;?>
                                <?php endforeach;?>
                                
                            </tr>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
       </div>
    </div>
    <input type="hidden" name="weekstart" value="<?php echo $weekstart;?>" />
    <input type="hidden" name="year" value="<?php echo $year;?>" />
    <input type="hidden" name="week" value="<?php echo $week;?>" />
</form>

<div id="edit-modal-form" title="<?php echo __('Edit time entry');?>">
    <div class="ui-widget ui-helper-hidden" id="errorblock-div1">
        <div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;" id="errorblock-div2" style="display:none;"> 
            <p>
                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span> 
                <?php echo __('Errors detected!');?>
            </p>
            <ul></ul>
        </div>
    </div>
    <form action="#" name="edit-form" id="edit-form" method="POST">
        <table class="timelog-edit">
            <tbody>
                <tr>
                    <th>
                        <label for="timeitem"><?php echo __('Amount'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="form-amount" id="form-amount" class="text ui-widget-content ui-corner-all" />&nbsp;<?php echo __('hour(s)');?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="type"><?php echo __('Type'); ?></label>
                    </th>
                    <td>
                        <select name="form-type" id="form-type" class="ui-widget-content">
                            <?php echo objects_for_select($item_types, 'getName', null, $default_item_type_name); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th nowrap><label for="form-comment"><?php echo __('Comment'); ?></label></th>
                    <td colspan="3">
                        <textarea id="form-comment" class="text ui-widget-content ui-corner-all"></textarea>
                    </td>
                </tr>   
            </tbody>
        </table>
    </form>    
</div>