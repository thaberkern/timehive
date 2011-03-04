<?php $project_time_items = $time_items->find($project->getId(), $weekstart + ( ($weekday-1) * 24 * 60 * 60)); ?>

<!-- Ensure that there is a null value in the array, so that there will
     be created a empty input box even if there are no saved entries -->
<?php if (count($project_time_items) == 0) $project_time_items = array(null);?>

<div id="timeitem_container_<?php echo $weekday.'_'.$project->id;?>" style="float: left;">
<?php foreach ($project_time_items as $time_item): ?>
    <?php include_partial('timeitem', array('weekday'=>$weekday,
                                            'weekstart'=>$weekstart,
                                            'project'=>$project,
                                            'time_item'=>$time_item,
                                            'item_types'=>$item_types,
                                            'default_item_type'=>$default_item_type,
                                            'default_item_type_name'=>$default_item_type_name));?>

<?php endforeach;?>
</div>
<a class="add" href="javascript:addTimeEntry(<?php echo $weekday;?>, <?php echo $project->getId();?>)"><?php echo image_tag('add');?></a>

