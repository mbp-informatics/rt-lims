<?= $this->CustomForm->iniConfirmExit('#resus-form', ['job_id', 'embryo_cryo_id']) ?>
<script src="/js/cryos.js"></script>
<?php
    /** Trigger JS event if $job_id is present
     *  This will prepopulate job fields on page load
     */
    if (isset($job_id)) { ?>
        <script>
            $( document ).ready(function() {
                $( "#job-id" ).trigger( "change" );
                $( "#embryo-cryo-id" ).trigger( "change" );
            });
        </script>
<?php } ?>

<script>
    /** Calculates the percentage of Blast Rate and
     *  populates the field with calculated value
     */
    $( document ).ready(function() {
        $('#blastocysts-no, #cultured-no').change(function(){
            var blasts =  $('#blastocysts-no').val() ;
            var cultured = parseFloat( $('#cultured-no').val() );
            if (blasts =='') {
                blasts = 0;
            } else {
                blasts = parseFloat(blasts)
            }
            if (cultured > 0 ) {
                var perc = parseFloat( (blasts/cultured)*100 );
                $('#blastocyst-rate').val(perc.toFixed(2));
                if (perc > 50) {
                    document.getElementById("blastocyst-rate").style.color = 'white'
                    document.getElementById("blastocyst-rate").style.backgroundColor = 'green'
                } else {
                    document.getElementById("blastocyst-rate").style.color = 'white'
                    document.getElementById("blastocyst-rate").style.backgroundColor = 'red'
                }
            }
        });
    });
</script>

<div class="embryoResus form large-9 medium-8 columns content">
    <?= $this->Form->create($embryoResus, ['id'=>'resus-form']) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Add Embryo Resuscitation') ?></legend>
            <div class="important" style="margin-bottom:25px;">
                <?php
                    echo $this->CustomForm->displayField(
                        'job_id', 
                        $jobs,
                        false,
                        ['empty'=>true, 'label' => 'Job Request', 'default' => $job_id]
                    );?>
                    <?php echo $this->Form->input('embryo_cryo_id', ['empty' => true, 'type'=>'text']); ?>
                
                <?php
                    if (!isset($job_id))  { ?>
                        <p><span class="glyphicon glyphicon-warning-sign"></span> Disabled fields in this form will be automatically populated with data when you select <em>Job ID</em> from the dropdown above.
                        </p>
                    <?php } else { ?>
                        <p><span class="glyphicon glyphicon-warning-sign"></span> Disabled form fields below have been prepopulated with data from Job ID <?= $job_id ?>.
                        </p>
                <?php } ?>
                <p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Populating fields with job info...</small></p>
            </div>
            <div class="row">
                <?php
                    $tmpDate = '';
                    if (isset($embryoResus->cryo_date)) {
                      $tmpDate = $embryoResus->cryo_date->format('Y-m-d');
                } ?> 
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('cryo_date', ['empty' => true, 'value' => $tmpDate, 'label'=>'Cryo Date (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pi', array('label' => 'PI' ,'readonly' => 'readonly')); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('mmrrc_no', ['label' => 'MMRRC ID', 'readonly' => 'readonly']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('female_strain_name', ['label' => 'Female Background', 'readonly' => 'readonly']); ?></div>
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->Form->input('background', ['label' => 'Male Background', 'readonly' => 'readonly']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('sc_tt_batch_no', ['label' => 'KOMP Clone ID', 'readonly' => 'readonly']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'membership', 
                        $this->CustomForm->getEmbryoResusMembershipList(),
                        true,
                        ['empty'=>true]
                ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('strain'); ?></div>
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'purpose', 
                        $this->CustomForm->getEmbryoResusPurposeList(),
                        true,
                        ['empty'=>true]
                ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('freezing_medium_lot'); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Recovery/Culture Info</div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->Form->input('straw_no', ['label' => 'Straw #']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('tank'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('rack'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('box'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('space'); ?></div>                
            </div>
            <div class="row">             
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('thawing_date', ['empty' => true, 'value' => $tmpDate, 'label'=>'Thawing Date (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('thawing_time', ['empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'thawed_by', 
                        $this->CustomForm->getNameList(),
                        true,
                        ['empty'=>true, 'label' => 'Thawed By']
                    ); ?></div>            
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->Form->input('embryo_stage'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('embryos_no', ['label' => '# Embryos']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('recovered_no', ['label' => '# Recovered']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('intact_no', ['label' => '# Intact']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('bad_lysed_no', ['label' => '# Bad and Lysed']); ?></div>
            </div>
            <div class="row">            
                <div class='col-xs-3'><?php echo $this->Form->input('cultured_no', ['label' => '# Cultured']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('morulae_no', ['label' => '# Morulae']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('blastocysts_no', ['label' => '# Blastocysts']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('blastocyst_rate', ['label' => 'Blastocyst Rate (%)']); ?></div>   
            </div>
            <div class="row">                       
                <div class='col-xs-12'><?php echo $this->Form->input('comments'); ?></div>
            </div>
        </fieldset>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); 
        echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', '#' => 'related-data', $job_id ], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
        ));
    ?>
    <?= $this->Form->end() ?>
</div>
