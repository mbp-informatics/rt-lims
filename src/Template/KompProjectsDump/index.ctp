<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="kompProjectsDump index large-9 medium-8 columns content table-responsive">
    <div class="alert alert-success">
        <script src="/webroot/js/komp-dump.js"></script> 
        <div id="super-spinner" style="display:none; float:right; border-left: 2px solid brown; padding-left:15px; color:brown; margin-top:5px;">
            <div style="width:250px;float:left;">
                <em>This table is now being refreshed!</em> 
                <small>Job started: <span id="job-date"></span></small>
            </div>
        <img style="width:50px; margin-left:15px;" class="super-spinner" src="/img/balls.gif">
        </div>
    Note: All <em>*_dump_*</em> tables are automatically populated by a CRON job calling API-NS system.<br/>
    This is just a view - it will get overwritten every time the CRON jon is run.<br/>
    More info in the wiki.
    </div>
    <h3><?= __('Komp Projects Dump') ?></h3>
    <table class="table data-table table-striped">
        <thead>
            <tr>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
                <th class="highlight" scope="col">dump created</th>
                <th scope="col">id</th>
                <th scope="col">colony_name</th>
                <th scope="col">gene</th>
                <th scope="col">komp_gene_id</th>
                <th scope="col">clone_name</th>
                <th scope="col">clone_nickname</th>
                <th scope="col">mouse_clone_id</th>
                <th scope="col">mutation</th>
                <th scope="col">mutation_id_no</th>
                <th scope="col">cell_line</th>
                <th scope="col">mgi_number</th>
                <th scope="col">epd</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kompProjectsDumps as $kompProjectsDump): ?>
            <tr>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $kompProjectsDump->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
                <td><?= $kompProjectsDump->created ?></td>
                <td><?= $this->Number->format($kompProjectsDump->id) ?></td>
                <td><?= h($kompProjectsDump->colony_name) ?></td>
                <td><?= h($kompProjectsDump->gene) ?></td>
                <td><a href="/komp-genes-dump/view/<?= $kompProjectsDump->komp_gene_id ?>"><?= $kompProjectsDump->komp_gene_id ?></a></td>
                <td><?= h($kompProjectsDump->clone_name) ?></td>
                <td><?= h($kompProjectsDump->clone_nickname) ?></td>
                <td><?= $kompProjectsDump->has('mouse_clone') ? $this->Html->link($kompProjectsDump->mouse_clone->name, ['controller' => 'MouseClones', 'action' => 'view', $kompProjectsDump->mouse_clone->id]) : '' ?></td>
                <td><?= h($kompProjectsDump->mutation) ?></td>
                <td><?= h($kompProjectsDump->mutation_id_no) ?></td>
                <td><?= h($kompProjectsDump->cell_line) ?></td>
                <td><?= $this->Number->format($kompProjectsDump->mgi_number) ?></td>
                <td><?= h($kompProjectsDump->epd) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
