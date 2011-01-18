<div class="content" style="width: 600px">
    <table cellspacing="0">
        <thead>
            <tr>
                <td class="tc" width="140"><?php echo __('Username');?></td>
                <td class="tc"><?php echo __('Role(s)');?></td>
                <td class="tc" width="60"><?php echo __('Actions');?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user):?>
            <tr>
                <td><?php echo $user->username;?></td>
                <td>
                    <?php $index = 0;?>
                    <?php foreach($user->getProjectRoles($project->id) as $role):?>
                        <?php if ($index++ != 0):?>,&nbsp;<?php endif;?> <?php echo $role->name;?>
                    <?php endforeach;?>
                </td>
                <td>
                     <ul class="actions">
                        <li><a class="ico" href="#" title="edit"><img src="<?php echo image_path('edit');?>" alt="<?php echo __('edit');?>" /></a></li>
                        <li><a class="ico" href="#" title="delete"><img src="<?php echo image_path('delete');?>" alt="<?php echo __('delete');?>" /></a></li>
                     </ul>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>