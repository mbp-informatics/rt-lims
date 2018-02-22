<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Pseudopregnant Recipient Order Entry'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pseudopregnant Recipient Orders'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pseudopregnant Recipient Order'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pseudopregnantRecipientOrderEntries index large-9 medium-8 columns content">
    <h3><?= __('Pseudopregnant Recipient Order Entries') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('pseudopregnant_recipient_order_id') ?></th>
                <th><?= $this->Paginator->sort('recharge') ?></th>
                <th><?= $this->Paginator->sort('location') ?></th>
                <th><?= $this->Paginator->sort('date_plugged') ?></th>
                <th><?= $this->Paginator->sort('date_needed') ?></th>
                <th><?= $this->Paginator->sort('pseudo_state') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pseudopregnantRecipientOrderEntries as $pseudopregnantRecipientOrderEntry): ?>
            <tr>
                <td><?= $this->Number->format($pseudopregnantRecipientOrderEntry->id) ?></td>
                <td><?= $pseudopregnantRecipientOrderEntry->has('pseudopregnant_recipient_order') ? $this->Html->link($pseudopregnantRecipientOrderEntry->pseudopregnant_recipient_order->id, ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'view', $pseudopregnantRecipientOrderEntry->pseudopregnant_recipient_order->id]) : '' ?></td>
                <td><?= h($pseudopregnantRecipientOrderEntry->recharge) ?></td>
                <td><?= h($pseudopregnantRecipientOrderEntry->location) ?></td>
                <td><?= h($pseudopregnantRecipientOrderEntry->date_plugged) ?></td>
                <td><?= h($pseudopregnantRecipientOrderEntry->date_needed) ?></td>
                <td><?= h($pseudopregnantRecipientOrderEntry->pseudo_state) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $pseudopregnantRecipientOrderEntry->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pseudopregnantRecipientOrderEntry->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pseudopregnantRecipientOrderEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pseudopregnantRecipientOrderEntry->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
