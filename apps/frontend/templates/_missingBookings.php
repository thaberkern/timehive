<html>
<head>
<style>
body {
  font-family: Verdana, sans-serif;
  font-size: 0.8em;
  color:#484848;
}
h1, h2, h3 { font-family: "Trebuchet MS", Verdana, sans-serif; margin: 0px; }
h1 { font-size: 1.2em; }
h2, h3 { font-size: 1.1em; }
a, a:link, a:visited { color: #2A5685;}
a:hover, a:active { color: #c61a1a; }
a.wiki-anchor { display: none; }
hr {
  width: 100%;
  height: 1px;
  background: #ccc;
  border: 0;
}
.footer {
  font-size: 0.8em;
  font-style: italic;
}
</style>
</head>
<body>

    <h1>TimeHive - <?php echo $i18n->__('Missing Booking');?></h1>
    <p>
        <?php echo $i18n->__('Hello %1% %2%,',
                            array('%1%'=>$user->first_name,
                                  '%2%'=>$user->last_name));?>
        <br/><br/>
        <strong>
            <?php echo $i18n->__('you have not entered a time entry for the %1% so far.',
                            array('%1%'=>format_date(time())));?>
        </strong>
        <br/><br/>
        <?php echo $i18n->__('You can enter your data under:');?>&nbsp;
        <a href="<?php echo sfConfig::get('app_frontend_url'); ?>/timesheet/index">TimeHive</a>
    </p>
    <hr/>
    <p class="footer">Powered by <a href="http://www.timehive.com">TimeHive</a> V.<?php echo sfConfig::get('app_version');?></p>

</body>
</html>