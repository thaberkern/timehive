<?php use_helper('Form', 'Object'); ?>

<tr>
    <td colspan="2">
        <form class="plain" action="<?php echo url_for('report/'.$destination_action);?>" method="post">
            <input type="hidden" name="page" value="1"/>
            <label>
                <?php echo __('Show');?>
                <select name="pagesize">
                    <option value="10" <?php echo $sf_request->getParameter('pagesize', 20) == 10? 'selected' : '';?>>10</option>
                    <option value="20" <?php echo $sf_request->getParameter('pagesize', 20) == 20? 'selected' : '';?>>20</option>
                    <option value="50" <?php echo $sf_request->getParameter('pagesize', 20) == 50? 'selected' : '';?>>50</option>
                </select>
                <?php echo __('entries');?>
            </label>
            &nbsp;&nbsp;&nbsp;
            <label>
                <?php echo __('Date from');?>:
            </label>
            <input type="text" id="date-from" name="filter[dateFrom]" style="width:70px" value="<?php $sf_user->getAttribute('report_filter_datefrom');?>"/>
            &nbsp;
            <label>
                <?php echo __('to');?>:
            </label>
            <input type="text" id="date-to" name="filter[dateTo]" style="width:70px" value="<?php $sf_user->getAttribute('report_filter_dateto');?>" />
            &nbsp;&nbsp;&nbsp;
            <label>
                <?php echo __('User');?>:
                <select name="filter[user]" <?php echo $sf_user->getAttribute('overlord', false) == true ? '' : 'disabled';?>>
                    <option value="-1"><?php echo __('All');?></option>
                    <?php echo objects_for_select($users, 'getId', '__toString', isset($filter)&&$filter['user']!=-1 ? $filter['user'] : $user->id); ?>
                </select>
            </label>
            &nbsp;&nbsp;&nbsp;
            <?php if ($show_project_select):?>
                <select name="filter[project]">
                    <option value="-1"><?php echo __('All');?></option>
                    <?php echo objects_for_select($projects, 'getId', '__toString', isset($filter)&&$filter['project']!=-1 ? $filter['project'] : null); ?>
                </select>
                &nbsp;&nbsp;&nbsp;
            <?php endif;?>

            <input class="button altbutton" type="submit" value="<?php echo __('Filter');?>" />
        </form>
    </td>
</tr>

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