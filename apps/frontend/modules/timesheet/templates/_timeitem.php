<?php use_helper('Form', 'Object'); ?>

<?php if(!isset($time_item)) $time_item = null;?>

<?php $unique_id = uniqid();?>

<div class="timeitem" id="value_<?php echo $weekday;?>_<?php echo $project->id;?>" >
    <p id="container_<?php echo $unique_id;?>"><?php echo $time_item!= null ? $time_item->getValue() : ""; ?></p>
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

    <div id="form_<?php echo $unique_id;?>" style="display: none;">
        <table class="timelog-edit">
            <tbody>
                <tr>
                    <th>
                        <label><?php echo __('Amount');?></label>:
                    </th>
                    <td>
                        <input style="width: 40px" type="text"
                               id="time_<?php echo $unique_id;?>"
                               value="<?php echo $time_item!= null ? $time_item->getValue() : ""; ?>"
                               onchange="validate('<?php echo $unique_id;?>', this, <?php echo $weekday;?>)">&nbsp;<?php echo __('hours');?>
                        <br/>
                        <div style="display: none;" id="validation_error_<?php echo $unique_id;?>" class="msg msg-error">
                            <p><?php echo __('Not a valid decimal number');?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php echo __('Type');?></label>:
                    </th>
                    <td>
                        <select id="type_<?php echo $unique_id;?>">
                            <?php echo objects_for_select($item_types, 'getName', null, $time_item!= null ? $time_item->TimeItemType->getName() : null); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php echo __('Comment');?></label>:
                    </th>
                    <td>
                        <textarea id="comment_<?php echo $unique_id;?>"><?php echo $time_item!= null ? $time_item->getNote() : ""; ?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function validate(unique_id, field, weekday) {
        var time = jQuery.trim(""+field.value);
        if (time.match(/^[0-9]+(\.[0-9][0-9]?)?$/)) {
            $('#validation_error_'+unique_id).hide();
        }
        else {
            field.value = 0;
            $('#validation_error_'+unique_id).show();
        }
    }

    <?php if ($weekstart + ( ($weekday-1) * 24 * 60 * 60) > time() ):?>
        $('#container_<?php echo $unique_id;?>').qtip({
        content: {
            title: {
                text: '<?php echo __('Edit Timelog entry');?>',
                button: true
            },
            text: '<?php echo __('You can not track time entry for future dates');?>'
        },
        show: {
            event: 'click',
            solo: true
        },
        position: {
            <?php if ($weekday <= 5):?>
                my: 'left center',
                at: 'right center',
            <?php else: ?>
                my: 'right center',
                at: 'left center',
            <?php endif;?>
            target: $('#container_<?php echo $unique_id;?>')
        },
        style: {
            classes: 'ui-tooltip-rounded'
        }
    });
    <?php else: ?>
    $('#container_<?php echo $unique_id;?>').qtip({
        content: {
            title: {
                text: '<?php echo __('Edit Timelog entry');?>',
                button: true
            },
            text: $('#form_<?php echo $unique_id;?>')
        },
        show: {
            event: 'click',
            solo: true,
            modal: true
        },
        hide: false,
        position: {
            <?php if ($weekday <= 5):?>
                my: 'left center',
                at: 'right center',
            <?php else: ?>
                my: 'right center',
                at: 'left center',
            <?php endif;?>
            target: $('#container_<?php echo $unique_id;?>')
        },
        style: {
            classes: 'ui-tooltip-light ui-tooltip-modal ui-tooltip-rounded'
        },
        events: {
          hide: function(event, api) {
             $('#time_hidden_<?php echo $unique_id;?>').val($('#time_<?php echo $unique_id;?>').val());
             $('#type_hidden_<?php echo $unique_id;?>').val($('#type_<?php echo $unique_id;?> :selected').text());
             $('#comment_hidden_<?php echo $unique_id;?>').val($('#comment_<?php echo $unique_id;?>').val());

             $('#container_<?php echo $unique_id;?>').html($().number_format($('#time_<?php echo $unique_id;?>').val(), {numberOfDecimals: 2, decimalSeparator: '.', thousandsSeparator: ','}));
             recalcTotalHours('<?php echo $unique_id;?>', $('#time_hidden_<?php echo $unique_id;?>'), <?php echo $weekday;?>);
          }
       }

    });
    <?php endif;?>
</script>