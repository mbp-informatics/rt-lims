<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Edit Project # ' . $project->id) ?></legend>
            <div style="margin:15px 0px; border:1px solid #ddd; background-color:#eee; text-align:center; padding:20px 80px;">
                <h3>Associated Genes</h3>
                <?php
                    if (!empty($project->mgi_genes_dump)) {
                        foreach ($project->mgi_genes_dump as $gene) {
                            echo '<strong>'.$gene->marker_symbol.'</strong> ('. $gene->mgi_accession_id .'), ';
                        }
                    }
                ?>
                <br/>
                <p><span class="glyphicon glyphicon-pencil"></span> <a href="/projects-genes" style="text-decoration:underline">Click here to go to projects-genes model to edit genes associated with this project.</a></p>
            </div>
            <?php
                echo $this->Form->input('project_type_id', ['options' => $projectTypes, 'empty' => false]);
                $disabled = ($project->project_type_id === 6) ? true : false; //disable if KOMP2
                echo $this->Form->input('custom_name', ['empty' => true, 'label' => 'Custom Project Name', 'disabled' => $disabled]);
                echo $this->Form->input('project_status_id', ['empty' => false]);
                echo $this->Form->input('mutation_id', ['options' => $mutations, 'empty' => false]);
                echo $this->Form->input('phenotype_id', ['options' => $phenotypes, 'empty' => true]);
                echo $this->Form->input('comments', ['type' => 'textarea', 'empty' => true]);
            ?>
            <div class="important">
            <?php
            if (!empty($project->pts_id_no) || !empty($project->komp_id_no) || !empty($project->mmrrc_id_no)) {
                $is_disabled = true;
            } else {
                $is_disabled = false;
            } ?> 
            <?= $this->Form->input('komp_id_no', ['empty' => true, 'disabled' => $is_disabled]); ?>
            <?= $this->Form->input('pts_id_no', ['empty' => true, 'disabled' => $is_disabled]); ?>
            <?= $this->Form->input('mmrrc_id_no', ['empty' => true, 'disabled' => $is_disabled]); ?>
        </div>       
    </fieldset>
    <br/>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
<br/>
</div>
<script>
$( document ).ready(function() {
    /**
     * EVENT: run this when mutation dropdown changes
     */ 
    $('#mutation-id').change(function(e){
        var mutation = $(this).find(':selected').text()
        if (mutation == '') {
            return true;
        }
        if (mutation.includes('_LA')) {
            $('#phenotype-id').val(1); //set phenotype to k2p2la
        } else {
            $('#phenotype-id').val(2); //set phenotype to k2p2ea (early onset) by default
        }
        lightUp('#phenotype-id');
    });

    /**
     * EVENT: run this when "Project type" dropdown changes
     */ 
    $('#project-type-id').change(function(e) {        
        // Custom project name input should only be active when project type != KOMP2
        if ($(this).val() != '6') {
            $('#custom-name').attr('disabled', false);
        } else {
            $('#custom-name').val('').attr('readonly', true);
        }
    });

}); //end document ready
</script>
