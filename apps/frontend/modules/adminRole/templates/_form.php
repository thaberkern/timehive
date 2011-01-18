<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
    function checkAll(checked) {
        $('input[id^=credential][type=checkbox]').attr('checked', checked);
    }
</script>

<form class="fields" action="<?php echo url_for('adminRole/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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

    <label for="role[name]"><?php echo __('Rolename');?>:</label>
    <input type="text" class="txt" name="role[name]" value="<?php echo $role->name;?>"/>
    <br/><br/>
    <?php foreach ($credentials as $key=>$group): ?>
    <fieldset>
        <legend><?php echo __($key);?></legend>
        <?php foreach ($group as $credential):?>
            <label class="floating">
                <input type="checkbox" id="credential[<?php echo $credential->id;?>]"
                       name="credential[<?php echo $credential->id;?>]"
                       <?php echo $role->hasCredential($credential->getName()) ? 'checked="checked"' : '';?>
                       /> <?php echo __($credential->name);?>
            </label>
        <?php endforeach;?>
    </fieldset>

    <?php endforeach;?>
    <a onclick="checkAll(true); return false;" href="#"><?php echo __('Check all');?></a> |
    <a onclick="checkAll(false); return false;" href="#"><?php echo __('Uncheck all');?></a>
    <br/><br/>
    <div class="sep">
        <input class="button" type="submit" value="<?php echo __('Save');?>" />
        <input class="button altbutton" type="button" onClick="location.href='<?php echo url_for('adminRole/list') ?>'" value="<?php echo __('Back to list');?>" />
    </div>
</form>