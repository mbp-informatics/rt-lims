<?php
$header = isset($in_house) ? 'In-house B6NCRL Mice Order #' : 'Pseudopregnant Recipient Order #';
if (isset($type)) {
    switch ($type) {
        case 'Recipient':
        $header = 'Pseudopregnant Recipient Order #';
        break;
        case 'in-house B6NCRL';
        $header = 'In-house B6NCRL Colony Order #';
        break;
    }
}
?>

<div class="pseudopregnantRecipientOrders view large-9 medium-8 columns content">
    <h3><?= h($header.$pseudopregnantRecipientOrder->id) ?>
    <?php
    if ($pseudopregnantRecipientOrder->status == 'open') {
        echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit order details'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'edit', $pseudopregnantRecipientOrder->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
    } ?>
    </h3>
    <table class="data-table table stripe order-column">
        <tr>
            <th><?= __('Protocol Investigator') ?></th>
            <td><?= h($pseudopregnantRecipientOrder->protocol_Investigator) ?></td>
        </tr>
        <tr>
            <th><?= __('Requested by') ?></th>
            <td><?= $pseudopregnantRecipientOrder->has('user') ? $this->Html->link($pseudopregnantRecipientOrder->user->name, ['controller' => 'Users', 'action' => 'view', $pseudopregnantRecipientOrder->user->id]) : '' ?></td>
        </tr>
       <tr>
            <th><?= __('Submit Date') ?></th>
            <td><?= h($pseudopregnantRecipientOrder->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Protocol #') ?></th>
            <td><?= $pseudopregnantRecipientOrder->protocol ?></td>
        </tr>
        <tr>
            <th><?= __('Total Plugs This Week') ?></th>
            <td><?= $pseudopregnantRecipientOrder->total_plugs ?></td>
        </tr>
        <tr>
            <th><?= __('Protocol Expiry Date') ?></th>
            <td><?= h(date_format(date_create($pseudopregnantRecipientOrder->protocol_expiration), 'Y-m-d')); ?></td>
        </tr>
        <tr>
            <th><?= __('For The Week Of') ?></th>
            <td><?= h(date_format(date_create($pseudopregnantRecipientOrder->time_period_start), 'Y-m-d')); ?></td>
        </tr>
        <tr>
            <th><?= __('Through') ?></th>
            <td><?= h(date_format(date_create($pseudopregnantRecipientOrder->time_period_end), 'Y-m-d')); ?></td>
        </tr>

        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($pseudopregnantRecipientOrder->modified) ?></tr>
        </tr>
       <tr>
            <th><?= __('Status') ?></th>
            <td><?php 
            $status = h($pseudopregnantRecipientOrder->status);
            if ($status == 'finalized') { ?>
                <span class="label label-success"><?= $status ?> on <?php
                 echo $pseudopregnantRecipientOrder->finalize_date;
                 ?></span>
            <?php } else {
                echo h($pseudopregnantRecipientOrder->status);
            } ?> 
            </tr>
        </tr>
    </table>
    <?php if (!empty($pseudopregnantRecipientOrder->note)) { ?>
    <div class="row">
        <div class="jumbotron" style="margin:20px; padding:15px;">
        <span class="badge">Note</span>
            <p><?= $this->Text->autoParagraph(h($pseudopregnantRecipientOrder->note)); ?></p>
        </div>
    </div>
    <?php } //endif note ?>
    <hr/>
    <div class="related">
        <?php if (!empty($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries)): ?>
        <h4><?= __('Order Entries') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Recharge') ?></th>
                <th><?= __('Location') ?></th>
                <?php
                    $dp = 'Date Plugged';
                    $dn = 'Date Needed';
                     if ($type != 'Recipient') {
                        $dp = 'Date PMSG Received';
                        $dn = 'Date brought out';
                    }
                ?>
                <th><?= $dp ?></th>
                <th><?= $dn ?></th>
                <?php if ($type == 'Recipient') { ?> 
                    <th><?= __('Pseudo State') ?></th>
                <?php } ?>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Type') ?></th>
                <?php if ($pseudopregnantRecipientOrder->status == 'open') { ?>
                <th class="actions"><?= __('Actions') ?></th>
                <?php } ?>
            </tr>
            <?php foreach ($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries as $pseudopregnantRecipientOrderEntries): ?>
            <tr>
                <td><?= h($pseudopregnantRecipientOrderEntries->recharge) ?></td>
                <td><?= h($pseudopregnantRecipientOrderEntries->location) ?></td>
                <td><?= h(date_format(date_create($pseudopregnantRecipientOrderEntries->date_plugged), 'Y-m-d')); ?></td>
                <td><?= h(date_format(date_create($pseudopregnantRecipientOrderEntries->date_needed), 'Y-m-d')); ?></td>
                <?php if ($type == 'Recipient') { ?> 
                    <td><?= h($pseudopregnantRecipientOrderEntries->pseudo_state) ?></td>
                <?php } ?>
                <td><?= h($pseudopregnantRecipientOrderEntries->quantity) ?></td>
                <td><?= isset($pseudopregnantRecipientOrderEntries->type) ? h($pseudopregnantRecipientOrderEntries->type) : 'Recipient' ?></td>
                <?php if ($pseudopregnantRecipientOrder->status == 'open') { ?>
                <td class="actions"> <?php 
                 echo '<span data-toggle="tooltip" title="Edit">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller' => 'pseudopregnantRecipientOrderEntries', 'action' => 'edit', $pseudopregnantRecipientOrderEntries->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>';
                 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ',
                                        ['controller' => 'pseudopregnantRecipientOrderEntries', 'action' => 'delete', $pseudopregnantRecipientOrderEntries->id],
                                 array(
                                     'escape' => false,
                                     'class' => 'label label-danger action-pad',
                                     'confirm' => __('Are you sure you want to delete entry # {0}?', $pseudopregnantRecipientOrderEntries->id)
                                        )) . '</span>';
             } //endif status
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php
if ($pseudopregnantRecipientOrder->status == 'open') {
    
    if (isset($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]) &&
        $pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]->type == 'Recipient' ||
        (!isset($in_house) && count($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries) == 0)
    ) {
        echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Pseudopregnant Recipient'), ['controller' => 'PseudopregnantRecipientOrderEntries', 'action' => 'add', $pseudopregnantRecipientOrder->id, 'recipient'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
    }

    if (isset($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]) && 
        $pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries[0]->type == 'in-house B6NCRL' ||
        (isset($in_house) && count($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries) == 0)
    ) {
        echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add in-house B6NCRL'), ['controller' => 'PseudopregnantRecipientOrderEntries', 'action' => 'add', $pseudopregnantRecipientOrder->id], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
    }
    echo "<hr />";
    if (!empty($pseudopregnantRecipientOrder->pseudopregnant_recipient_order_entries)) {
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-ok"></span> ' . __('Finalize order'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'finalize', $pseudopregnantRecipientOrder->id], array(
            'escape' => false,
            'class' => 'btn btn-success pad-button',
            'confirm' => __('When you finalize the order it will be sent for processing and you WILL NOT be able edit it. Do you want to finalize this order now?')
            ));
    }
} //endif status
    echo $this->Html->link('' . __('Go back'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'index'], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    ));
?>
    </div>
</div>


