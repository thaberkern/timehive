<?php if ($last_bookings_pager->haveToPaginate()):?>
    <div class="pagination">
        <ul>
            <li><a href="<?php echo url_for('report/lastBookings?pagesize='.$sf_request->getParameter('pagesize', 20).'&page='.$last_bookings_pager->getFirstPage());?>"><?php echo __('first');?></a></li>
            <?php if ($current != $last_bookings_pager->getFirstPage()):?>
                <li><a href="<?php echo url_for('report/lastBookings?pagesize='.$sf_request->getParameter('pagesize', 20).'&page='.$last_bookings_pager->getPreviousPage());?>"><?php echo __('previous');?></a></li>
            <?php endif;?>
            <?php $links = $last_bookings_pager->getLinks(); ?>
            <?php foreach ($links as $page): ?>
                <?php if ($page == $last_bookings_pager->getPage()):?>
                    <li><strong><?php echo $page;?></strong></li>
                <?php else: ?>
                    <li><?php echo link_to($page, 'report/lastBookings?pagesize='.$sf_request->getParameter('pagesize', 20).'&page='.($page));?></li>
                <?php endif;?>
            <?php endforeach;?>
            <?php if ($current != $last_bookings_pager->getLastPage()):?>
                <li><a href="<?php echo url_for('report/lastBookings?pagesize='.$sf_request->getParameter('pagesize', 20).'&page='.$last_bookings_pager->getNextPage());?>"><?php echo __('next');?></a></li>
            <?php endif;?>
            <li><a href="<?php echo url_for('report/lastBookings?pagesize='.$sf_request->getParameter('pagesize', 20).'&page='.$last_bookings_pager->getLastPage());?>"><?php echo __('last');?></a></li>
        </ul>
    </div>
<?php endif; ?>