<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="fields" action="<?php echo url_for('adminUser/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>
    <fieldset>
        <legend><strong><?php echo __('User');?></strong></legend>
        <?php if ($sf_user->getFlash('saved.success', 0) != 0):?>
            <div class="msg msg-ok">
                <p><?php echo __('Saved element successfully');?>!</p>
            </div>
        <?php endif;?>

        <?php include_partial('global/error_message', array('form'=>$form));?>

        <?php echo $form['first_name']->renderLabel() ?>
        <?php echo $form['first_name'] ?>

        <?php echo $form['last_name']->renderLabel() ?>
        <?php echo $form['last_name'] ?>

        <?php echo $form['username']->renderLabel() ?>
        <?php echo $form['username'] ?>

        <?php echo $form['password']->renderLabel() ?>
        <?php echo $form['password'] ?>

        <?php echo $form['email']->renderLabel() ?>
        <?php echo $form['email'] ?>  
    </fieldset>
    <fieldset>
        <legend><strong><?php echo __('Settings');?></strong></legend>

        <?php echo $form['administrator']->renderLabel() ?>
        <?php echo $form['administrator'] ?>
        <small>User has administration rights?</small>

        <?php echo $form['settings']['theme']->renderLabel() ?>
        <?php echo $form['settings']['theme'] ?>

        <?php echo $form['settings']['culture']->renderLabel() ?>
        <?php echo $form['settings']['culture'] ?>

        <?php echo $form['settings']['reminder']->renderLabel() ?>
        <?php echo $form['settings']['reminder'] ?>
        <small>Send reminder E-Mails once a day if the user has not entered time-data for the day</small>
    </fieldset>
        <div class="sep">
            <input class="button" type="submit" value="<?php echo __('Save');?>" />
            <input class="button altbutton" type="button" onClick="location.href='<?php echo url_for('adminUser/list') ?>'" value="<?php echo __('Back to list');?>" />
        </div>
    
</form>