<script>
$( document ).ready(function() {
    var projIdCounter = <?= count($projectsInjection)+1 ?>;

    /**
     * EVENT: remove dropdown (X icon clicked)
     */ 
    $('.remove-icon').click(function(e){
        var projId = $(this).attr('id').replace('remove-proj-', '');
        $('#row-id-'+projId).remove();
    });

    /**
     * EVENT: Link more projects link clicked
     */ 
    $('#plus-link').click(function(e){
        $('#row-id-'+projIdCounter).show();
        var $select = $('#project-id-'+projIdCounter).selectize();
        var dropdown = $select[0].selectize;
        dropdown.enable();
        projIdCounter++;
    });

});
</script>
<style>
.content {
    padding:15px 10px 150px 10px;
    background-color:white;
}
.remove-icon {
    margin-top:32px;
    color:red;
    cursor:pointer;
    font-weight:bold;
}
</style>
<div class="projectsInjections form large-9 medium-8 columns content">
    <?= $this->Form->create($projectsInjection) ?>
    <fieldset>
        <legend><?= __('Edit Projects Associated with Injection ').$injectionId ?></legend>
        
        <?php
        $projIdCounter = 1;
        // First insert dropdowns for associated projects
        foreach ($projectsInjection as $pi) { ?>
            <div class="row" id='row-id-<?= $projIdCounter ?>'>
            <div class="col-sm-11">
            <?php
                echo $this->Form->input("project_id[$projIdCounter]", ['id' => 'project-id-'.$projIdCounter, 'options' => $projectNames, 'empty' => true, 'label'=>'RT-LIMS Project', 'value' => $pi->project_id]);
            ?>
            </div>
            <div id="remove-proj-<?= $projIdCounter ?>" class="col-sm-1 remove-icon"><span class="glyphicon glyphicon-remove"></span></div>
        </div>
        <script>
        $( document ).ready(function() {
            var $select = $('#project-id-<?= $projIdCounter ?>').selectize({ //prepare selectize object (projects dropdown) for later use
                placeholder:"Select from dropdown or start typing..."
            });
        });
        </script>
        <?php 
        $projIdCounter++;
        } //end foreach
        ?>

        <?php
        foreach (range(0,24) as $i) { ?>
            <div class="row" id='row-id-<?= $projIdCounter ?>' style="display:none;">
            <div class="col-sm-11">
            <?php
                echo $this->Form->input("project_id[$projIdCounter]", ['id' => 'project-id-'.$projIdCounter, 'options' => $projectNames, 'empty' => true, 'label'=>'RT-LIMS Project', 'disabled' => True]);
            ?>
            </div>
            <div id="remove-proj-<?= $projIdCounter ?>" class="col-sm-1 remove-icon"><span class="glyphicon glyphicon-remove"></span></div>
        </div>
        <script>
        $( document ).ready(function() {
            var $select = $('#project-id-<?= $projIdCounter ?>').selectize({ //prepare selectize object (projects dropdown) for later use
                placeholder:"Select from dropdown or start typing..."
            });
        });
        </script>
        <?php 
        $projIdCounter++;
        } //end foreach
        ?>

        <p class="pull-left" id="plus-link" style="cursor:pointer;"><small><span class="glyphicon glyphicon-plus"></span> Link more projects</small></p>
    </fieldset>
    <hr/>
    <?= $this->Form->button(__('Save'), ['class' => 'btn btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
