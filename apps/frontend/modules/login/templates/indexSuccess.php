<?php $sf_response->setTitle('TimeBoxx - '.__('Login'));?>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($sf_user->getFlash('send_pwd_failure', false) == false):?>
        $('#login .content#lost-password-box').hide();
        <?php else: ?>
        $('#login .content#login-box').hide();
        <?php endif;?>
            
        $('#login .header ul a').click(function(){
            $('#login .header ul a').removeClass('active');
            $(this).addClass('active'); // make clicked tab active
            $('#login .content').hide(); // hide all content
            $('#login').find('#' + $(this).attr('rel')).show(); // and show content related to clicked tab
            return false;
        });
    });
</script>

<div id="login">
<div class="box box-50 altbox">
    <div class="boxin">
        <div class="header">
            <h3><img src="<?php echo image_path('tb_logo_70.png');?>" alt="TimeBoxx" /></h3>
            <ul>
                <li><a rel="login-box" href="#" <?php echo $sf_user->getFlash('send_pwd_failure', false) == false ? 'class="active"' : '';?>><?php echo __('Login'); ?></a></li>
                <li><a rel="lost-password-box" <?php echo $sf_user->getFlash('send_pwd_failure', false) != false ? 'class="active"' : '';?> href="#"><?php echo __('Lost password');?></a></li>
            </ul>
        </div>
        <div id="login-box" class="content">
            <form id="login-box" class="table" action="<?php echo url_for('login/login'); ?>" method="post">
                <div class="inner-form">
                    <?php if ($sf_user->getFlash('login_failure', false) == true): ?>
                        <div class="msg msg-error">
                            <p>
                                <strong><?php echo __('Login failed!') ?></strong><br/>
                                <?php echo __('Either your password or username was wrong. Please try again!') ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php if ($sf_user->getFlash('login_failure.locked', false) == true): ?>
                        <div class="msg msg-error">
                            <p>
                                <strong><?php echo __('Login failed!') ?></strong><br/>
                                <?php echo __('Your user is locked, you can not use TimeBoxx anymore!') ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php if ($sf_user->getFlash('notice_message', false) != false): ?>
                        <div class="msg msg-info">
                            <p>
                                <?php echo $sf_user->getFlash('notice_message', '') ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <table cellspacing="0">
                        <tr>
                            <th><label for="username"><?php echo __('Username') ?>:</label></th>
                            <td><input class="txt" type="text" id="username" name="username" /></td>
                        </tr>
                        <tr>
                            <th><label for="password"><?php echo __('Password') ?>:</label></th>
                            <td><input class="txt pwd" type="password" id="password" name="password" /></td>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <td><label class="check"><input class="check" type="checkbox" id="autologin" name="autologin" value="1"/><?php echo __('Keep logged in');?></label></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td class="tr proceed">
                                <input class="button" type="submit" value="<?php echo __('Login'); ?> »" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
        <div id="lost-password-box" class="content">
            <form class="table" action="<?php echo url_for('account/sendPassword');?>" 
                  method="post" enctype="multipart/form-data">
                
                <div class="inner-form">
                    <?php if ($sf_user->getFlash('send_pwd_failure', false) != false):?>
                        <div class="msg msg-warn">
                            <p><?php echo $sf_user->getFlash('send_pwd_failure');?></p>
                        </div>
                    <?php else:?>
                        <div class="msg msg-info">
                            <p><?php echo __('Please enter your E-Mail address. You will receive an e-mail with detailed instructions.');?></p>
                        </div>
                    <?php endif;?>
                    <table cellspacing="0">
                        <tr>
                            <th nowrap><label for="email"><?php echo __('E-Mail-Address') ?>:</label></th>
                            <td><input class="txt" type="text" id="email" name="email" /></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td class="tr proceed">
                                <input class="button" type="submit" value="<?php echo __('Send Request'); ?> »" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
</div>