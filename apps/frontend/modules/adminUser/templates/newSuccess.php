<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <a class="button" href="<?php echo url_for('adminUser/new');?>"><?php echo __('New user');?>&nbsp;»</a>
            <?php include_partial('global/adminHeaderMenu');?>
        </div>
        <?php include_partial('form', array('form' => $form)) ?>
    </div>
</div>