<?php
	//Prepare colonies
	$c_names = '';
	$c_name = '';
	if (!empty($injection->legacy_id_no)){
		$c_names = $injection->legacy_id_no;
		$c_name = $injection->legacy_id_no;
	} else {
		$c_name = $colonies[0]['name'];
		foreach ($colonies as $c) {
			$c_names .= $c['name'].' | ';
		}
	}
	$c_names = rtrim($c_names, ' | ');

	//Prepare projects and genes
	$projectsString = '';
	$genesString = '';
	$projectsNameString = '';
    foreach ($injection->projects as $proj) {
        $projectsString .= "id: <a href='/projects/view/{$proj->id}'>{$proj->id}</a> (type: {$proj->project_type->type}), ";
        $projectsNameString .= $proj->project_name;
        foreach ($proj->mgi_genes_dump as $gene) {
            $genesString .= "{$gene->marker_symbol} (<a href='/mgi-genes-dump/view/$gene->mgi_accession_id'>{$gene->mgi_accession_id}</a>), ";
        }
	    if ($proj->project_type_id == 1) { //KOMP project
			$isKompProject = true;
		}
    }
switch ($imitsStatus) {
	case 'insert pending':
	case 'update pending':
	$color = 'orange';
	break;
	case 'updated':
	$color = 'green';
	break;
	default:
	$color = 'gray';
	break;
}
$dot = "<span style='border: display:inline-block; line-height:30%; font-size: 30px; color:{$color};''>&#x25cf;</span>";
?>
<div class="injections esc view large-9 medium-8 columns content">


<div class='row' style="margin-top:-25px">
	<div class='col-xs-10'>
    <h3>
    <?php
    if (isset($injection->legacy_id_no)){
    		echo "ESC Microinjection ID #".h($injection->legacy_id_no) .' | '. $c_names .' | '.$projectsNameString;
    	} else {
    		echo "ESC Microinjection ID #".h($injection->id) .' | '. $c_names .' | '.$projectsNameString;
		}
	?>
	</h3>
	</div>
	<div class='col-xs-2'>
    	<?php
        if ($injection->injection_type == 'CRM' || isset($isKompProject)) {
			echo '<button class="btn btn-default pull-right pad-button" id="match-colonies-genes"><span class="glyphicon glyphicon-pencil"></span>Match Colonies to Genes</button>';
    	}
    	echo $this->html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('See Founders'), ['controller' => 'mosaic', 'action' => 'list_founders', $c_name], array('escape' => false, 'class' => 'btn btn-info pad-button pull-right', 'target' => '_BLANK'));

    	echo $this->html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit Microinjection'), ['controller' => 'injections', 'action' => 'edit', $injection->id], array('escape' => false, 'class' => 'btn btn-warning pad-button pull-right'));
        ?>
	</div>
</div>
<hr/>
    <div class='container-fluid'>
		<div class='row important'>
			<div class='col-xs-4'><strong><?= __('Project(s)') ?></strong>: <?= rtrim($projectsString, ', ') ?></div>
			<div class='col-xs-3'><strong><?= __('Gene(s)') ?></strong>: <?= rtrim($genesString, ', ') ?></div>
			<div class='col-xs-2'><strong><?= __('iMits Status') ?></strong>:<br/><div style="margin-top:-3px;"><?= $imitsStatus.$dot ?></div></div>
		<?php if (!empty($injection->job_id)) { ?>
			<div class='col-xs-2'><strong><?= __('Job Id') ?></strong>:<br/><div style="margin-top:-3px;">
			<?= "<a href='/jobs/view/{$injection->job_id}'>{$injection->job_id}</a>" ?></div></div>
		<?php } ?>
		</div>
		<hr/>
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('Injection date') ?>:</strong> <?= isset($injection->injection_date) ? h($injection->injection_date->format('Y-m-d')) : null ?></div>
			<div class='col-xs-4'><strong><?= __('QC State') ?>:</strong> <?= h($injection->qc_state) ?></div>
			<div class='col-xs-4'><strong><?= __('Recharge') ?></strong>: <?= h($injection->recharge) ?></div>		
		</div>
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('Investigator') ?></strong>: <?= h($injection->investigator) ?></div>
			<div class='col-xs-4'><strong><?= __('Order #') ?></strong>: <?= h($injection->pts_ko_mo) ?></div>
			<div class='col-xs-4'><strong><?= __('Injected By') ?></strong>: <?= h($injection->injected_by) ?></div>
		</div>
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('Membership') ?>:</strong> <?= h($injection->membership) ?></div>
			<div class='col-xs-4'><span class="badge"><strong>Colony:</strong> 
			<?= $c_names ?>
			</span></div>
		</div>
        <div class='row'>
            <div class='col-xs-4'><strong><?= __('8-cell?') ?> </strong><?= $injection->bl_eight_cell ? __('<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>') : __('<span class="bool-no glyphicon glyphicon-remove"> No</span>'); ?></div>
			<div class='col-xs-4'><strong><?= __('FMP ID') ?></strong>: <?= h($injection->fmp_id_no) ?></div>
		</div>
		<div class='alert alert-info' role='alert'>ES Cells</div>
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('ES Cell Source') ?></strong>: <?= h($injection->es_cell_source) ?></div>
			<div class='col-xs-4'><strong><?= __('Parental ESC Line') ?></strong>: <?= h($injection->parental_esc_line) ?></div>
			<div class='col-xs-4'><strong><?= __('Coat Color') ?></strong>: <?= h($injection->coat_color) ?></div>
		</div>
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('ESC Morphology') ?></strong>: <?= h($injection->esc_morphology) ?></div>
		</div>

		<div class='alert alert-info' role='alert'>Nucleases</div>
			<div class='row'>
				<div class='col-xs-4'><strong><?= __('mRNA Nuclease') ?>:</strong> <?= h($injection->mrna_nuclease) ?></div>
				<div class='col-xs-4'><strong><?= __('mRNA Nuclease Concentration') ?></strong> (ng/ul): <?= h($injection->mrna_nuclease_concentration) ?></div>
				<div class='col-xs-4'><strong><?= __('gRNA Concentration') ?></strong> (ng/ul): <?= h($injection->grna_concentration) ?></div>
			</div>
			<div class='row'>
				<div class='col-xs-4'><strong><?= __('Protein Nuclease') ?>:</strong> <?= h($injection->protein_nuclease) ?></div>
				<div class='col-xs-4'><strong><?= __('Protein Nuclease Concentration') ?></strong> (ng/ul):<?=  h($injection->protein_nuclease_concentration) ?></div>
			</div>

		<div class='alert alert-info' role='alert'>Embryo collection</div>
			<div class='row'>
				<div class='col-xs-4'><strong><?= __('Donor Strain') ?>:</strong> <?= h($injection->donor_strain) ?></div>
				<div class='col-xs-4'><strong><?= __('Donor DOB') ?>:</strong> <?= isset($injection->donor_date_of_birth) ? h($injection->donor_date_of_birth->format('Y-m-d')) : '-' ?></div>
				<div class='col-xs-4'><strong><?= __('Stud Set') ?>:</strong> <?= h($injection->stud_ids) ?></div>
			</div>
			<div class='row'>
				<div class='col-xs-4'><strong><?= __('PMSG Time') ?>:</strong> <?= isset($injection->pmsg_time) ? h($injection->pmsg_time->format('g:i A')) : '-' ?></div>
				<div class='col-xs-4'><strong><?= __('HCG Time') ?>:</strong> <?= isset($injection->pmsg_time) ? h($injection->hcg_time->format('g:i A')) : '-' ?></div>
			</div>
			<hr />
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('Number Mated') ?>:</strong> <?= $this->Number->format($injection->number_mated) ?></div>
			<div class='col-xs-4'><strong><?= __('Number Plugged') ?>:</strong> <?= $this->Number->format($injection->number_plugged) ?> /<span style="color:#ff0000"><?= $injection->number_mated ? number_format(($injection->number_plugged/$injection->number_mated)*100, 2) : '-' ?> %</span></div>
			<div class='col-xs-4'><strong>Embryos/Plug:</strong> 
			<?= $injection->number_plugged ? number_format($injection->total_embryos/$injection->number_plugged, 2) : '-' ?></div>
		</div>
		<div class='row'>
			<div class='col-xs-4'><strong><?= __('Total Injectable Embryos') ?>:</strong> <?= $this->Number->format($injection->total_embryos) ?></div>
				<div class='col-xs-4'><strong><?= __('Embryos Collected By') ?>:</strong> <?= h($injection->embryos_collected_by) ?>	</div>
		</div>
        <div class='alert alert-info' role='alert'>Microinjection</div>
        <div class="row" >
			<div class='col-xs-3'><strong><?= __('Injection Type') ?>:</strong> <?= $injection->microinjection_injection_type ?></div>
			<div class='col-xs-3'><strong><?= __('Embryos Injected') ?>:</strong> <?= $injection->number_injected ?></div>
			<div class='col-xs-3'><strong><?= __('Embryos Survived') ?>:</strong> <?= $injection->number_survived ?></div>
			<!-- <div class='col-xs-3'><strong><?= __('ET By') ?>:</strong> <?= $injection->et_by ?></div> -->
        </div>
        <div class="row" >
        	<div class='col-xs-12'><strong><?= __('Comments') ?>:</strong> <?= $injection->comments ?></div>
        </div>
	</div>

    <div class="related horizontal-table table-responsive">
        <hr/>
        <?php if (!empty($injection->embryo_transfers)): ?>
        <h4><?= __('Related Transfers') ?></h4>
        <table class="table stripe order-column responsive">
            <thead>
	            <tr>
	                <th><?= __('ID') ?></th>
	                <th><?= __('Location') ?></th>
	                <th><?= __('ET By') ?></th>
	                <th><?= __('Total Tx') ?></th>
	                <th><?= __('Total Pups') ?></th>
	                <th><?= __('Total Female Mutants') ?></th>
	                <th><?= __('Total Male Mutants') ?></th>
	                <th class="actions"><?= __('Actions') ?></th>
	           
	            </tr>
        	</thead>
            <?php foreach ($injection->embryo_transfers as $transfer): ?>
            	<tr>
	                <td><?= $this->Html->link($transfer->id, ['controller' => 'embryoTransfers', 'action' => 'view', $transfer->id]) ?></td>
					<td><?= h($transfer->et_location) ?></td>
					<td><?= h($transfer->et_by) ?></td>
					<td><?php if (!empty($transfer->recipients)){
	                    $recCount = 0;
	                    foreach ($transfer->recipients as $tx) {
                            $recCount += $tx->total_tx;
                        }
                        echo $recCount;
                    } else {
                        echo '0';
                    } ?></td>
					<td><?php if (!empty($transfer->recipients)){
	                    $samplesCount = 0;
	                    foreach ($transfer->recipients as $tx) {
                            $samplesCount += $tx->total_pups;
                        }
                        echo $samplesCount;
                    } else {
                        echo '0';
                    } ?></td>
					<td><?php if (!empty($transfer->recipients)){
	                    $samplesCount = 0;
	                    foreach ($transfer->recipients as $tx) {
                            $samplesCount += $tx->female_mut;
                        }
                        echo $samplesCount;
                    } else {
                        echo '0';
                    } ?></td>
					<td><?php if (!empty($transfer->recipients)){
	                    $samplesCount = 0;
	                    foreach ($transfer->recipients as $tx) {
                            $samplesCount += $tx->male_mut;
                        }
                        echo $samplesCount;
                    } else {
                        echo '0';
                    } ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View MICL">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller' => 'EmbryoTransfers', $transfer->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="View MTGL">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-globe"></span>', ['action' => 'view', 'controller' => 'EmbryoTransfers', $transfer->id, 'mtgl'],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller' => 'EmbryoTransfers',  $transfer->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller' => 'EmbryoTransfers', $transfer->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $injection->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <br/>
	<?php
		echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Transfer'), ['controller' => 'EmbryoTransfers', 'action' => 'add', $injection->id, 'mtgl', 'injection_id' => $injection->id], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
	?>
</div>
<div id="dialog-match-colonies-genes" title="Match Colonies to Genes"></div>
<!-- Display Match Colonies Form -->
<script>
$( document ).ready(function() {
iniDialog('#match-colonies-genes', '/colonies/matchCrmColonies/<?= $injection->id ?>', '', '', 600, 550);
<?php
if (isset($_GET['match-colonies']) && $_GET['match-colonies'] == '1') { ?>
		$('#match-colonies-genes').trigger('click');
<?php } ?>
});
</script>