<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('My Account Settings');?></h3>
        </div>
        <div id="box1-tabular" class="content">
            <form class="fields" action="<?php echo url_for('account/update');?>" method="post">
                <?php if ($sf_user->getFlash('saved.success', 0) != 0):?>
                    <div class="msg msg-ok">
                        <p><?php echo __('Saved element successfully');?>!</p>
                    </div>
                <?php endif;?>

                <?php include_partial('global/error_message', array('form'=>$form));?>
                
                <input type="hidden" name="sf_method" value="put" />
                <input type="hidden" name="user[username]" value="<?php echo $form->getObject()->username;?>" />

                <?php echo $form->renderHiddenFields(false) ?>
                
                <fieldset>
                    <legend><strong><?php echo __('User');?></strong></legend>
                    <?php echo $form['first_name']->renderLabel() ?>
                    <?php echo $form['first_name'] ?>

                    <?php echo $form['last_name']->renderLabel() ?>
                    <?php echo $form['last_name'] ?>

                    <?php echo $form['password']->renderLabel() ?>
                    <?php echo $form['password'] ?>

                    <?php echo $form['email']->renderLabel() ?>
                    <?php echo $form['email'] ?>
                </fieldset>
                <fieldset>
                    <legend><strong><?php echo __('Settings');?></strong></legend>
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
                </div>
            </form>
            
        </div>
    </div>
</div>