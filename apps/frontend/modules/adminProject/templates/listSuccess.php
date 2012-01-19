<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <a class="button" href="<?php echo url_for('adminProject/new');?>"><?php echo __('New project');?>&nbsp;»</a>
            <?php include_partial('global/adminHeaderMenu');?>
        </div>
        <?php if ($sf_user->getFlash('error.license_count', 0) != 0):?>
            <div class="msg msg-error">
                <p><?php echo __('You have reached the maximum amount of projects for your type of account. Please upgrade if you want to add another project.');?>:</p>
            </div>
        <?php endif; ?>
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
                            <td class="tc"><?php echo __('Locked');?></td>
                            <td class="tc"><?php echo __('Actions');?></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <label>
                                    <?php echo __('with selected do');?>:
                                    <select name="prj-groupaction">
                                        <option value="lock"><?php echo __('lock');?></option>
                                        <option value="delete"><?php echo __('delete');?></option>
                                    </select>
                                </label>
                                <input class="button altbutton" onclick="return window.confirm('Are you sure?');" type="submit" value="<?php echo __('OK');?>" />
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
                                    <?php if ($project->deactivated):?>
                                        <?php echo image_tag('lock', array('alt'=>__('Locked')));?>
                                    <?php else: ?>
                                        &nbsp;
                                    <?php endif;?>
                                </td>
                                <td class="tc">
                                    <ul class="actions">
                                        <li><a class="ico" href="<?php echo url_for('adminProject/edit?id='.$project->id);?>" title="<?php echo __('edit');?>"><img src="<?php echo image_path('edit');?>" alt="<?php echo __('edit');?>" /></a></li>
                                        <li>
                                        <?php if ($project->deactivated):?>
                                            <?php echo link_to(image_tag('lock_delete', array('alt'=>'unlock')), 'adminProject/unlock?id='.$project->id, array('class'=>'ico', 'title'=>__('unlock'))) ?>
                                        <?php else:?>
                                            <?php echo link_to(image_tag('lock', array('alt'=>'lock')), 'adminProject/lock?id='.$project->id, array('class'=>'ico', 'title'=>__('lock'))) ?>
                                        <?php endif; ?>
                                        </li>
                                        <li><?php echo link_to(image_tag('delete', array('alt'=>'delete')), 'adminProject/delete?id='.$project->id, array('method' => 'delete', 'confirm' => 'Are you sure?', 'class'=>'ico', 'title'=>__('delete'))) ?></li>
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