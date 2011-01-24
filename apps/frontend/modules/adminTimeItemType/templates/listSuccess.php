<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <a class="button" href="<?php echo url_for('adminTimeItemType/new');?>"><?php echo __('New Time item type');?>&nbsp;»</a>
            <?php include_partial('global/adminHeaderMenu');?>
        </div>
        <div id="box1-tabular" class="content">
            <form class="plain" action="<?php echo url_for('adminTimeItemType/bulk');?>" method="post">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <td class="tc" width="20">&nbsp;</td>
                            <td class="tc"><?php echo __('Name');?></td>
                            <td class="tc"><?php echo __('Created at');?></td>
                            <td class="tc"><?php echo __('Default');?></td>
                            <td class="tc"><?php echo __('Actions');?></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <label>
                                    <?php echo __('with selected do');?>:
                                    <select name="tit-groupaction">
                                        <option value="delete"><?php echo __('delete');?></option>
                                    </select>
                                </label>
                                <input class="button altbutton" type="submit" value="<?php echo __('OK');?>" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1;?>
                        <?php foreach ($time_item_types as $type):?>
                            <tr <?php echo $i==1 ? 'class="first"' : '';?>>
                                <td class="tc"><input type="checkbox" id="tit-check-<?php echo $i;?>" name="tit-check[<?php echo $type->id;?>]" value="true" /></td>
                                <td class="tc"><?php echo $type->name;?></td>
                                <td class="tc"><?php echo format_date($type->created_at, 'P');?></td>
                                <td class="tc">
                                    <?php if ($type->default_item):?>
                                        <img src="<?php echo image_path('tick');?>" alt="<?php echo __('default');?>" />
                                    <?php endif;?>
                                </td>
                                <td class="tc">
                                    <ul class="actions">
                                        <li><a class="ico" href="<?php echo url_for('adminTimeItemType/edit?id='.$type->id);?>" title="<?php echo __('edit');?>"><img src="<?php echo image_path('edit');?>" alt="<?php echo __('edit');?>" /></a></li>
                                        <li><a class="ico" href="<?php echo url_for('adminTimeItemType/default?id='.$type->id);?>" title="<?php echo __('set as default');?>"><img src="<?php echo image_path('tick');?>" alt="<?php echo __('set as default');?>" /></a></li>
                                        <li><?php echo link_to(image_tag('delete', array('alt'=>'delete')), 'adminTimeItemType/delete?id='.$type->id, array('method' => 'delete', 'confirm' => 'Are you sure?', 'class'=>'ico', 'title'=>'delete')) ?></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>