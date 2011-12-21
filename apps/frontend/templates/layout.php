<?php use_helper('Gravatar');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php include_stylesheets() ?>
    <link rel="stylesheet" type="text/css" href="/css/themes/<?php echo $sf_user->getAttribute('theme', 'green');?>.css" media="screen, projection, tv" />
    <!--[if lte IE 7.0]><link rel="stylesheet" type="text/css" href="/css/themes/ie.css" media="screen, projection, tv" /><![endif]-->
    <!--[if IE 8.0]>
        <style type="text/css">
            form.fields fieldset {margin-top: -10px;}
        </style>
    <![endif]-->

    <?php include_javascripts() ?>
    <!-- Adding support for transparent PNGs in IE6: -->
    <!--[if lte IE 6]>
        <script type="text/javascript" src="js/ddpng.js"></script>
        <script type="text/javascript">
            DD_belatedPNG.fix('#nav #h-wrap .h-ico');
            DD_belatedPNG.fix('.ico img');
            DD_belatedPNG.fix('.msg p');
            DD_belatedPNG.fix('table.calendar thead th.month a img');
            DD_belatedPNG.fix('table.calendar tbody img');
        </script>
    <![endif]-->
    <script type="text/javascript" src="/js/tb_init.js"></script>
</head>
<body>
    <div id="header">
        <div class="inner-container clearfix">
            <h1 id="logo">
                <img src="<?php echo image_path('tb_logo.png');?>" alt="TimeHive" />
            </h1>
            <div id="userbox" >
                <div class="inner" style="background: url(<?php echo gravatar_url($sf_user->getAttribute('email'), 32);?>) no-repeat scroll 16px 16px transparent;">
                    <strong><?php echo sfContext::getInstance()->getUser()->getAttribute('username');?></strong>
                    <p style="color: white; font-size: 8pt; margin-bottom: 3px;"><?php echo $sf_user->getAttribute('account_name');?></p>
                    <ul class="clearfix">
                        <li><a href="<?php echo url_for('account/index');?>"><?php echo __('My account');?></a></li>
                        <li><a href="<?php echo url_for('login/logout');?>"><?php echo __('Sign out');?></a></li>
                    </ul>
                </div>
            </div><!-- #userbox -->
        </div><!-- .inner-container -->
    </div><!-- #header -->
    <div id="nav">
        <div class="inner-container clearfix">
            <?php include_partial('global/mainMenu');?>
        </div>
    </div>
    <div id="container">
        <div class="inner-container">
            <?php echo $sf_data->getRaw('sf_content') ?>
        </div>
    </div>
    <div id="footer">
         Powered by <a href="http://www.timehive.net" target="_blank">TimeHive</a> V.<?php echo sfConfig::get('app_version');?>
    </div>
</body>
</html>

