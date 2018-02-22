<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="imitsDumpMiPlans view large-9 medium-8 columns content">
    <h3><?= h($imitsDumpMiPlan->id) ?></h3>
    <table class="table table-responsive">
        <tr>
            <th scope="row"><?= __('User ID') ?></th>
            <td><?= $imitsDumpMiPlan->has('user') ? $this->Html->link($imitsDumpMiPlan->user->name, ['controller' => 'Users', 'action' => 'view', $imitsDumpMiPlan->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($imitsDumpMiPlan->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imits Mi Plan Id') ?></th>
            <td><?= $this->Number->format($imitsDumpMiPlan->imits_mi_plan_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($imitsDumpMiPlan->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($imitsDumpMiPlan->modified) ?></td>
        </tr>
    </table>
    <hr/>
    <div class="row">
        <h2><?= __('Mi Plan') ?></h2>
        <table class="table table-responsive">
        <?= $this->CustomForm->displayCompound(json_decode($imitsDumpMiPlan->mi_plan_json)) ?>
        </table>
    </div>
</div>
