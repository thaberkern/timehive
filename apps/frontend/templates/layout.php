<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
<body>
    <div id="wrapper">
        <div id="top-menu">
            <div id="account">
                <?php if(sfContext::getInstance()->getUser()->isAuthenticated()):?>
                    <ul>
                        <li><a class="my-account" href="<?php echo url_for('account/show');?>">My account</a></li>
                        <li><a class="logout" href="<?php echo url_for('login/logout');?>">Sign out</a></li>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li><a class="login" href="<?php echo url_for('login/index');?>">Sign-In</a></li>
                    </ul>
                <?php endif;?>
            </div>
            <?php if(sfContext::getInstance()->getUser()->isAuthenticated()):?>
            <div id="loggedas">
                Logged in as <a href=""><?php echo sfContext::getInstance()->getUser()->getAttribute('username');?></a>
            </div>
            <?php endif; ?>
            <ul>
                <li><a href="<?php echo url_for('dashboard/index'); ?>">Dashboard</a></li>
                <?php if($sf_user->isAdministrator()):?><li><a href="<?php echo url_for('admin/index'); ?>">Administration</a></li><?php endif;?>
            </ul>
        </div>
        <div id="header">
            <h1>TimeBoxx</h1>
            <?php include_partial('global/mainMenu', array('module'=>$sf_request->getParameter('module')));?>
        </div>

        <div id="main" <?php include_slot('sidebarclass');?>>
        <div id="sidebar"><?php include_slot('sidebar');?></div>
        <div id="content">
        	<?php if (has_slot('contextual')):?>
            	<div class="contextual">
                	<?php include_slot('contextual');?>
                </div>
            <?php endif; ?>
            <?php echo $sf_data->getRaw('sf_content') ?>
        </div>
    </div>
    <div id="footer">
         Powered by <a href="http://www.sourceforge.net/projects/taskboxx/" target="_blank">TimeBoxx</a> V.<?php echo sfConfig::get('app_version');?>
    </div>
</div>
</body>
</html>

