<form action="<?php echo url_for('timesheet/index');?>" id="filter-form" method="POST">
    <h3><?php echo __('Filter'); ?></h3>
    <table>
        <tr>
            <td><?php echo __('Name');?>:</td>
            <td><input name="filter[name]" type="text" value="<?php echo isset($filter) ? $filter['name'] : ''; ?>"></td>
        </tr>
        <tr>
            <td><?php echo __('Number');?>:</td>
            <td><input name="filter[number]" type="text" value="<?php echo isset($filter) ? $filter['number'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo __('Group');?>:</td>
            <td><select name="filter[group]"><option value="-1"><?php echo __('All');?></option></select></td>
        </tr>
        <tr>
            <td><?php echo __('User');?>:</td>
            <td><select name="filter[user]"><option value="-1"><?php echo __('All');?></option></select></td>
        </tr>
        <tr>
            <td><?php echo __('Archived');?>:</td>
            <td><input type="checkbox" name="filter[archived]" value="1" <?php echo isset($filter)&&array_key_exists('archived', $filter) ? 'checked' : '';?> /></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input type="submit" value="<?php echo __('OK');?>"></td>
        </tr>
    </table>
</form>