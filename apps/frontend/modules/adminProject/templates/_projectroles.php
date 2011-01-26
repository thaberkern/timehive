<?php use_javascript('flexigrid.pack.js');?>
<?php use_stylesheet('flexigrid/flexigrid.css');?>

<?php use_javascript('jquery.qtip.min.js');?>
<?php use_stylesheet('jquery.qtip.css');?>

<?php use_helper('Form', 'Object'); ?>

<style>
    .flexigrid div.fbutton .add { background: url(/images/add.png) no-repeat center left; }
    .flexigrid div.fbutton .delete { background: url(/images/delete.png) no-repeat center left; }
    .flexigrid div.fbutton .edit { background: url(/images/edit.png) no-repeat center left; }
</style>

<table id="user-project-roles" ></table>

<div id="hidden-trigger-gun"></div>

<div id="add-relation-modal" style="display:none;">
    <div class="fields">
        <label for="username"><?php echo __('User');?>:</label>
        <select id="username" name="username">
            <?php echo objects_for_select($users, 'getId', 'getUsername'); ?>
        </select>
        <br/><br/>
        <fieldset>
            <strong><legend><?php echo __('Role(s)');?></legend></strong>
            
            <?php foreach($roles as $role):?>
                <input type="checkbox" id="role[<?php echo $role->id;?>]"/><?php echo $role->name;?><br/>
            <?php endforeach;?>
        </fieldset>
        
        <input type="button" class="submit-add" value="<?php echo __('Save');?>"/>
    </div>
</div>

<script type="text/javascript">
    $("#user-project-roles").flexigrid ( {
        url: '<?php echo url_for('adminProject/userProjectRoles?id='.$project->id);?>',
        dataType: 'json',
        colModel : [
            {display: '<?php echo __('Username');?>', name : 'username', width : 100, align: 'left'},
            {display: '<?php echo __('Role(s)');?>', name : 'roles', width : 280, align: 'left'}
        ],
        buttons : [
            {name: '<?php echo __('Add');?>', bclass: 'add', onpress : eventHandler},
            {separator: true},
            {name: '<?php echo __('Edit');?>', bclass: 'edit', onpress : eventHandler},
            {separator: true},
            {name: '<?php echo __('Delete');?>', bclass: 'delete', onpress : eventHandler},
            {separator: true}
        ],
        usepager: false,
        singleSelect: true,
        useRp: false,
        width: 800,
        height: 200
    });

    function eventHandler(com,grid)
    {
        if (com=='<?php echo __('Delete');?>')
        {
            $('.trSelected', grid).each(function() {
                var id = $(this).attr('id');
                id = id.substring(id.lastIndexOf('row')+3);
                check = confirm("<?php echo __('Really delete this user project role?');?>");
                if (check == true) {
                    $.ajax(
                    {
                      url:'<?php echo url_for('adminProject/deleteUserProjectRole');?>',
                      data: {'id': <?php echo $project->id;?>, 'uid': id },
                      success: function(html) {
                          $('#user-project-roles').flexOptions({newp: 1}).flexReload()
                      }
                    })
                }
            });
        }
        else if (com=='<?php echo __('Edit');?>')
        {
            $('.trSelected', grid).each(function() {
                var id = $(this).attr('id');
                id = id.substring(id.lastIndexOf('row')+3);

                $('#hidden-trigger-gun').qtip(
                {
                    id: 'modal-dialog-edit',
                    content: {
                        text: '<img class="throbber" src="/images/throbber.gif" style="vertical-align: middle;" /><?php echo __('Loading');?>...',
                        ajax: {
                            url: '<?php echo url_for('adminProject/editUserProjectRole?id='.$project->id);?>/uid/'+id
                        },
                        title: {
                            text: '<?php echo __('Edit project-user-relation');?>',
                            button: true
                        }
                    },
                    position: {
                        my: 'center', // ...at the center of the viewport
                        at: 'center',
                        target: $(window)
                    },
                    show: {
                        solo: true, // ...and hide all other tooltips...
                        modal: true // ...and make it modal
                    },
                    hide: false,
                    style: 'ui-tooltip-light ui-tooltip-rounded'
                });

                $('#hidden-trigger-gun').qtip('show');
            });
        }
        else if (com=='<?php echo __('Add');?>')
        {
            $('#hidden-trigger-gun').qtip(
            {
              id: 'modal-dialog-add',
              content: {
                 text: $('#add-relation-modal'),
                 title: {
                    text: '<?php echo __('Add project-user-relation');?>',
                    button: true
                 }
              },
              position: {
                 my: 'center', // ...at the center of the viewport
                 at: 'center',
                 target: $(window)
              },
              show: {
                 solo: true, // ...and hide all other tooltips...
                 modal: true // ...and make it modal
              },
              hide: false,
              style: 'ui-tooltip-light ui-tooltip-rounded'
           });

           $('#hidden-trigger-gun').qtip('show');
           $(".submit-add").click(function() {
                var params = 'id=<?php echo $project->id;?>';
                params += '&uid='+$('#username').val();

                $('input[id^=role][type=checkbox]:checked').each(function(){
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
            });
        }
    }
</script>