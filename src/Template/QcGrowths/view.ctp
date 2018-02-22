<div class="qcGrowths view large-9 medium-8 columns content">
    <h3><?= __('QcGrowth')." #".h($qcGrowth->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($qcGrowth->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('Image Name') ?></th>
            <td><?= h($qcGrowth->image_name) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcGrowth->has('user') ? $this->Html->link($qcGrowth->user->name, ['controller' => 'Users', 'action' => 'view', $qcGrowth->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($qcGrowth->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcGrowth->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcGrowth->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcGrowth->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Confluency') ?></th>
            <td><?= $this->Number->format($qcGrowth->confluency) ?></td>
        </tr>
        <tr>
            <th><?= __('Size') ?></th>
            <td><?= $this->Number->format($qcGrowth->size) ?></td>
        </tr>
        <tr>
            <th><?= __('Shape') ?></th>
            <td><?= $this->Number->format($qcGrowth->shape) ?></td>
        </tr>
        <tr>
            <th><?= __('Texture') ?></th>
            <td><?= $this->Number->format($qcGrowth->texture) ?></td>
        </tr>
        <tr>
            <th><?= __('Color') ?></th>
            <td><?= $this->Number->format($qcGrowth->color) ?></td>
        </tr>
        <tr>
            <th><?= __('Dead Cells') ?></th>
            <td><?= $this->Number->format($qcGrowth->dead_cells) ?></td>
        </tr>
        <tr>
            <th><?= __('Qc Type') ?></th>
            <td><?= $this->Number->format($qcGrowth->qc_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcGrowth->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcGrowth->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcGrowth->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcGrowth->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcGrowth->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcGrowth->modified) ?></tr>
        </tr>
    </table>
</div>
