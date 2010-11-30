<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <ul>
                <li><a href="<?php echo url_for('adminUser/list');?>"><?php echo __('User');?></a></li>
                <li><a href="<?php echo url_for('adminRole/list');?>"><?php echo __('Roles');?></a></li>
                <li><a href="#" class="active"><?php echo __('Projects');?></a></li>
                <li><a href="<?php echo url_for('adminTimeItemType/list');?>"><?php echo __('Time item types');?></a></li>
            </ul>
        </div>
        <div id="box1-tabular" class="content">
            <form class="plain" action="<?php echo url_for('adminProject/bulk');?>" method="post">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <td class="tc" width="20">&nbsp;</td>
                            <td class="tc"><?php echo __('Name');?></td>
                            <td class="tc"><?php echo __('Number');?></td>
                            <td class="tc"><?php echo __('Owner');?></td>
                            <td class="tc"><?php echo __('Created at');?></td>
                            <td class="tc"><?php echo __('Actions');?></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <label>
                                    <?php echo __('with selected do');?>:
                                    <select name="prj-groupaction">
                                        <option value="archive"><?php echo __('archive');?></option>
                                        <option value="delete"><?php echo __('delete');?></option>
                                    </select>
                                </label>
                                <input class="button altbutton" type="submit" value="<?php echo __('OK');?>" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1;?>
                        <?php foreach ($projects as $project):?>
                            <tr <?php echo $i==1 ? 'class="first"' : '';?>>
                                <td class="tc"><input type="checkbox" id="prj-check-<?php echo $i;?>" name="prj-check[<?php echo $project->id;?>]" value="true" /></td>
                                <td class="tc"><?php echo $project->name;?></td>
                                <td class="tc"><?php echo $project->number;?></td>
                                <td class="tc"><?php echo $project->Owner->username;?></td>
                                <td class="tc"><?php echo format_date($project->created_at, 'P');?></td>
                                <td class="tc">
                                    <ul class="actions">
                                        <li><a class="ico" href="<?php echo url_for('adminProject/edit?id='.$project->id);?>" title="edit"><img src="<?php echo image_path('edit');?>" alt="<?php echo __('edit');?>" /></a></li>
                                        <li><?php echo link_to(image_tag('database', array('alt'=>'archive')), 'adminProject/archive?id='.$project->id, array('confirm' => 'Are you sure?', 'class'=>'ico', 'alt'=>'archive')) ?></li>
                                        <li><?php echo link_to(image_tag('delete', array('alt'=>'delete')), 'adminProject/delete?id='.$project->id, array('method' => 'delete', 'confirm' => 'Are you sure?', 'class'=>'ico', 'alt'=>'delete')) ?></li>
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