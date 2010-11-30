<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="fields" action="<?php echo url_for('adminTimeItemType/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>
    <fieldset>
        <legend><strong><?php echo __('Time item type');?></strong></legend>
        <?php if ($sf_user->getFlash('saved.success', 0) != 0):?>
            <div class="msg msg-ok">
                <p><?php echo __('Saved element successfully');?>!</p>
            </div>
        <?php endif;?>

        <?php include_partial('global/error_message', array('form'=>$form));?>
        
        <?php echo $form['name']->renderLabel() ?>
        <?php echo $form['name'] ?>
        
        <div class="sep">
            <input class="button" type="submit" value="<?php echo __('Save');?>" />
            <input class="button altbutton" type="button" onClick="location.href='<?php echo url_for('adminTimeItemType/list') ?>'" value="<?php echo __('Back to list');?>" />
        </div>
    </fieldset>
</form>