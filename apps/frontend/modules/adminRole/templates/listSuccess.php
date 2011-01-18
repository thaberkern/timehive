<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <a class="button" href="<?php echo url_for('adminRole/new');?>"><?php echo __('New Role');?>&nbsp;»</a>
            <ul>
                <li><a href="<?php echo url_for('adminUser/list');?>"><?php echo __('User');?></a></li>
                <li><a href="#" class="active"><?php echo __('Roles');?></a></li>
                <li><a href="<?php echo url_for('adminProject/list');?>"><?php echo __('Projects');?></a></li>
                <li><a href="<?php echo url_for('adminTimeItemType/list');?>"><?php echo __('Time item types');?></a></li>
            </ul>
        </div>
        <div id="box1-tabular" class="content">
            <form class="plain" action="<?php echo url_for('adminRole/bulk');?>" method="post">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <td class="tc" width="20">&nbsp;</td>
                            <td class="tc"><?php echo __('Name');?></td>
                            <td class="tc"><?php echo __('Created at');?></td>
                            <td class="tc"><?php echo __('Actions');?></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <label>
                                    <?php echo __('with selected do');?>:
                                    <select name="rl-groupaction">
                                        <option value="delete"><?php echo __('delete');?></option>
                                    </select>
                                </label>
                                <input class="button altbutton" type="submit" value="<?php echo __('OK');?>" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1;?>
                        <?php foreach ($roles as $role):?>
                            <tr <?php echo $i==1 ? 'class="first"' : '';?>>
                                <td class="tc"><input type="checkbox" id="rl-check-<?php echo $i;?>" name="rl-check[<?php echo $role->id;?>]" value="true" /></td>
                                <td class="tc"><?php echo $role->name;?></td>
                                <td class="tc"><?php echo format_date($role->created_at, 'P');?></td>
                                <td class="tc">
                                    <ul class="actions">
                                        <li><a class="ico" href="<?php echo url_for('adminRole/edit?id='.$role->id);?>" title="edit"><img src="<?php echo image_path('edit');?>" alt="<?php echo __('edit');?>" /></a></li>
                                        <li><?php echo link_to(image_tag('delete', array('alt'=>'delete')), 'adminRole/delete?id='.$role->id, array('method' => 'delete', 'confirm' => 'Are you sure?', 'class'=>'ico', 'alt'=>'delete')) ?></li>
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