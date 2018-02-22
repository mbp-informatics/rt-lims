<div class="qcCreflips view large-9 medium-8 columns content">
    <h3><?= __('QcCreflip')." #".h($qcCreflip->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($qcCreflip->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcCreflip->has('user') ? $this->Html->link($qcCreflip->user->name, ['controller' => 'Users', 'action' => 'view', $qcCreflip->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcCreflip->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Vial Id') ?></th>
            <td><?= $this->Number->format($qcCreflip->vial_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcCreflip->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= $this->Number->format($qcCreflip->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcCreflip->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Pcr1') ?></th>
            <td><?= $this->Number->format($qcCreflip->pcr1) ?></td>
        </tr>
        <tr>
            <th><?= __('Southern1') ?></th>
            <td><?= $this->Number->format($qcCreflip->southern1) ?></td>
        </tr>
        <tr>
            <th><?= __('Northern1') ?></th>
            <td><?= $this->Number->format($qcCreflip->northern1) ?></td>
        </tr>
        <tr>
            <th><?= __('Electroporation1') ?></th>
            <td><?= $this->Number->format($qcCreflip->electroporation1) ?></td>
        </tr>
        <tr>
            <th><?= __('Pcr2') ?></th>
            <td><?= $this->Number->format($qcCreflip->pcr2) ?></td>
        </tr>
        <tr>
            <th><?= __('Southern2') ?></th>
            <td><?= $this->Number->format($qcCreflip->southern2) ?></td>
        </tr>
        <tr>
            <th><?= __('Northern2') ?></th>
            <td><?= $this->Number->format($qcCreflip->northern2) ?></td>
        </tr>
        <tr>
            <th><?= __('Electroporation2') ?></th>
            <td><?= $this->Number->format($qcCreflip->electroporation2) ?></td>
        </tr>
        <tr>
            <th><?= __('Pcr3') ?></th>
            <td><?= $this->Number->format($qcCreflip->pcr3) ?></td>
        </tr>
        <tr>
            <th><?= __('Southern3') ?></th>
            <td><?= $this->Number->format($qcCreflip->southern3) ?></td>
        </tr>
        <tr>
            <th><?= __('Northern3') ?></th>
            <td><?= $this->Number->format($qcCreflip->northern3) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcCreflip->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcCreflip->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcCreflip->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcCreflip->modified) ?></tr>
        </tr>
    </table>
</div>
