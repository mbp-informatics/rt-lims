<div class="container">
    <div class="panel-group">
        <div class="panel panel-primary">
            <?php if (!$genotypeRequest->epi_bool){ ?> 
                <div class="panel-heading">MCRL Genotyping Form</div>
                <div class="panel-body">
                    <div class="container">
                        <div class='row'>
                            <div class='col-xs-4'><strong><?= __('Submission Date') ?>: </strong><?php if (isset($genotypeRequest->created)) { echo h($genotypeRequest->created->format('n/j/Y')); } ?></div>
                            <?php if (!$genotypeRequest->epi_bool): ?>
                            <div class='col-xs-3'><strong><?= __('Collection Date') ?>: </strong><?php if (isset($genotypeRequest->collection_date)) { echo h($genotypeRequest->collection_date->format('n/j/Y')); } ?></div><?php endif; ?>
                            <div class='col-xs-5'><strong><?= __('Job ID#') ?>: </strong><?= h($genotypeRequest->job_id) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-4'><strong><?= __('Submitted By') ?>: </strong><?= h($genotypeRequest->user->name) ?></div>
                            <div class='col-xs-3'></div>
                            <div class='col-xs-5'><strong><?= __('Recharge #') ?>: </strong><?= h($genotypeRequest->recharge) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'><strong><?= __('Strain Name') ?>: </strong><?= h($genotypeRequest->job->strain_name) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-7'><strong><?= __('MMRRC/Clone ID') ?>: </strong><?= h($genotypeRequest->job->mmrrc_no) ?></div>
                            <div class='col-xs-5'><strong><?= __('If chimera sperm, BL#') ?>: </strong><?= h($genotypeRequest->job->bl_no) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-8'><strong><?= __('Mosaic Colony Name') ?>: </strong><?= h($genotypeRequest->mosaic_name); ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-8'><strong><?= __('Targeting Confirmation Requested?') ?>: </strong><?= $genotypeRequest->job->targeting_conf ? __(' Yes') : __('No'); ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-7'><strong><?= __('Note or Status') ?>: </strong><?= h($genotypeRequest->notes) ?></div>
                            <div class='col-xs-5'><strong><?= __('Sample Type') ?>: </strong><?= h($genotypeRequest->sample_type) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= $this->Text->autoParagraph(h($genotypeRequest->comments)); ?></div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="panel-heading">MCRL Epi/Vas Genotyping Form</div>
                <div class="panel-body">
                    <div class="container">
                        <div class='row'>
                            <div class='col-xs-4'><strong><?= __('Job ID#') ?>: </strong><?= h($genotypeRequest->job_id) ?></div>
                            <div class='col-sm-2'></div>
                            <div class='col-xs-6'><strong><?= __('Recharge #') ?>: </strong><?= h($genotypeRequest->recharge) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-4'><strong><?= __('Submission Date') ?>: </strong><?php if (isset($genotypeRequest->created)) { echo h($genotypeRequest->created->format('n/j/Y')); } ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-4'><strong><?= __('Submitted By') ?>: </strong><?= h($genotypeRequest->user->name) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'><strong><?= __('Strain Name') ?>: </strong><?= h($genotypeRequest->job->strain_name) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-8'><strong><?= __('Mosaic Colony Name') ?>: </strong><?= h($genotypeRequest->mosaic_name); ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-6'><strong><?= __('Note or Status') ?>: </strong><?= h($genotypeRequest->notes) ?></div>
                            <div class='col-xs-4'><strong><?= __('Sample Type') ?>: </strong><?= h($genotypeRequest->sample_type) ?></div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'><strong><?= __('Comments') ?>: </strong><?= $this->Text->autoParagraph(h($genotypeRequest->comments)); ?></div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
        <br><br>
        <div class="related horizontal-table table-responsive">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <?php if (!empty($genotypeRequest->genotypings)): ?>
                        <table class="table stripe order-column">
                            <tr>
                                <th scope="col"><?= __('Male ID No') ?></th>
                                <th scope="col"><?= __('Sperm Cryo') ?></th>
                                <th scope="col"><?= __('Embryo Cryo') ?></th>
                                <?php if (!$genotypeRequest->epi_bool): ?><th scope="col"><?= __('Embryo Count') ?></th><?php endif; ?>
                                <th scope="col"><?= __('IVF') ?></th>
                                <th scope="col"><?= __('Genotype') ?></th>
                                <th scope="col"><?= __('Source') ?></th>
                                <th scope="col"><?= __('Note') ?></th>
                            </tr>
                            <?php foreach ($genotypeRequest->genotypings as $genotypings): ?>
                            <tr>
                                <td><?= h($genotypings->male_id_no) ?></td>
                                <td><?= h($genotypings->sperm_cryo_id) ?></td>
                                <td><?= h($genotypings->embryo_cryo_id) ?></td>
                                <?php if (!$genotypeRequest->epi_bool): ?><td><?= h($genotypings->embryo_count) ?></td><?php endif; ?>
                                <td><?= h($genotypings->ivf_id) ?></td>
                                <td><?= h($genotypings->genotype) ?></td>
                                <td><?= h($genotypings->source) ?></td>
                                <td><?= h($genotypings->note) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($genotypeRequest->epi_bool): ?>
            <div class="related horizontal-table table-responsive">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <table class="table stripe order-column">
                            <tr>
                                <th scope="col"><?= __('SC ID') ?></th>
                                <th scope="col"><?= __('Vial Label') ?></th>
                                <th scope="col"><?= __('Tank') ?></th>
                                <th scope="col"><?= __('Rack') ?></th>
                                <th scope="col"><?= __('Box') ?></th>
                                <th scope="col"><?= __('Space') ?></th>
                                <th scope="col"><?= __('Cap Color') ?></th>
                            </tr>
                            <?php foreach ($genotypeRequest->genotypings as $genotyping): ?>
                                    <tr>
                                        <td><?= h($genotyping->sperm_cryo_id) ?></td>
                                        <td><?= h($genotyping->vial_label) ?></td>
                                        <td><?= h($genotyping->inventory_location->inventory_box->inventory_container->parent_inventory_container->name) ?></td>
                                        <td><?= h($genotyping->inventory_location->inventory_box->inventory_container->name) ?></td>
                                        <td><?= h($genotyping->inventory_location->inventory_box->name) ?></td>
                                        <td><?= h($genotyping->inventory_location->cell) ?></td>
                                        <td><?= h($genotyping->sperm_cryo->cryo_caps_label_color) ?></td>
                                    </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>