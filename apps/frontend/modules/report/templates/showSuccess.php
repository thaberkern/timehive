<?php $sf_response->setTitle('Timeboxx - Report');?>

<?php slot('sidebar');?>
    <?php include_partial('filterBox', array('filter'=>$filter));?>
<?php end_slot(); ?>