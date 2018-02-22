<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="kompVialsDump view large-9 medium-8 columns content">
    <h3><?= h($kompVialsDump->id) ?></h3>
    <table class="vertical-table table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($kompVialsDump->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gene') ?></th>
            <td><?= h($kompVialsDump->gene) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('KOMP Gene Id') ?></th>
            <td><?= h($kompVialsDump->komp_gene_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Clone name') ?></th>
            <td><?= h($kompVialsDump->clone_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Clone Nickname') ?></th>
            <td><?= h($kompVialsDump->clone_nickname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mouse Clone Id') ?></th>
            <td><?= h($kompVialsDump->mouse_clone_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mutation') ?></th>
            <td><?= h($kompVialsDump->mutation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mutation Id') ?></th>
            <td><?= h($kompVialsDump->mutation_id_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cell Line') ?></th>
            <td><?= h($kompVialsDump->cell_line) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('MGI Accession Id') ?></th>
            <td><?= h($kompVialsDump->mgi_accession_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('epd') ?></th>
            <td><?= h($kompVialsDump->epd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('KOMP Vial Id') ?></th>
            <td><?= h($kompVialsDump->komp_vial_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($kompVialsDump->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($kompVialsDump->modified) ?></td>
        </tr>
    </table>
</div>

    <div class="related horizontal-table">
        <!-- Related Job Requests -->
        <?php if (!empty($kompVialsDump->kompvials_jobs)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Job Requests</div>  
        <div class="table-responsive horizontal-table">
        <table class="table stripe order-column">
            <tr>
                <th><?= __('Job ID') ?></th>
                <th><?= __('Strain Name') ?></th>
                <th><?= __('MMRRC Stock#') ?></th>
                <th><?= __('Memebership') ?></th>
                <th><?= __('Request Date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($kompVialsDump->kompvials_jobs as $entry): ?>
            <tr>
            <td><?= $entry->job->id ?></td>
            <td><?= $entry->job->strain_name ?></td>
            <td><?= $entry->job->mmrrc_no ?></td>
            <td><?= $entry->job->membership ?></td>
            <td><?= $entry->job->request_date ?></td>
            <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'Jobs', $entry->job->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>
