<hr/>
<?php
if (isset($in_house)) {
    $header = 'In-house B6NCRL Mice Orders';
    echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New order'), ['action' => 'add','?' => ['in_house' => '1']], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
} else {
    $header = 'Pseudopregnant Recipient Orders';
    echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New order'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
}
?>
<hr/>
<div class="pseudopregnantRecipientOrders index large-9 medium-8 columns content horizontal-table">
    <h2><?= $header ?></h2>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>Record#</th>
                <th>Protocol#</th>
                <th>Protocol Expiration</th>
                <th>Protocol Investigator</th>
                <th>Requested By</th>
                <th>Time Period Start</th>
                <th>Time Period End</th>
                <th>Status</th>
                <th>Type</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pseudopregnantRecipientOrders as $pseudopregnantRecipientOrder): ?>
            <tr>
                <td><?= $pseudopregnantRecipientOrder->id ?></td>
                <td><?= $pseudopregnantRecipientOrder->protocol ?></td>
                <td><?= h(date_format(date_create($pseudopregnantRecipientOrder->protocol_expiration), 'Y-m-d')); ?></td>
                <td><?= h($pseudopregnantRecipientOrder->protocol_Investigator) ?></td>
                <td><?= $pseudopregnantRecipientOrder->has('user') ? $this->Html->link($pseudopregnantRecipientOrder->user->name, ['controller' => 'Users', 'action' => 'view', $pseudopregnantRecipientOrder->user->id]) : '' ?></td>
                <td><?= h(date_format(date_create($pseudopregnantRecipientOrder->time_period_start), 'Y-m-d')); ?></td>
                <td><?= h(date_format(date_create($pseudopregnantRecipientOrder->time_period_end), 'Y-m-d')); ?></td>
                <td><?= h($pseudopregnantRecipientOrder->status) ?></td>
                <?php
                    if (isset($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0])) {
                        $type = isset($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]->type) ? $pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]->type : 'Recipient';
                    }
                ?>
                <td><?= $type ?></td>
                <td class="actions" style="text-align:left;">
                <?php
                if ($pseudopregnantRecipientOrder->status == 'open') { $tooltipText = "View/Edit"; } else { $tooltipText = "View"; }
                $viewLinkParams = ['action' => 'view', $pseudopregnantRecipientOrder->id];
                if (isset($in_house)) {
                    $viewLinkParams['?'] = ['in_house' => '1'];
                }
                echo "<span data-toggle='tooltip' title='{$tooltipText}'>" . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', $viewLinkParams, array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>';
                        echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ',
                                        ['action' => 'delete', $pseudopregnantRecipientOrder->id],
                                        array(
                                            'escape' => false,
                                            'class' => 'label label-danger action-pad',
                                            'confirm' => __('Are you sure you want to delete order # {0}?', $pseudopregnantRecipientOrder->id)
                                        )) . '</span>';
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
