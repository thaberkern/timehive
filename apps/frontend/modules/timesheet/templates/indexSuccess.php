<?php use_javascript('jquery.min.js');?>
<?php use_javascript('jquery-ui.min.js');?>
<?php use_stylesheet('custom-theme/jquery-ui-1.8.4.custom.css');?>

<?php $sf_response->setTitle('Timeboxx - Timesheet');?>

<?php slot('sidebar');?>
    <h3><?php echo __('Filter'); ?></h3>
    <div id="datepicker"></div>
<?php end_slot();?>

<script type="text/javascript">
$(function() {
    $("#datepicker").datepicker({
                        showWeek: true,
                        firstDay: 1,
                        onSelect: function(dateText, instance) {
                            //var calculateWeek = $("#datepicker").datepicker( "option", "calculateWeek" );

                            currentWeek = $.datepicker.iso8601Week(new Date(dateText));
                            location.href="<?php echo url_for('timesheet/index');?>/"+currentWeek;
                        },
                        dateFormat: 'yy-mm-dd',
                        defaultDate: '<?php echo $weekstart;?>'
                    });
});
</script>
