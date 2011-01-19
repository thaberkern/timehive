<div class="header">
    <h3><?php echo __('Reports');?></h3>
    <ul>
        <li><a href="<?php echo url_for('report/lastBookings');?>" <?php echo $sf_request->getParameter('action') == 'lastBookings' ? 'class="active"' : '';?>><?php echo __('Last Bookings');?></a></li>
        <li><a href="<?php echo url_for('report/missingBookings');?>" <?php echo $sf_request->getParameter('action') == 'missingBookings' ? 'class="active"' : '';?>><?php echo __('Missing Bookings');?></a></li>
        <li><a href="<?php echo url_for('report/projectTotal');?>" <?php echo $sf_request->getParameter('action') == 'projectTotal' ? 'class="active"' : '';?>><?php echo __('Project totals');?></a></li>
    </ul>
</div>
