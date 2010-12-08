<?php use_helper('Form', 'Object'); ?>

<?php if(!isset($time_item)) $time_item = null;?>

<input class="value_<?php echo $weekday;?>" onclick="changeTimeLogItem(<?php echo $weekday;?>, <?php echo $project->id; ?>)" readonly="readonly" name="time[<?php echo $weekday;?>][<?php echo $project->getId(); ?>][time][]" type="text" style="width:70px" value="<?php echo $time_item!= null ? $time_item->getValue() : ""; ?>" onchange="recalcTotalHours(<?php echo $weekday;?>)">

<a href="javascript:addTimeEntry(<?php echo $weekday;?>, <?php echo $project->getId();?>)"><?php echo image_tag('add');?></a>
<br/>