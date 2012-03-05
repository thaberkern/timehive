<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <a class="button" href="<?php echo url_for('adminUser/new');?>"><?php echo __('New user');?>&nbsp;»</a>
            <?php include_partial('global/adminHeaderMenu');?>
        </div>
        <?php if ($sf_user->getFlash('error.license_count', 0) != 0):?>
            <div class="msg msg-error">
                <p><?php echo __('You have reached the maximum amount of users for your type of account. Please upgrade if you want to add another user.');?>:</p>
            </div>
        <?php endif; ?>
        <div id="box1-tabular" class="content">
            <form class="plain" action="<?php echo url_for('adminUser/bulk');?>"
                  onsubmit="return confirm('<?php echo __('Do you really want to execute this bulk operation?');?>')"
                  method="post">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <td class="tc" width="20">&nbsp;</td>
                            <td class="tc"><?php echo __('Username');?></td>
                            <td class="tc"><?php echo __('Name');?></td>
                            <td class="tc"><?php echo __('Status');?></td>
                            <td class="tc"><?php echo __('Created at');?></td>
                            <td class="tc"><?php echo __('Actions');?></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <label>
                                    <?php echo __('with selected do');?>:
                                    <select name="usr-groupaction">
                                        <option value="deactivate"><?php echo __('deactivate');?></option>
                                        <option value="delete"><?php echo __('delete');?></option>
                                    </select>
                                </label>
                                <input class="button altbutton" type="submit" value="<?php echo __('OK');?>" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1;?>
                        <?php foreach ($users as $user):?>
                            <tr <?php echo $i==1 ? 'class="first"' : '';?>>
                                <td class="tc"><input type="checkbox" id="usr-check-<?php echo $i;?>" name="usr-check[<?php echo $user->id;?>]" value="true" /></td>
                                <td class="tc"><?php echo $user->username;?></td>
                                <td class="tc"><?php echo $user->last_name.' '.$user->first_name;?></td>
                                <td class="tc">
                                    <?php if ($user->administrator):?>
                                        <?php echo image_tag('user_red', array('title'=>__('Administrator'), 'alt'=>__('Administrator')));?>
                                    <?php endif;?>

                                    <?php if ($user->boss_mode):?>
                                        <?php echo image_tag('user_suit', array('title'=>__('Boss-Mode'), 'alt'=>__('Boss-Mode')));?>
                                    <?php endif;?>

                                    <?php if ($user->locked):?>
                                        <?php echo image_tag('lock', array('title'=>__('Locked'), 'alt'=>'Locked'));?>
                                    <?php endif;?>
                                    &nbsp;
                                </td>
                                <td class="tc"><?php echo format_date($user->created_at, 'P');?></td>
                                <td class="tc">
                                    <ul class="actions">
                                        <li><a class="ico" href="<?php echo url_for('adminUser/edit?id='.$user->id);?>" title="<?php echo __('edit');?>"><img src="<?php echo image_path('edit');?>" alt="<?php echo __('edit');?>" /></a></li>
                                        <li>
                                        <?php if ($user->locked):?>
                                            <?php echo link_to(image_tag('lock_delete', array('alt'=>'unlock')), 'adminUser/unlock?id='.$user->id, array('class'=>'ico', 'title'=>__('unlock'))) ?>
                                        <?php else:?>
                                            <?php echo link_to(image_tag('lock', array('alt'=>'lock')), 'adminUser/lock?id='.$user->id, array('class'=>'ico', 'title'=>__('lock'))) ?>
                                        <?php endif; ?>
                                        </li>
                                        <li><?php echo link_to(image_tag('delete', array('alt'=>'delete')), 'adminUser/delete?id='.$user->id, array('method' => 'delete', 'confirm' => 'Are you sure?', 'class'=>'ico', 'title'=>__('delete'))) ?></li>
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