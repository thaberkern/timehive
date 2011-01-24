<div class="box box-50 altbox">
    <div class="boxin">
        <div class="header">
            <h3><img src="<?php echo image_path('tb_logo_70.png');?>" alt="TimeHive" /></h3>
            <ul>
                <li><a href="<?php echo url_for('login/index');?>"><?php echo __('Login'); ?></a></li>
                <li><a class="active" href="#"><?php echo __('Lost password');?></a></li>
            </ul>
        </div>
        <div class="content">
            <form id="login-box" class="table" action="<?php echo url_for('account/createPassword'); ?>" method="post">
                <input type="hidden" name="token" value="<?php echo $token->getValue();?>"/>
                
                <div class="inner-form">
                    <?php if ($errors != ''): ?>
                        <div class="msg msg-error">
                            <p>
                                <?php echo $errors; ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <table cellspacing="0">
                        <tr>
                            <th><label for="password1"><?php echo __('Password') ?>:</label></th>
                            <td><input class="txt" type="password" id="new_password" name="new_password" /></td>
                        </tr>
                        <tr>
                            <th nowrap><label for="password2"><?php echo __('Confirm password') ?>:</label></th>
                            <td><input class="txt pwd" type="password" id="new_password_confirmation" name="new_password_confirmation" /></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td class="tr proceed">
                                <input class="button" type="submit" value="<?php echo __('Change Password'); ?> »" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>