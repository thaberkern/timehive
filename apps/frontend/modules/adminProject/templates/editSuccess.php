<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <a class="button" href="<?php echo url_for('adminProject/new');?>"><?php echo __('New project');?>&nbsp;»</a>
            <?php include_partial('global/adminHeaderMenu');?>
        </div>
        <?php include_partial('form', array('form' => $form, 'roles'=>$roles, 'users'=>$users, 'project_user'=>$project_user)) ?>
    </div>
</div>