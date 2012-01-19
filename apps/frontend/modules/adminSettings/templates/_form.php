<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


<form class="fields" action="<?php echo url_for('adminSettings/update?id='.$form->getObject()->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <input type="hidden" name="sf_method" value="put" />
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($sf_user->getFlash('saved.success', 0) != 0):?>
        <div class="msg msg-ok">
            <p><?php echo __('Saved element successfully');?>!</p>
        </div>
    <?php endif;?>

    <?php include_partial('global/error_message', array('form'=>$form));?>

    <fieldset>
        <legend><strong><?php echo __('Account-Plan');?></strong></legend>

        <strong><?php echo $form['name']->renderLabel() ?></strong>
        <?php echo $form['name'] ?>
        <br/><br/>
        <label><strong><?php echo __('Account valid until');?></strong></label>
        <?php if ($form->getObject()->valid_until == '' || $form->getObject()->valid_until == null): ?>
            <?php echo __('unlimited');?>
        <?php else:?>
            <?php echo format_date($form->getObject()->valid_until, 'F'); ?>
        <?php endif;?>
        <br/><br/>
        <label><strong><?php echo __('Account plan type');?></strong></label>
        <?php echo __('account.'.$form->getObject()->type); ?>
    </fieldset>
    
    <fieldset>
        <legend><strong><?php echo __('Workingday');?></strong></legend>
        <strong><?php echo $form['max_hours_per_day']->renderLabel() ?></strong>
        <?php echo $form['max_hours_per_day'] ?>
        <small><?php echo 'Workingtime + overtime';?></small>
        <strong><?php echo $form['default_working_time']->renderLabel() ?></strong>
        <?php echo $form['default_working_time'] ?>
        <small><?php echo 'Default value for users without own workingtime settings';?></small>
    </fieldset>

    <?php $workingdays = $form->getObject()->workingdays;?>
    <fieldset>
        <legend><strong><?php echo __('Workingdays');?></strong></legend>
        <input type="checkbox" name="workingday[1]" <?php echo ($workingdays & 1) == 1 ? 'checked' : '';?> /><?php echo __('Monday');?><br/>
        <input type="checkbox" name="workingday[2]" <?php echo ($workingdays & 2) == 2 ? 'checked' : '';?>/><?php echo __('Tuesday');?><br/>
        <input type="checkbox" name="workingday[4]" <?php echo ($workingdays & 4) == 4 ? 'checked' : '';?>/><?php echo __('Wednesday');?><br/>
        <input type="checkbox" name="workingday[8]" <?php echo ($workingdays & 8) == 8 ? 'checked' : '';?>/><?php echo __('Thursday');?><br/>
        <input type="checkbox" name="workingday[16]" <?php echo ($workingdays & 16) == 16 ? 'checked' : '';?>/><?php echo __('Friday');?><br/>
        <input type="checkbox" name="workingday[32]" <?php echo ($workingdays & 32) == 32 ? 'checked' : '';?>/><?php echo __('Saturday');?><br/>
        <input type="checkbox" name="workingday[64]" <?php echo ($workingdays & 64) == 64 ? 'checked' : '';?>/><?php echo __('Sunday');?><br/>
    </fieldset>

    <div class="sep">
        <input class="button" type="submit" value="<?php echo __('Save');?>" />
    </div>
</form>
