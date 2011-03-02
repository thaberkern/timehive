<?php use_helper('Form', 'Object'); ?>


<form class="plain" action="<?php echo url_for('report/'.$destination_action);?>" method="post">
    <input type="hidden" name="page" value="1"/>
    <?php if ($show_pagesize_select):?>
        <label>
            <?php echo __('Show');?>
            <select name="pagesize">
                <option value="10" <?php echo $sf_request->getParameter('pagesize', 20) == 10? 'selected' : '';?>>10</option>
                <option value="20" <?php echo $sf_request->getParameter('pagesize', 20) == 20? 'selected' : '';?>>20</option>
                <option value="50" <?php echo $sf_request->getParameter('pagesize', 20) == 50? 'selected' : '';?>>50</option>
            </select>
            <?php echo __('entries');?>
        </label>
        &nbsp;&nbsp;
    <?php endif; ?>
    <label>
        <?php echo __('Date from');?>:
    </label>
    <input type="text" id="date-from" name="filter[dateFrom]" style="width:70px" value="<?php echo $sf_user->getAttribute('date-from', '', 'report_filter');?>"/>
    &nbsp;
    <label>
        <?php echo __('to');?>:
    </label>
    <input type="text" id="date-to" name="filter[dateTo]" style="width:70px" value="<?php echo $sf_user->getAttribute('date-to', '', 'report_filter');?>" />
    &nbsp;&nbsp;
    <label>
        <?php echo __('User');?>:
    </label>
    <select style="width: 170px;" name="filter[user]" >
        <?php if ($sf_user->getAttribute('overlord', false)):;?>><option value="-1"><?php echo __('All');?></option><?php endif;?>
        
        <?php $current_user_id = $sf_user->getAttribute('uid'); ?>
        <?php echo objects_for_select($users, 'getId', '__toString', $sf_user->getAttribute('user', $current_user_id, 'report_filter')!=-1 ? $sf_user->getAttribute('user', $current_user_id, 'report_filter') : null); ?>
    </select>
    &nbsp;&nbsp;
    <?php if ($show_project_select):?>
        <label>
            <?php echo __('Project');?>:
        </label>
        <select name="filter[project]">
            <option value="-1"><?php echo __('All');?></option>
            <?php echo objects_for_select($projects, 'getId', '__toString', $sf_user->getAttribute('project', -1, 'report_filter')!=-1 ? $sf_user->getAttribute('project', '', 'report_filter') : null); ?>
        </select>
        &nbsp;&nbsp;&nbsp;
    <?php endif;?>

    <input class="button altbutton" type="submit" value="<?php echo __('Filter');?>" />
    &nbsp;&nbsp;&nbsp;
    <input type="button" onclick="location.href='<?php echo url_for('report/clearFilter?target='.$destination_action.'&pagesize='.$sf_request->getParameter('pagesize', 20).'&page='.$sf_request->getParameter('page', 1));?>'" class="button altbutton" value="<?php echo __('Clear');?>" />
</form>

<script type="text/javascript">
	$(function() {
		var dates = $( "#date-from, #date-to" ).datepicker({
			defaultDate: "-2m",
			changeMonth: true,
			numberOfMonths: 3,
                        dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				var option = this.id == "date-from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" );
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
</script>