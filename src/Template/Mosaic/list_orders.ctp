<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h2><?= __('Orders') ?></h2>
    <hr/>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <!--<th><?= $this->Paginator->sort('order_guid') ?></th>-->
                <!--<th><?= $this->Paginator->sort('requested_arrival_date') ?></th>-->
                <th>Order GUID</th>
                <th>Requested Arrival Date</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order["order_guid"] ?></td>
                <td><?= h($order["requested_arrival_date"]) ?></td>
                <td class="actions">
                    <!--<?= $this->Html->link(__('View'), ['action' => 'view', $order->id]) ?>-->
                    <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $order->id]) ?>-->
                    <!--<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>-->
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!--<div class="paginator">-->
    <!--    <ul class="pagination">-->
    <!--        <?= $this->Paginator->prev('< ' . __('previous')) ?>-->
    <!--        <?= $this->Paginator->numbers() ?>-->
    <!--        <?= $this->Paginator->next(__('next') . ' >') ?>-->
    <!--    </ul>-->
    <!--    <p><?= $this->Paginator->counter() ?></p>-->
    <!--</div>-->
</div>