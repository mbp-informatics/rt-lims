<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="imitsDumpMiAttempts view large-9 medium-8 columns content">
    <h3><?= h($imitsDumpMiAttempt->id) ?></h3>
    <table class="table table-responsive">
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= h($imitsDumpMiAttempt->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($imitsDumpMiAttempt->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imits Mi Attempt Id') ?></th>
            <td><?= $this->Number->format($imitsDumpMiAttempt->imits_mi_attempt_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imits Mi Plan Id') ?></th>
            <td><a href="/imits-dump-mi-plans/view/<?= $imitsDumpMiAttempt->imits_mi_plan_id ?>"><?= $imitsDumpMiAttempt->imits_mi_plan_id ?></a></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($imitsDumpMiAttempt->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($imitsDumpMiAttempt->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h2><?= __('Mi Attempt') ?></h2>
        <table class="table table-responsive">
            <?= $this->CustomForm->displayCompound(json_decode($imitsDumpMiAttempt->mi_attempt_json)) ?>
        </table>
    </div>
</div>