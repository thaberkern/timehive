<h2><?php echo __('Administration');?></h2>

<p class="icon icon-project"><a href="<?php echo url_for('project/index');?>"><?php echo __('Projects');?></a></p>
<p class="icon icon-users"><a href="<?php echo url_for('user/index');?>"><?php echo __('Users');?></a></p>
<p class="icon icon-items"><a href="<?php echo url_for('enumeration/index');?>"><?php echo __('Timeitem types');?></a></p>
<p class="icon icon-settings"><a href="<?php echo url_for('settings/index');?>"><?php echo __('Settings');?></a></p>

<?php slot('sidebarclass'); ?>
class="nosidebar"
<?php end_slot();?>