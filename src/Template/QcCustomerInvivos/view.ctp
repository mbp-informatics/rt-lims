<div class="qcCustomerInvivos view large-9 medium-8 columns content">
    <h3><?= __('QcCustomerInvivo')." #".h($qcCustomerInvivo->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Starting Product') ?></th>
            <td><?= h($qcCustomerInvivo->starting_product) ?></td>
        </tr>
        <tr>
            <th><?= __('Injection Outcome') ?></th>
            <td><?= h($qcCustomerInvivo->injection_outcome) ?></td>
        </tr>
        <tr>
            <th><?= __('Germline Outcome') ?></th>
            <td><?= h($qcCustomerInvivo->germline_outcome) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcCustomerInvivo->has('user') ? $this->Html->link($qcCustomerInvivo->user->name, ['controller' => 'Users', 'action' => 'view', $qcCustomerInvivo->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcCustomerInvivo->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Clone Id') ?></th>
            <td><?= $this->Number->format($qcCustomerInvivo->komp_clones_dump_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Order Id') ?></th>
            <td><?= $this->Number->format($qcCustomerInvivo->order_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Added By') ?></th>
            <td><?= $this->Number->format($qcCustomerInvivo->added_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated By') ?></th>
            <td><?= $this->Number->format($qcCustomerInvivo->updated_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcCustomerInvivo->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($qcCustomerInvivo->updated) ?></tr>
        </tr>
        <tr>
            <th><?= __('Injection Date') ?></th>
            <td><?= h($qcCustomerInvivo->injection_date) ?></tr>
        </tr>
        <tr>
            <th><?= __('Germline Date') ?></th>
            <td><?= h($qcCustomerInvivo->germline_date) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcCustomerInvivo->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcCustomerInvivo->modified) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Notes') ?></h4>
        <?= $this->Text->autoParagraph(h($qcCustomerInvivo->notes)); ?>
    </div>
</div>
