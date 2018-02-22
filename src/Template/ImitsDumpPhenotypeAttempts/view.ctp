<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="imitsDumpPhenotypeAttempts view large-9 medium-8 columns content">
    <h3><?= h($imitsDumpPhenotypeAttempt->id) ?></h3>
    <table class="table table-responsive">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= h($imitsDumpPhenotypeAttempt->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($imitsDumpPhenotypeAttempt->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imits Phenotype Attempt Id') ?></th>
            <td><?= $this->Number->format($imitsDumpPhenotypeAttempt->imits_phenotype_attempt_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imits Mi Plan Id') ?></th>
            <td><a href="/imits-dump-mi-plans/view/<?= $imitsDumpPhenotypeAttempt->imits_mi_plan_id ?>"><?= $imitsDumpPhenotypeAttempt->imits_mi_plan_id ?></a></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($imitsDumpPhenotypeAttempt->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($imitsDumpPhenotypeAttempt->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h2><?= __('Phenotype Attempt') ?></h2>
        <table class="table table-responsive">
            <?= $this->CustomForm->displayCompound(json_decode($imitsDumpPhenotypeAttempt->phenotype_attempt_json)) ?>
        </table>
    </div>
</div>
