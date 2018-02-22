<div class="qcGermlines view large-9 medium-8 columns content">
    <h3><?= __('QcGermline')." #".h($qcGermline->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($qcGermline->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcGermline->has('user') ? $this->Html->link($qcGermline->user->name, ['controller' => 'Users', 'action' => 'view', $qcGermline->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcGermline->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Vial Id') ?></th>
            <td><?= $this->Number->format($qcGermline->inventory_vial_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Microinjection Id') ?></th>
            <td><?= $this->Number->format($qcGermline->microinjection_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcGermline->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcGermline->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcGermline->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcGermline->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcGermline->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcGermline->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcGermline->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcGermline->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcGermline->modified) ?></tr>
        </tr>
    </table>
</div>
