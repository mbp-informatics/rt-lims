<div class="qcPathogens view large-9 medium-8 columns content">
    <h3><?= __('QcPathogen')." #".h($qcPathogen->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($qcPathogen->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcPathogen->has('user') ? $this->Html->link($qcPathogen->user->name, ['controller' => 'Users', 'action' => 'view', $qcPathogen->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcPathogen->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Vial Id') ?></th>
            <td><?= $this->Number->format($qcPathogen->inventory_vial_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcPathogen->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcPathogen->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcPathogen->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Mycoplasma') ?></th>
            <td><?= $this->Number->format($qcPathogen->mycoplasma) ?></td>
        </tr>
        <tr>
            <th><?= __('Parvovirus') ?></th>
            <td><?= $this->Number->format($qcPathogen->parvovirus) ?></td>
        </tr>
        <tr>
            <th><?= __('Other') ?></th>
            <td><?= $this->Number->format($qcPathogen->other) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcPathogen->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcPathogen->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcPathogen->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcPathogen->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcPathogen->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcPathogen->modified) ?></tr>
        </tr>
    </table>
</div>
