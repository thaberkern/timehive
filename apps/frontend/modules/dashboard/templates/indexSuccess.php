<?php $sf_response->setTitle('Timeboxx - '.__('Dashboard'));?>

<div class="box box-50"><!-- box 50% width -->
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('My last time bookings');?></h3>
        </div>
        <div class="content">
            <table cellspacing="0">
                <thead><!-- universal table heading -->
                    <tr>
                        <td class="tc">Type</td>
                        <th>File</th>
                        <td>Description</td>
                        <td class="tc">Pub. date</td>
                        <td class="tc">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="first"><!-- .first for first row of the table (only if there is thead) -->
                        <td class="tc"><span class="tag tag-gray">jpeg</span></td>
                        <th><a href="#">On vacation with my 13.3” honey</a></th>
                        <td>Lovely picture of me and my MacBook during sunset …</td>
                        <td class="tc">715&nbsp;KB</td>
                        <td class="tc"><!-- action icons - feel free to add/modify your own - icons are located in "css/img/led-ico/*" -->
                            <ul class="actions">
                                <li><a class="ico" href="#" title="edit"><img src="css/img/led-ico/pencil.png" alt="edit" /></a></li>
                                <li><a class="ico" href="#" title="delete"><img src="css/img/led-ico/delete.png" alt="delete" /></a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="tc"><span class="tag tag-gray">jpeg</span></td>
                        <th><a href="#">On vacation with my 13.3” honey</a></th>
                        <td>Lovely picture of me and my MacBook during sunset …</td>
                        <td class="tc">715&nbsp;KB</td>
                        <td class="tc">
                            <ul class="actions">
                                <li><a class="ico" href="#" title="edit"><img src="css/img/led-ico/pencil.png" alt="edit" /></a></li>
                                <li><a class="ico" href="#" title="delete"><img src="css/img/led-ico/delete.png" alt="delete" /></a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="tc"><span class="tag tag-gray">jpeg</span></td>
                        <th><a href="#">On vacation with my 13.3” honey</a></th>
                        <td>Lovely picture of me and my MacBook during sunset …</td>
                        <td class="tc">715&nbsp;KB</td>
                        <td class="tc">
                            <ul class="actions">
                                <li><a class="ico" href="#" title="edit"><img src="css/img/led-ico/pencil.png" alt="edit" /></a></li>
                                <li><a class="ico" href="#" title="delete"><img src="css/img/led-ico/delete.png" alt="delete" /></a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="tc"><span class="tag tag-gray">jpeg</span></td>
                        <th><a href="#">On vacation with my 13.3” honey</a></th>
                        <td>Lovely picture of me and my MacBook during sunset …</td>
                        <td class="tc">715&nbsp;KB</td>
                        <td class="tc">
                            <ul class="actions">
                                <li><a class="ico" href="#" title="edit"><img src="css/img/led-ico/pencil.png" alt="edit" /></a></li>
                                <li><a class="ico" href="#" title="delete"><img src="css/img/led-ico/delete.png" alt="delete" /></a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination"><!-- pagination underneath the box's content -->
                <ul>
                    <li><a href="#">previous</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><strong>3</strong></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">next</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="box box-50"><!-- box 50% width -->
    <div class="boxin">
        <div class="header">
            <h3><?php echo __('My total time per project');?></h3>
        </div>
        <div class="content">
            <ul class="simple">
                <li>
                    <strong>SmartDispatch</strong>
                    <span>20 <?php echo ('hour(s)');?></span>
                </li>
            </ul>
        </div>
    </div>
</div>
