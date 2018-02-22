<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pseudopregnant Recipient Order Entry'), ['action' => 'edit', $pseudopregnantRecipientOrderEntry->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pseudopregnant Recipient Order Entry'), ['action' => 'delete', $pseudopregnantRecipientOrderEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pseudopregnantRecipientOrderEntry->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pseudopregnant Recipient Order Entries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pseudopregnant Recipient Order Entry'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pseudopregnant Recipient Orders'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pseudopregnant Recipient Order'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pseudopregnantRecipientOrderEntries view large-9 medium-8 columns content">
    <h3><?= h($pseudopregnantRecipientOrderEntry->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Pseudopregnant Recipient Order') ?></th>
            <td><?= $pseudopregnantRecipientOrderEntry->has('pseudopregnant_recipient_order') ? $this->Html->link($pseudopregnantRecipientOrderEntry->pseudopregnant_recipient_order->id, ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'view', $pseudopregnantRecipientOrderEntry->pseudopregnant_recipient_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Recharge') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->recharge) ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Pseudo State') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->pseudo_state) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($pseudopregnantRecipientOrderEntry->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($pseudopregnantRecipientOrderEntry->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Plugged') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->date_plugged) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Needed') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->date_needed) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($pseudopregnantRecipientOrderEntry->modified) ?></tr>
        </tr>
    </table>
</div>
