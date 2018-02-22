<div class="projects view large-9 medium-8 columns content">
<?php
        $colStr = '';
        foreach ($project->colonies as $col) {
            $colStr .= "<span class='badge'>{$col->name}</span> ";
        }
        $projectName = $project->custom_name ? $project->custom_name : $project->name; 
        echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit this project'), ['action' => 'edit', $project->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
        ?>
    <h3><?= "Project '{$projectName}'" ?></h3>
        <br/>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Colonies') ?></th>
            <td><?= $colStr ?></td>
        </tr>
        <?php
        if ($project->custom_name) { ?>
            <tr>
                <th><?= __('Custom Project Name') ?></th>
                <td><?= $projectName ?></td>
            </tr>
        <?php } else { ?>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= $projectName ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th><?= __('Project Type') ?></th>
            <td><?= $project->has('project_type') ? $this->Html->link($project->project_type->type, ['controller' => 'ProjectTypes', 'action' => 'view', $project->project_type->id]) : '' ?></td>
        </tr>
        </table>
        <div class="important" style="background-color:#FAFAF8">
            <table class="table stripe order-column">
            <tr>
                <th><?= __('PTS Project id') ?></th>
                <td><?= h($project->pts_id_no) ?></td>
            </tr>
            <tr>
                <th><?= __('KOMP Project id') ?></th>
                <td><?= h($project->komp_id_no) ?></td>
            </tr>
            <tr>
                <th><?= __('MMRRC Order id') ?></th>
                <td><?= h($project->mmrrc_id_no) ?></td>
            </tr>
            </table>
        </div>
        <table class="table stripe order-column">
        <tr>
            <th><?= __('Current Project Status') ?></th>
            <td><?= $project->has('project_status') ? $this->Html->link($project->project_status->status, ['controller' => 'ProjectStatuses', 'action' => 'view', $project->project_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Mutation') ?></th>
            <td><?= $project->has('mutation') ? $this->Html->link($project->mutation->type, ['controller' => 'Mutations', 'action' => 'view', $project->mutation->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Phenotype') ?></th>
            <td><?= $project->has('phenotype') ? $this->Html->link($project->phenotype->type, ['controller' => 'Phenotypes', 'action' => 'view', $project->phenotype->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Genes') ?></th>
            <td>
            <?php
            foreach ($project->mgi_genes_dump as $g) { ?>
                <?= h($g->marker_symbol) ?> <small>(<?= $this->Html->link($g->mgi_accession_id, ['action' => 'view', 'controller' => 'mgi-genes-dump', $g->mgi_accession_id]);  ?>)</small> <br/>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($project->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($project->modified) ?></tr>
        </tr>
        <tr>
            <th><?= __('Comments') ?></th>
            <td><?= h($project->comments) ?></tr>
        </tr>
    </table>
    <hr/>
    <div class="related" style="margin-top:45px;">


    <div class="related horizontal-table">
        <!-- Related Colonies -->
        <?php if (!empty($project->colonies)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Colonies</div>  
        <div class="table-responsive horizontal-table">
        <table class="table stripe order-column">
            <tr>
                <th><?= __('Name') ?></th>
                <th><?= __('Injection Id') ?></th>
                <th><?= __('MGI Accession Id') ?></th>
            </tr>
            <?php foreach ($project->colonies as $col): ?>
            <tr>
                <td><span class="badge"><?= h($col->name) ?></span></td>
                <td><?= h($col->injection_id) ?></td>
                <td><?= "<a href='/mgi-genes-dump/view/{$col->mgi_accession_id}'>{$col->mgi_accession_id}</a>" ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related horizontal-table">
        <!-- Related Crispr Designs -->
        <?php if (!empty($project->crispr_designs)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related Crispr Designs</div>  
        <div class="table-responsive horizontal-table">
        <table class="table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Vector Name') ?></th>
                <th><?= __('Nuclease') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('batch upload?') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($project->crispr_designs as $cd): ?>
            <tr>
                <td><?= h($cd->id) ?></td>
                <td><?= h($cd->vector_name) ?></td>
                <td><?= h($cd->nuclease) ?></td>
                <td><?= h($cd->created) ?></td>
                <td><?php if (!empty($cd->batch_upload_uid)) { echo $cd->batch_upload_uid; } else { echo '<em>no</em>'; } ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'crispr-designs', $cd->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller'=>'crispr-designs', $cd->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>

    <div class="related">
        <!-- Related Injections -->
        <?php if (!empty($project->injections)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Injection details</div>        
        <div class="table-responsive">
        <table class="table stripe order-column">
        <tbody>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Qc State') ?></th>
                <th><?= __('User') ?></th>
                <th><?= __('Colony Id') ?></th>
                <th><?= __('Project Id') ?></th>
                <th><?= __('Recharge') ?></th>
                <th><?= __('Geno Lab') ?></th>
                <th><?= __('Injection Date') ?></th>
                <th><?= __('Membership') ?></th>
                <th><?= __('Donor Strain') ?></th>
                <th><?= __('Donor Date Of Birth') ?></th>
                <th><?= __('Stud Ids') ?></th>
                <th><?= __('Pmsg Time') ?></th>
                <th><?= __('Hcg Time') ?></th>
                <th><?= __('Number Mated') ?></th>
                <th><?= __('Number Plugged') ?></th>
                <th><?= __('Total Eggs Collected') ?></th>
                <th><?= __('Embryo Collection Time') ?></th>
                <th><?= __('Collection Medium') ?></th>
                <th><?= __('Zygote Production By') ?></th>
                <th><?= __('Fresh Or Frozen') ?></th>
                <th><?= __('Injection Method') ?></th>
                <th><?= __('Number Injected') ?></th>
                <th><?= __('Number Survived') ?></th>
                <th><?= __('Number Transferred') ?></th>
                <th><?= __('Comments') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Mi Plan Id') ?></th>
                <th><?= __('Mi Attempt Id') ?></th>
                <th><?= __('Clone Id') ?></th>
                <th><?= __('Colony Qc Id') ?></th>
                <th><?= __('Founder Pups') ?></th>
                <th><?= __('Assay Type') ?></th>
                <th><?= __('Num Assayed') ?></th>
                <th><?= __('Num Pos Results') ?></th>
                <th><?= __('Num Mutant Founders') ?></th>
                <th><?= __('Num Mutant Founders Breeders') ?></th>
                <th><?= __('Colony Name') ?></th>
                <th><?= __('Genotype Confirmed') ?></th>
                <th><?= __('Report To Public') ?></th>
                <th><?= __('Unwanted Allele') ?></th>
                <th><?= __('Unwanted Allele Description') ?></th>
                <th><?= __('Distrobution Repository') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($project->injections as $injections): ?>
            <tr>
                <td><?= h($injections->id) ?></td>
                <td><?= h($injections->qc_state) ?></td>
                <td><?= isset($injections->user->name) ? h($injections->user->name) : '' ?></td>
                <td><?= h($injections->colony_id) ?></td>
                <td><?= h($project->id) ?></td>
                <td><?= h($injections->recharge) ?></td>
                <td><?= h($injections->geno_lab) ?></td>
                <td><?= h($injections->injection_date) ?></td>
                <td><?= h($injections->membership) ?></td>
                <td><?= h($injections->donor_strain) ?></td>
                <td><?= h($injections->donor_date_of_birth) ?></td>
                <td><?= h($injections->stud_ids) ?></td>
                <td><?= h($injections->pmsg_time) ?></td>
                <td><?= h($injections->hcg_time) ?></td>
                <td><?= h($injections->number_mated) ?></td>
                <td><?= h($injections->number_plugged) ?></td>
                <td><?= h($injections->total_eggs_collected) ?></td>
                <td><?= h($injections->embryo_collection_time) ?></td>
                <td><?= h($injections->collection_medium) ?></td>
                <td><?= h($injections->zygote_production_by) ?></td>
                <td><?= h($injections->fresh_or_frozen) ?></td>
                <td><?= h($injections->injection_method) ?></td>
                <td><?= h($injections->number_injected) ?></td>
                <td><?= h($injections->number_survived) ?></td>
                <td><?= h($injections->number_transferred) ?></td>
                <td><?= h($injections->comments) ?></td>
                <td><?= h($injections->created) ?></td>
                <td><?= h($injections->modified) ?></td>
                <td><?= h($injections->mi_plan_id) ?></td>
                <td><?= h($injections->mi_attempt_id) ?></td>
                <td><?= h($injections->clone_id) ?></td>
                <td><?= h($injections->colony_qc_id) ?></td>
                <td><?= h($injections->founder_pups) ?></td>
                <td><?= h($injections->assay_type) ?></td>
                <td><?= h($injections->num_assayed) ?></td>
                <td><?= h($injections->num_pos_results) ?></td>
                <td><?= h($injections->num_mutant_founders) ?></td>
                <td><?= h($injections->num_mutant_founders_breeders) ?></td>
                <td><?= h($injections->colony_name) ?></td>
                <td><?= h($injections->genotype_confirmed) ?></td>
                <td><?= h($injections->report_to_public) ?></td>
                <td><?= h($injections->unwanted_allele) ?></td>
                <td><?= h($injections->unwanted_allele_description) ?></td>
                <td><?= h($injections->distrobution_repository) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'injections', $injections->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller'=>'injections', $injections->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                </td>
            </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>
    <div class="related horizontal-table">
        <!-- Related Project Milestones -->
        <?php if (!empty($project->project_milestones)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related Project Milestones</div>  
        <div class="table-responsive horizontal-table">
        <table class="table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Project Id') ?></th>
                <th><?= __('Project Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
            </tr>
            <?php foreach ($project->project_milestones as $projectMilestones): ?>
            <tr>
                <td><?= h($projectMilestones->id) ?></td>
                <td><?= h($projectMilestones->project_id) ?></td>
                <td><?= h($projectMilestones->project_status['status']) ?></td>
                <td><?= h($projectMilestones->created) ?></td>
                <td><?= h($projectMilestones->modified) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>
    <div class="related horizontal-table">
        <!-- Related Project Genes -->
        <?php if (!empty($project->mgi_genes_dump)): ?>
        <hr />
        <div class='alert alert-info' role='alert'>Related MGI Genes</div>  
        <div class="table-responsive">
        <table class="table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Mgi Accession Id') ?></th>
                <th><?= __('Marker Symbol') ?></th>
                <th><?= __('Marker Synonyms') ?></th>
                <th><?= __('Marker Name') ?></th>
                <th><?= __('Marker Type') ?></th>
                <th><?= __('Feature Type') ?></th>
                <th><?= __('chr') ?></th>
                <th><?= __('CM position') ?></th>
                <th><?= __('Genome Coord Start') ?></th>
                <th><?= __('Genome Coord End') ?></th>
                <th><?= __('Strand') ?></th>
                <th><?= __('Status') ?></th>
            </tr>
            <?php foreach ($project->mgi_genes_dump as $gene): ?>
            <tr>
                <td><?= h($gene->id) ?></td>
                <td><?= $this->Html->link($gene->mgi_accession_id, ['action' => 'view', 'controller' => 'mgi-genes-dump', $gene->mgi_accession_id]);  ?></td>

                <td><?= h($gene->marker_symbol) ?></td>
                <td><?= h($gene->marker_synonyms) ?></td>
                <td><?= h($gene->marker_name) ?></td>
                <td><?= h($gene->marker_type) ?></td>
                <td><?= h($gene->feature_type) ?></td>
                <td><?= h($gene->chr) ?></td>
                <td><?= h($gene->cm_position) ?></td>
                <td><?= h($gene->genome_coord_start) ?></td>
                <td><?= h($gene->genome_coord_end) ?></td>
                <td><?= h($gene->strand) ?></td>
                <td><?= h($gene->status) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php endif; ?>
    </div>
</div>
