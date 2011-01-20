<?php $sf_response->setTitle('ProjectTimeBoxx - Report');?>

<div class="box box-100">
    <div class="boxin">
        <?php include_partial('headerbar');?>
        <div class="content">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <?php include_partial('filterbar', array('destination_action' => 'projectTotal', 'users' => $users, 'user' => $user, 'show_project_select' => true, 'projects'=>$projects)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="tl"><?php echo __('Project');?></td>
                        <td class="tl"><?php echo __('User');?></td>
                        <td class="tl"><?php echo __('Effort');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($project_totals as $project_infos): ?>
                        <tr class="<?php echo $index++ % 2 == 1 ? "odd" : "even"; ?>">
                            <td style="font-weight: bold;" rowspan="<?php echo sizeof($project_infos['items']) + 2; ?>">
                            <?php echo $project_infos['project']->getName() ?>
                            <?php if ($project_infos['project']->getNumber() != ""): ?>
                                    (<?php echo $project_infos['project']->getNumber() ?>)
                            <?php endif; ?>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <table style="width: <?php echo sizeof($types) * 70 + 220; ?>px" class="list">
                                        <tr>
                                    <?php foreach ($types as $type): ?>
                                        <th style="text-align: center; width: 70px"><?php echo $type->getName(); ?></th>
                                    <?php endforeach; ?>
                                        <th style="text-align: center; width: 200px"><?php echo __('Total hours (days)'); ?></th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php $project_total = 0; ?>
                    <?php foreach ($project_infos['items'] as $user_infos): ?>
                                            <tr>
                                                <td><?php echo $user_infos['user']; ?></td>
                                                <td>
                                                    <table style="width: <?php echo sizeof($types) * 70 + 220; ?>px" class="list">
                                                        <tr>
                                    <?php $total = 0; ?>
                                    <?php foreach ($types as $type): ?>
                                    <?php
                                                $value = array_key_exists($type->getId(), $user_infos['time']) ? $user_infos['time'][$type->getId()]->get('sum') : 0;
                                                $total += $value;
                                                $project_total += $value;
                                    ?>
                                                <td style="width: 70px; text-align: right; border-right: 1px solid #dedbb3; padding-right: 4px;">
                                        <?php echo number_format($value, 2); ?>
                                            </td>
                                    <?php endforeach; ?>
                                                <td style="width: 200px; text-align: right; background-color: #e5f7d3;">
                                        <?php echo number_format($total, 2); ?> (<?php echo number_format($total / 8, 2); ?>)
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="2" style="background-color: #bee994; text-align: right; padding-right: 4px;"><?php echo __('Total Project'); ?>: <?php echo number_format($project_total, 2) . ' (' . number_format($project_total / 8, 2) . ')'; ?></td>
                                                </tr>

			<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>