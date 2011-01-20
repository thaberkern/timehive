<ul>
    <li><a <?php echo $sf_request->getParameter('module') == 'adminUser' ? 'class="active"' : ''; ?> href="<?php echo url_for('adminUser/list');?>" ><?php echo __('User');?></a></li>
    <li><a <?php echo $sf_request->getParameter('module') == 'adminRole' ? 'class="active"' : ''; ?> href="<?php echo url_for('adminRole/list');?>" ><?php echo __('Roles');?></a></li>
    <li><a <?php echo $sf_request->getParameter('module') == 'adminProject' ? 'class="active"' : ''; ?> href="<?php echo url_for('adminProject/list');?>"><?php echo __('Projects');?></a></li>
    <li><a <?php echo $sf_request->getParameter('module') == 'adminTimeItemType' ? 'class="active"' : ''; ?> href="<?php echo url_for('adminTimeItemType/list');?>"><?php echo __('Time item types');?></a></li>
    <li><a <?php echo $sf_request->getParameter('module') == 'adminSettings' ? 'class="active"' : ''; ?> href="<?php echo url_for('adminSettings/edit');?>" ><?php echo __('Settings');?></a></li>
</ul>