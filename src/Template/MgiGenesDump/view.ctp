<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('New Gene Status'), ['controller' => 'genes-statuses', 'action' => 'add', $mgiGenesDump->mgi_accession_id], array('escape' => false, 'class' => 'btn btn-warning pad-button pull-right', 'style' => 'margin-bottom:20px;'));  ?>
<div class="mgiGenesDump view large-9 medium-8 columns content">
    <h3><?= h("$mgiGenesDump->marker_symbol ({$mgiGenesDump->mgi_accession_id})") ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th scope="row"><?= __('Marker Symbol') ?></th>
            <td><span class="label label-success" style="font-size:14px;"><?= h($mgiGenesDump->marker_symbol) ?></span></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mgi Accession Id') ?></th>
            <td><?= h($mgiGenesDump->mgi_accession_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Chr') ?></th>
            <td><?= h($mgiGenesDump->chr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cm Position') ?></th>
            <td><?= h($mgiGenesDump->cm_position) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Strand') ?></th>
            <td><?= h($mgiGenesDump->strand) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($mgiGenesDump->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Marker Name') ?></th>
            <td><?= h($mgiGenesDump->marker_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Marker Type') ?></th>
            <td><?= h($mgiGenesDump->marker_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Feature Type') ?></th>
            <td><?= h($mgiGenesDump->feature_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Marker Synonyms') ?></th>
            <td><?= h($mgiGenesDump->marker_synonyms) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($mgiGenesDump->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genome Coord Start') ?></th>
            <td><?= $this->Number->format($mgiGenesDump->genome_coord_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Genome Coord End') ?></th>
            <td><?= $this->Number->format($mgiGenesDump->genome_coord_end) ?></td>
        </tr>
    </table>
</div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->genes_statuses)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Gene Status History</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Status') ?></th>
                <th><?= __('Date created') ?></th>
                <th><?= __('Comment') ?></th>
                <th><?= __('Created by') ?></th>
                <th class="actions">Actions</th>
            </tr>
            <?php foreach ($mgiGenesDump->genes_statuses as $status): ?>
            <tr>
                <td><?= h($status->gene_status->gene_status) ?></td>
                <td><?= h($status->created) ?></td>
                <td><?= h($status->comment) ?></td>
                <td><?= h($status->user->name) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'genes-statuses', $status->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'genes-statuses', $status->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $status->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->colonies  )): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related RT-LIMS Colonies</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Colony Id') ?></th>
                <th><?= __('Denotation') ?></th>
                <th><?= __('Colony Name') ?></th>
                <th><?= __('RT-LIMS Injection Id') ?></th>
                <th><?= __('RT-LIMS Project Id') ?></th>
                <th><?= __('Created') ?></th>
            </tr>
            <?php foreach ($mgiGenesDump->colonies  as $col): ?>
            <tr>
                <td><?= h($col->colony_id) ?></td>
                <td><?= h($col->denotation) ?></td>
                <td><?= h($col->name) ?></td>
                <td><?= h($col->injection_id) ?></td>
                <td><?= h($col->project_id) ?></td>
                <td><?= h($col->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->projects)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related RT-LIMS Projects</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('RT-LIMS Project ID') ?></th>
                <th><?= __('Project type') ?></th>
                <th><?= __('Project Status') ?></th>
                <th><?= __('Mutation') ?></th>
                <th><?= __('Phenotype') ?></th>
                <th><?= __('Created') ?></th>
                <th class="actions">Actions</th>
            </tr>
            <?php foreach ($mgiGenesDump->projects as $proj): ?>
            <tr>
                <td><?= h($proj->id) ?></td>
                <td><?= h($proj->project_type->type) ?></td>
                <td><?= h($proj->project_status->status) ?></td>
                <td><?= h($proj->mutation->type) ?></td>
                <td><?= h($proj->phenotype->type) ?></td>
                <td><?= h($proj->created) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'projects', $proj->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'projects', $proj->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->crispr_designs)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related RT-LIMS CRISPR Designs</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('CRISPR id') ?></th>
                <th><?= __('Vector name') ?></th>
                <th><?= __('Nuclease') ?></th>
                <th><?= __('User') ?></th>
                <th><?= __('Created') ?></th>
                <th class="actions">Actions</th>
            </tr>
            <?php foreach ($mgiGenesDump->crispr_designs as $cd): ?>
            <tr>
                <td><?= h($cd->id) ?></td>
                <td><?= h($cd->vector_name) ?></td>
                <td><?= h($cd->nuclease) ?></td>
                <td><?= isset($cd->user->name) ? h($cd->user->name) : '-' ?></td>
                <td><?= h($cd->created) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'crispr-designs', $cd->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'crispr-designs', $cd->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->komp_projects_dump)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related KOMP projects</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Komp ID') ?></th>
                <th><?= __('MGI Accession ID') ?></th>
                <th><?= __('Colony Name') ?></th>
                <th><?= __('Clone name') ?></th>
                <th><?= __('Clone nickname') ?></th>
                <th><?= __('Mouse clone ID') ?></th>
                <th><?= __('mutation') ?></th>
                <th><?= __('Mutation id no') ?></th>
                <th><?= __('Cell line') ?></th>
                <th><?= __('epd') ?></th>
            </tr>
            <?php foreach ($mgiGenesDump->komp_projects_dump as $kp): ?>
            <tr>
                <td><?= h($kp->komp_id) ?></td>
                <td><?= h($kp->mgi_accession_id) ?></td>
                <td><?= h($kp->colony_name) ?></td>
                <td><?= h($kp->clone_name) ?></td>
                <td><?= h($kp->clone_nickname) ?></td>
                <td><?= h($kp->mouse_clone_id) ?></td>
                <td><?= h($kp->mutation) ?></td>
                <td><?= h($kp->mutation_id_no) ?></td>
                <td><?= h($kp->cell_line) ?></td>
                <td><?= h($kp->epd) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->imits_dump_mi_plans )): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related iMits MI Plans</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('MI Plan ID') ?></th>
                <th><?= __('MGI Accession ID') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('MI Attempts count') ?></th>
                <th><?= __('Phenotype Attempts count') ?></th>
                <th><?= __('CRISPR?') ?></th>
                <th><?= __('Active?') ?></th>
                <th class="actions"><?= __('View Full MI Plan') ?></th>
            </tr>
            <?php foreach ($mgiGenesDump->imits_dump_mi_plans as $mp_row): ?>
            <?php $mp = json_decode($mp_row->mi_plan_json); ?>
            <tr>
                <td><?= h($mp->id) ?></td>
                <td><?= h($mp->mgi_accession_id) ?></td>
                <td><?= h($mp->status_name) ?></td>
                <td><?= h($mp->mi_attempts_count) ?></td>
                <td><?= h($mp->phenotype_attempts_count) ?></td>
                <td><?= h($mp->mutagenesis_via_crispr_cas9) ?></td>
                <td><?= h($mp->is_active) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'imits-dump-mi-plans', $mp_row->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->imits_dump_mi_attempts )): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related iMits Microinjection Attempts</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('MI Attempt ID') ?></th>
                <th><?= __('MGI Accession ID') ?></th>
                <th><?= __('External ref') ?></th>
                <th><?= __('Founder num assays') ?></th>
                <th><?= __('Genotype Confirmed Allele Symbol') ?></th>
                <th><?= __('Strain name') ?></th>
                <th class="actions"><?= __('View Full MI Attempt') ?></th>
            </tr>
            <?php foreach ($mgiGenesDump->imits_dump_mi_attempts as $ma_row): ?>
            <?php $ma = json_decode($ma_row->mi_attempt_json ); ?>
            <tr>
                <td><?= h($ma_row->imits_mi_attempt_id) ?></td>
                <td><?= h($ma_row->mgi_accession_id) ?></td>
                <td><?= h($ma->external_ref) ?></td>
                <td><?= h($ma->founder_num_assays) ?></td>
                <td><?= !empty($ma->genotype_confirmed_allele_symbols) ? $ma->genotype_confirmed_allele_symbols : ''?></td>
                <td><?= h($ma->blast_strain_name) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'imits-dump-mi-attempts', $ma_row->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <?php if (!empty($mgiGenesDump->imits_dump_phenotype_attempts  )): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related iMits Phenotype Attempts</div>        
        <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Phenotype Attempt ID') ?></th>
                <th><?= __('MGI Accession ID') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Phenotyping started?') ?></th>
                <th><?= __('Colony background strain name') ?></th>
                <th><?= __('Report to public?') ?></th>
                <th class="actions"><?= __('View Full Phenotyping Attempt') ?></th>
            </tr>
            <?php foreach ($mgiGenesDump->imits_dump_phenotype_attempts  as $pa_row): ?>
            <?php $pa = json_decode($pa_row->phenotype_attempt_json ); ?>
            <tr>
                <td><?= h($pa_row->imits_phenotype_attempt_id) ?></td>
                <td><?= h($pa_row->mgi_accession_id) ?></td>
                <td><?= h($pa->status_name) ?></td>
                <td><?= h($pa->phenotyping_started) ?></td>
                <td><?= h($pa->colony_background_strain_name) ?></td>
                <td><?= h($pa->report_to_public) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'imits-dump-phenotype-attempts', $pa_row->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>



