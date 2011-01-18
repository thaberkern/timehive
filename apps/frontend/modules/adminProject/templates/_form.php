<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="fields" action="<?php echo url_for('adminProject/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($sf_user->getFlash('saved.success', 0) != 0):?>
        <div class="msg msg-ok">
            <p><?php echo __('Saved element successfully');?>!</p>
        </div>
    <?php endif;?>

    <?php include_partial('global/error_message', array('form'=>$form));?>

    <fieldset>
        <legend><strong><?php echo __('Project');?></strong></legend>
        <?php echo $form['name']->renderLabel() ?>
        <?php echo $form['name'] ?>

        <?php echo $form['number']->renderLabel() ?>
        <?php echo $form['number'] ?>

        <?php echo $form['deactivated']->renderLabel() ?>
        <?php echo $form['deactivated'] ?>

        <?php echo $form['owner_id']->renderLabel() ?>
        <?php echo $form['owner_id'] ?>

    </fieldset>

    <fieldset>
        <legend><strong><?php echo __('Userroles');?></strong></legend>
        <?php if($form->getObject()->isNew()):?>
            <div class="msg msg-warn">
                <p><?php echo __('You need to save a project before you can add user with their roles');?></p>
            </div>
        <?php else: ?>
            <?php include_partial('projectroles', array('users'=>$project_user, 'project'=>$form->getObject()));?>
        <?php endif;?>
    </fieldset>

    <div class="sep">
        <input class="button" type="submit" value="<?php echo __('Save');?>" />
        <input class="button altbutton" type="button" onClick="location.href='<?php echo url_for('adminProject/list') ?>'" value="<?php echo __('Back to list');?>" />
    </div>
</form>