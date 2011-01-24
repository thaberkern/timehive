<?php $sf_response->setTitle('TimeHive - Report');?>

<?php use_javascript('jquery.min.js');?>
<?php use_javascript('jquery-ui.min.js');?>
<?php use_stylesheet('ui-lightness/jquery-ui.custom.css');?>

<div class="box box-100">
    <div class="boxin">
        <?php include_partial('headerbar');?>
        <div class="content">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <?php include_partial('filterbar', array('destination_action' => 'projectTotal',
                                                                     'users' => $users,
                                                                     'user' => $user,
                                                                     'show_project_select' => true,
                                                                     'show_pagesize_select' => false,
                                                                     'projects'=>$projects)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="tl"><?php echo __('Project');?></td>
                        <td class="tl"><?php echo __('User');?></td>
                        <td class="tl" style="width: 600px"><?php echo __('Effort');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $project_totals = $sf_data->getRaw('project_totals');?>
                    <?php $index = 0;?>
                    <?php foreach ($project_totals as $project_infos): ?>
                        <tr class="<?php echo $index++ % 2 == 1 ? "odd" : "even"; ?>">
                            <td style="font-weight: bold;" rowspan="<?php echo sizeof($project_infos['items']) + 2; ?>">
                                <?php echo $project_infos['project']->name ?>
                                <?php if ($project_infos['project']->number != ""): ?>
                                    <p style="font-size: 0.8em;"><?php echo $project_infos['project']->number ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="slim">&nbsp;</td>
                            <td class="slim">
                                <table class="report" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <?php foreach ($types as $type): ?>
                                                <td class="tc itemtype"><?php echo $type->name; ?></td>
                                            <?php endforeach; ?>
                                            <td class="tr slim"><?php echo __('Total hours (days)'); ?></td>
                                        </tr>
                                    </thead>
                                </table>
                            </td>
                        </tr>
                        <?php $project_total = 0; ?>
                        <?php foreach ($project_infos['items'] as $user_infos): ?>
                            <tr>
                                <td class="slim"><?php echo $user_infos['user']; ?></td>
                                <td class="slim">
                                    <?php if ($sf_user->hasProjectCredential('credential.report.other', $project_infos['project']) || 
                                              ($user_infos['user']->id == $sf_user->getId() && $sf_user->hasProjectCredential('credential.report.project_total.self', $project_infos['project']))):?>
                                        <table class="report" style="width: 100%">
                                            <tr>
                                                <?php $total = 0; ?>
                                                <?php foreach ($types as $type): ?>
                                                    <?php
                                                        $value = array_key_exists($type->id, $user_infos['time']) ? $user_infos['time'][$type->id]->get('sum') : 0;
                                                        $total += $value;
                                                        $project_total += $value;
                                                    ?>
                                                    <td class="tr itemtype" style="border-right: 1px solid #dedbb3;">
                                                        <?php echo number_format($value, 2); ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="tr slim" style="background-color: #e5f7d3;">
                                                    <?php echo number_format($total, 2); ?> (<?php echo number_format($total / 8, 2); ?>)
                                                </td>
                                            </tr>
                                        </table>
                                    <?php else: ?>
                                    <div class="msg msg-warn">
                                        <p><?php echo __('You are not allowed to show this users data in this project');?></p>
                                    </div>

                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2" class="slim" style="background-color: #bee994; text-align: right; padding-right: 4px;"><?php echo __('Total Project'); ?>: <?php echo number_format($project_total, 2) . ' (' . number_format($project_total / 8, 2) . ')'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>