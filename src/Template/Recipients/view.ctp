<div class="recipients view large-9 medium-8 columns content">
    <h3><?= __('Recipient')." #".h($recipient->id) ?>
        <?php
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Recipient'), ['controller' => 'recipients', 'action' => 'edit', $recipient->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?></h3>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Ear Mark') ?>: </strong><?= h($recipient->ear_mark) ?></div>
            <div class='col-xs-3'><strong><?= __('Embryo Stage') ?>: </strong><?= h($recipient->embryo_stage) ?></div>
            <div class='col-xs-3'><strong><?= __('ET By') ?>: </strong><?= h($recipient->et_by) ?></div>
            <div class='col-xs-3'><strong><?= __('Weight') ?>: </strong><?= $this->Number->format($recipient->weight) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Anesthetic Vol') ?>: </strong><?= h($recipient->anesthetic_vol) ?> <?= h($recipient->anesthetic_vol_type) ?></div>
            <div class='col-xs-3'><strong><?= __('Analgesic Vol (mL)') ?>: </strong><?= h($recipient->analgesic_vol) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Tx L') ?>: </strong><?= h($recipient->tx_l) ?></div>
            <div class='col-xs-3'><strong><?= __('Tx R') ?>: </strong><?= h($recipient->tx_r) ?></div>
            <div class='col-xs-3'><strong><?= __('Total Tx') ?>: </strong><?= h($recipient->total_tx) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Total Pups') ?>: </strong><?= h($recipient->total_pups) ?></div>
            <div class='col-xs-3'><strong><?= __('Male Pups') ?>: </strong><?= h($recipient->male_pups) ?></div>
            <div class='col-xs-3'><strong><?= __('Female Pups') ?>: </strong><?= h($recipient->female_pups) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Male Mut') ?>: </strong><?= h($recipient->male_mut) ?></div>
            <div class='col-xs-3'><strong><?= __('Female Mut') ?>: </strong><?= h($recipient->female_mut) ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('Cl') ?>: </strong><?= $recipient->cl ? __('Yes') : __('No'); ?></div>
            <div class='col-xs-3'><strong><?= __('Amp') ?>: </strong><?= $recipient->amp ? __('Yes') : __('No'); ?></div>
            <?php if ($recipient->pups_born == 1) {
                    $pupsborn = 'Yes';
                } elseif (!$recipient->pups_born == 0){
                    $pupsborn = 'No';
                } elseif (!$recipient->pups_born == 2){
                    $pupsborn = 'Pending';
                } else {
                    $pupsborn = '';
                }
                ?>
            <div class='col-xs-3'><strong><?= __('Pups Born') ?>: </strong><?= $pupsborn ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= $recipient->comments ?></div>
        </div>
    </div>
    <div class='alert alert-info' role='alert'>Meta</div>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-3'><strong><?= __('User') ?>: </strong><?= $recipient->has('user') ? $this->Html->link($recipient->user->name, ['controller' => 'Users', 'action' => 'view', $recipient->user->id]) : '' ?></div>
            <div class='col-xs-3'><strong><?= __('ID') ?>: </strong><?= h($recipient->id) ?></div>
            <div class='col-xs-3'><strong><?= __('Created') ?>: </strong><?= h($recipient->created) ?></div>
            <div class='col-xs-3'><strong><?= __('Modified') ?>: </strong><?= h($recipient->modified) ?></div>
            <div class='col-xs-4'><strong><?= __('Embryo Transfer') ?>: </strong><?= $recipient->has('embryo_transfer') ? $this->Html->link($recipient->embryo_transfer->id, ['controller' => 'EmbryoTransfers', 'action' => 'view', $recipient->embryo_transfer->id]) : '' ?></div>
        </div>
    </div>
</div>
