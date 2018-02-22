<div class="qcKaryotypes view large-9 medium-8 columns content">
    <h3><?= __('QcKaryotype')." #".h($qcKaryotype->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($qcKaryotype->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcKaryotype->has('user') ? $this->Html->link($qcKaryotype->user->name, ['controller' => 'Users', 'action' => 'view', $qcKaryotype->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcKaryotype->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Vial Id') ?></th>
            <td><?= $this->Number->format($qcKaryotype->inventory_vial_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcKaryotype->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcKaryotype->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcKaryotype->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Euploid') ?></th>
            <td><?= $this->Number->format($qcKaryotype->euploid) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcKaryotype->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcKaryotype->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcKaryotype->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcKaryotype->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcKaryotype->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcKaryotype->modified) ?></tr>
        </tr>
    </table>
</div>
