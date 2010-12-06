<?php use_helper('Object'); ?>

<?php if(!isset($time_item)) $time_item = null;?>

<input class="validate['number'] value_<?php echo $weekday;?>" name="time[<?php echo $weekday;?>][<?php echo $project->getId(); ?>][time][]" type="text" size="3" value="<?php echo $time_item!= null ? $time_item->getValue() : ""; ?>" onchange="recalcTotalHours(<?php echo $weekday;?>)"> <?php echo __('hours'); ?>
&nbsp;
<select name="time[<?php echo $weekday;?>][<?php echo $project->getId(); ?>][type][]">
    <?php echo objects_for_select($item_types, 'getName', null, $time_item!= null ? $time_item->getType()->getName() : null); ?>
</select>
<a href="javascript:addTimeEntry(<?php echo $weekday;?>, <?php echo $project->getId();?>)"><?php echo image_tag('add');?></a>
<br/>