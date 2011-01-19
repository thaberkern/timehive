<div class="fields">
    <label for="username"><?php echo __('User');?>:</label>&nbsp;
    <?php echo $user->username;?>
    <input type="hidden" name="username_update" id="username_update" value="<?php echo $user->id;?>"/>

    <br/><br/>
    <fieldset>
        <strong><legend><?php echo __('Role(s)');?></legend></strong>

        <?php foreach($roles as $role):?>
            <input type="checkbox" class="update" id="role[<?php echo $role->id;?>]" <?php echo $user->hasProjectRole($role->name, $project->id) ? 'checked':'';?>/><?php echo $role->name;?><br/>
        <?php endforeach;?>
    </fieldset>

    <input type="submit" class="submit-update" value="<?php echo __('Save');?>"/>
</div>

<script type="text/javascript">
    $(function() {
        $(".submit-update").click(function() {
            var params = 'id=<?php echo $project->id;?>';
            params += '&uid='+$('#username_update').val();

            $('input[id^=role][class=update][type=checkbox]:checked').each(function(){
                params += '&'+this.id+"=1";
            })

            $.ajax({
                type: 'POST',
                url: '<?php echo url_for('adminProject/updateUserProjectRole');?>',
                data: params,
                success: function() {
                    // reload grid
                    $('#user-project-roles').flexOptions({newp: 1}).flexReload()
                    $('#hidden-trigger-gun').qtip('hide');
                }
            });

            return false;
        });
    });
</script>