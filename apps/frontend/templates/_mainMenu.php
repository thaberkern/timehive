<div id="main-menu">
    <ul>
        <li><a class="timesheet <?php echo $module=='timesheet'?'selected':'';?>" href="<?php echo url_for('timesheet/index');?>"><?php echo __('Timesheet');?></a></li>
        <li><a class="reports <?php echo $module=='report'?'selected':'';?>" href="<?php echo url_for('report/show');?>"><?php echo __('Reports');?></a></li>
        <li><a class="settings <?php echo $module=='setting'?'selected':'';?>" href="<?php echo url_for('setting/index');?>"><?php echo __('Settings');?></a></li>
    </ul>
</div>