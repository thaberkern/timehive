<?php if(!isset($time_item)) $time_item = null;?>

<?php $unique_id = uniqid();?>

<div class="timeitem" id="value_<?php echo $weekday;?>_<?php echo $project->id;?>" >
    <p onclick="editTimeItem('<?php echo $unique_id;?>', <?php echo $weekday;?>)" id="container_<?php echo $unique_id;?>"><?php echo $time_item!= null ? $time_item->getValue() : ""; ?></p>
    <input class="value_<?php echo $weekday;?>"
                               type="hidden"
                               id="time_hidden_<?php echo $unique_id;?>"
                               name="time[<?php echo $weekday;?>][<?php echo $project->getId(); ?>][time][]"
                               value="<?php echo $time_item!= null ? $time_item->getValue() : ""; ?>" />
    <input type="hidden"
           id="type_hidden_<?php echo $unique_id;?>"
           name="time[<?php echo $weekday;?>][<?php echo $project->getId(); ?>][type][]"
           value="<?php echo $time_item!= null ? $time_item->TimeItemType->name : ""; ?>"/>

    <input type="hidden"
           id="comment_hidden_<?php echo $unique_id;?>"
           name="time[<?php echo $weekday;?>][<?php echo $project->getId(); ?>][comment][]"
           value="<?php echo $time_item!= null ? $time_item->getNote() : ""; ?>"/>
</div>
