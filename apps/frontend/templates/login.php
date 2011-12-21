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
            DD_belatedPNG.fix('h3 img');
        </script>
    <![endif]-->
</head>
<body id="login">
    <?php echo $sf_data->getRaw('sf_content') ?>
    <div id="footer">
         Powered by <a href="http://www.timehive.net" target="_blank">TimeHive</a> V.<?php echo sfConfig::get('app_version');?>
    </div>
</body>
</html>

