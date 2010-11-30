<?php if ($form->hasErrors()):?>
    <div class="msg msg-error">
        <p><?php echo __('There were errors');?>:</p>
        <ul>
            <?php foreach( $form->getFormFieldSchema( ) as $name => $formField ):?>
                <?php if( $formField->getError( ) != "" ):?>
                <li><strong><?php echo $name;?></strong>:&nbsp;<?php echo $formField->getError() ;?></li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>