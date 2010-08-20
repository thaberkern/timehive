<div id="main-menu">
    <ul>
        <li><a class="timesheet <?php echo $module=='timesheet'?'selected':'';?>" href="<?php echo url_for('timesheet/index');?>">Timesheet</a></li>
        <li><a class="reports <?php echo $module=='report'?'selected':'';?>" href="<?php echo url_for('report/show');?>">Reports</a></li>
        <li><a class="settings <?php echo $module=='settings'?'selected':'';?>" href="<?php echo url_for('report/show');?>">Settings</a></li>
    </ul>
</div>