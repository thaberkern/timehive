<div class="box box-100">
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('Administration');?></h3>
            <ul>
                <li><a href="<?php echo url_for('adminUser/list');?>"><?php echo __('User');?></a></li>
                <li><a href="<?php echo url_for('adminRole/list');?>"><?php echo __('Roles');?></a></li>
                <li><a href="#" class="active"><?php echo __('Projects');?></a></li>
                <li><a href="<?php echo url_for('adminTimeItemType/list');?>"><?php echo __('Time item types');?></a></li>
            </ul>
        </div>
        <div class="content">
            
        </div>
    </div>
</div>