<div id="h-wrap">
    <div class="inner">
        <h2>
            <span class="h-ico ico-<?php echo substr($sf_request->getParameter('module'), 0, 5) == 'admin' ? 'admin' : $sf_request->getParameter('module');?>">
                <span>
                    <?php
                        switch($sf_request->getParameter('module')) {
                            case 'dashboard': echo __('Dashboard'); break;
                            case 'timesheet': echo __('Timesheet'); break;
                            case 'report': echo __('Reports'); break;
                            default:
                                if (substr($sf_request->getParameter('module'), 0, 5)) {
                                    echo __('Administration'); 
                                }
                                break;
                        }
                    ?>
                </span>
            </span>
            <span class="h-arrow"></span>
        </h2>
        <ul class="clearfix">
            <?php if ($sf_request->getParameter('module') != 'dashboard'):?><li><a class="h-ico ico-dashboard" href="<?php echo url_for('dashboard/index');?>"><span><?php echo __('Dashboard');?></span></a></li><?php endif;?>
            <?php if ($sf_request->getParameter('module') != 'timesheet'):?><li><a class="h-ico ico-timesheet" href="<?php echo url_for('timesheet/index');?>"><span><?php echo __('Timesheet');?></span></a></li><?php endif;?>
            <?php if ($sf_request->getParameter('module') != 'report'):?><li><a class="h-ico ico-report" href="<?php echo url_for('report/index');?>"><span><?php echo __('Reports');?></span></a></li><?php endif;?>
            <?php if (substr($sf_request->getParameter('module'), 0, 5) != 'admin'):?><li><a class="h-ico ico-admin" href="<?php echo url_for('admin/index');?>"><span><?php echo __('Administration');?></span></a></li><?php endif;?>
        </ul>
    </div>
</div>
