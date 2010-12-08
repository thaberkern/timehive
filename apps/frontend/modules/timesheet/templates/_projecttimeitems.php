<?php $project_time_items = $time_items->find($project->getId(), $weekstart + ( ($weekday-1) * 24 * 60 * 60)); ?>

<!-- Ensure that there is a null value in the array, so that there will
     be created a empty input box even if there are no saved entries -->
<?php if (count($project_time_items) == 0) $project_time_items = array(null);?>

<!-- create a input and combo box for every item -->
<?php foreach ($project_time_items as $time_item): ?>
    <?php include_partial('timeitem', array('weekday'=>$weekday,
                                            'project'=>$project,
                                            'time_item'=>$time_item,
                                            'item_types'=>$item_types));?>
<?php endforeach;?>