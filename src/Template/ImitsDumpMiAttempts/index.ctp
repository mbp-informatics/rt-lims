<?php
/**
  * @var \App\View\AppView $this
  */
?>
<script src="/webroot/js/imits-dump.js"></script> 
<div class="imitsDumpMiAttempts index large-9 medium-8 columns content">
    <div class="alert alert-success">
    
        <div id="super-spinner" style="display:none; float:right; border-left: 2px solid brown; padding-left:15px; color:brown; margin-top:5px;">
            <div style="width:250px;float:left;">
                <em>This table is now being refreshed!</em> 
                <small>Job started: <span id="job-date"></span></small>
            </div>
        <img style="width:50px; margin-left:15px;" class="super-spinner" src="/img/balls.gif">
        </div>

    Note: <em>*_dump_*</em> tables are automatically populated by a CRON job calling API-NS system.<br/>
    This is just a view - it will get overwritten every time the CRON jon is run.<br/>
    More info in the wiki.
    </div>
    <h3><?= __('Imits Dump Mi Attempts') ?></h3>
    </style>
    <table class="data-table table-responsive" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">imits_mi_attempt_id</th>
                <th scope="col">imits_mi_plan_id</th>
                <th class="highlight" scope="col">dump created</th>
                <th scope="col" class="actions"><?= __('View All Data') ?></th>
                <th scope="col">mi_attempt_json</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imitsDumpMiAttempts as $imitsDumpMiAttempt): ?>
            <tr>
                <td><?= $this->Number->format($imitsDumpMiAttempt->id) ?></td>
                <td><?= $this->Number->format($imitsDumpMiAttempt->imits_mi_attempt_id) ?></td>
                <td><a href="/imits-dump-mi-plans/view/<?= $imitsDumpMiAttempt->imits_mi_plan_id ?>"><?= $imitsDumpMiAttempt->imits_mi_plan_id ?></a></td>
                <td><?= h($imitsDumpMiAttempt->created) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $imitsDumpMiAttempt->imits_mi_attempt_id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
                <td><?= h($imitsDumpMiAttempt->mi_attempt_json) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
