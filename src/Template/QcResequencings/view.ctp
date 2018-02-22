<div class="qcResequencings view large-9 medium-8 columns content">
    <h3><?= __('QcResequencing')." #".h($qcResequencing->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Result') ?></th>
            <td><?= h($qcResequencing->result) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= h($qcResequencing->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcResequencing->has('user') ? $this->Html->link($qcResequencing->user->name, ['controller' => 'Users', 'action' => 'view', $qcResequencing->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcResequencing->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Vial Id') ?></th>
            <td><?= $this->Number->format($qcResequencing->inventory_vial_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcResequencing->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcResequencing->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcResequencing->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcResequencing->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcResequencing->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcResequencing->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcResequencing->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcResequencing->modified) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($qcResequencing->comment)); ?>
    </div>
    <div class="row">
        <h4><?= __('MGAL Sequence') ?></h4>
        <?= $this->Text->autoParagraph(h($qcResequencing->MGAL_sequence)); ?>
    </div>
    <div class="row">
        <h4><?= __('Blast Result') ?></h4>
        <?= $this->Text->autoParagraph(h($qcResequencing->blast_result)); ?>
    </div>
    <div class="row">
        <h4><?= __('MGAL Id Location') ?></h4>
        <?= $this->Text->autoParagraph(h($qcResequencing->MGAL_id_location)); ?>
    </div>
    <div class="row">
        <h4><?= __('MGAL Expected') ?></h4>
        <?= $this->Text->autoParagraph(h($qcResequencing->MGAL_expected)); ?>
    </div>
</div>
