<div class="qcTmks view large-9 medium-8 columns content">
    <h3><?= __('QcTmk')." #".h($qcTmk->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Inventory Vial') ?></th>
            <td><?= $qcTmk->has('inventory_vial') ? $this->Html->link($qcTmk->inventory_vial->label, ['controller' => 'InventoryVials', 'action' => 'view', $qcTmk->inventory_vial->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcTmk->has('user') ? $this->Html->link($qcTmk->user->name, ['controller' => 'Users', 'action' => 'view', $qcTmk->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($qcTmk->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= $this->Number->format($qcTmk->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Fnished By') ?></th>
            <td><?= $this->Number->format($qcTmk->fnished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= $this->Number->format($qcTmk->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Euploid') ?></th>
            <td><?= $this->Number->format($qcTmk->euploid) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch1') ?></th>
            <td><?= $this->Number->format($qcTmk->ch1) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch2') ?></th>
            <td><?= $this->Number->format($qcTmk->ch2) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch3') ?></th>
            <td><?= $this->Number->format($qcTmk->ch3) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch4') ?></th>
            <td><?= $this->Number->format($qcTmk->ch4) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch5') ?></th>
            <td><?= $this->Number->format($qcTmk->ch5) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch6') ?></th>
            <td><?= $this->Number->format($qcTmk->ch6) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch7') ?></th>
            <td><?= $this->Number->format($qcTmk->ch7) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch8') ?></th>
            <td><?= $this->Number->format($qcTmk->ch8) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch9') ?></th>
            <td><?= $this->Number->format($qcTmk->ch9) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch10') ?></th>
            <td><?= $this->Number->format($qcTmk->ch10) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch11') ?></th>
            <td><?= $this->Number->format($qcTmk->ch11) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch12') ?></th>
            <td><?= $this->Number->format($qcTmk->ch12) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch13') ?></th>
            <td><?= $this->Number->format($qcTmk->ch13) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch14') ?></th>
            <td><?= $this->Number->format($qcTmk->ch14) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch15') ?></th>
            <td><?= $this->Number->format($qcTmk->ch15) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch16') ?></th>
            <td><?= $this->Number->format($qcTmk->ch16) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch17') ?></th>
            <td><?= $this->Number->format($qcTmk->ch17) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch18') ?></th>
            <td><?= $this->Number->format($qcTmk->ch18) ?></td>
        </tr>
        <tr>
            <th><?= __('Ch19') ?></th>
            <td><?= $this->Number->format($qcTmk->ch19) ?></td>
        </tr>
        <tr>
            <th><?= __('ChX') ?></th>
            <td><?= $this->Number->format($qcTmk->chX) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= $this->Number->format($qcTmk->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= $this->Number->format($qcTmk->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcTmk->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcTmk->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcTmk->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcTmk->modified) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($qcTmk->comment)); ?>
    </div>
</div>
