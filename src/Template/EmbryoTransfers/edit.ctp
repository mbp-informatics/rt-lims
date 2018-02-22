<?= $this->CustomForm->iniConfirmExit('#et-form') ?>
<script src="/js/cryos.js"></script>
<script>
    /** Calculates the percentage of birth rate and Litter Rate and
     *  populates the field with calculated value
     */
    $( document ).ready(function() {
        $('#total-pups-born, #total-embryos-tx').change(function(){
            var pups =  $('#total-pups-born').val() ;
            var embryos = parseFloat( $('#total-embryos-tx').val() );
            if (pups =='') {
                pups = 0;
            } else {
                pups = parseFloat(pups)
            }
            if (embryos > 0 ) {
                var perc = parseFloat( (pups/embryos)*100 );
                $('#et-birth-rate').val(perc.toFixed(2));
                if (perc > 50) {
                    document.getElementById("et-birth-rate").style.color = 'white'
                    document.getElementById("et-birth-rate").style.backgroundColor = 'green'
                } else {
                    document.getElementById("et-birth-rate").style.color = 'white'
                    document.getElementById("et-birth-rate").style.backgroundColor = 'red'
                }
            }
        });
    });

    $( document ).ready(function() {
        $('#no-litters, #no-recipients').change(function(){
            var litters =  $('#no-litters').val() ;
            var embryos = parseFloat( $('#no-recipients').val() );
            if (litters =='') {
                litters = 0;
            } else {
                litters = parseFloat(litters)
            }
            if (embryos > 0 ) {
                var perc = parseFloat( (litters/embryos)*100 );
                $('#litter-rate').val(perc.toFixed(2));
                if (perc > 50) {
                    document.getElementById("litter-rate").style.color = 'white'
                    document.getElementById("litter-rate").style.backgroundColor = 'green'                    
                } else {
                    document.getElementById("litter-rate").style.color = 'white'
                    document.getElementById("litter-rate").style.backgroundColor = 'red'
                }
            }
        });
    });

    $( document ).ready(function() {
        $('#no-total-male-chimeras, #no-total-female-chimeras').change(function(){
            var male = parseFloat($('#no-total-male-chimeras').val() );
            var female = parseFloat($('#no-total-female-chimeras').val() );
            var total = parseFloat( male+female );
            $('#no-total-chimeras').val(total);
        });
        $('#total-mut-males, #total-mut-females').change(function(){
            var mMale = parseFloat($('#total-mut-males').val() );
            var mFemale = parseFloat($('#total-mut-females').val() );
            var mTotal = parseFloat( mMale+mFemale );
            $('#et-total-mut-mice').val(mTotal);
        });
        $('#total-male-pups, #total-female-pups').change(function(){
            var tMale = parseFloat($('#total-male-pups').val() );
            var tFemale = parseFloat($('#total-female-pups').val() );
            var tTotal = parseFloat( tMale+tFemale );
            $('#total-pups-born').val(tTotal);
        });
    });

</script>
<?php if ($source == 'mtgl') { ?>
<div class="embryoTransfers form large-9 medium-8 columns content">
    <?= $this->Form->create($embryoTransfer, ['id'=>'et-form']) ?>


    <div class='container-fluid'>

       <fieldset>
              <legend><?= __('Edit Transfer') ?><?php
        echo $this->html->link('<span class="glyphicon glyphicon-share-alt"></span> ' . __('Switch to MICL View'), ['controller' => 'embryoTransfers', 'action' => 'edit', $embryoTransfer->id], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?></legend>
          <div class='alert alert-info' role='alert'>Embryo Source</div>
            <div class='row'>              
                <div class='col-xs-3'><?php echo $this->Form->input('injection_id', ['label' => 'Injection ID', 'type'=>'text']); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Transfer Information</div>
            <div class='row'>
                <?php
                    $tmpDate = '';
                    if (isset($embryoTransfer->et_date)) {
                      $tmpDate = $embryoTransfer->et_date->format('Y-m-d');
                } ?> 
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('et_date', ['empty'=>true, 'label'=>'ET Date (YYYY-MM-DD)', 'value' => $tmpDate]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('et_lab', ['label' => 'ET Lab', 'default' => 'MTGL']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('et_time', ['label' => 'ET Time']); ?></div>
                <?php
                    $tmpDate = '';
                    if (isset($embryoTransfer->expected_dob)) {
                      $tmpDate = $embryoTransfer->expected_dob->format('Y-m-d');
                } ?> 
                <div class='col-xs-2'><?php echo $this->CustomForm->displayDatepickerField('expected_dob', ['empty'=>true, 'label'=>'Expected DOB (YYYY-MM-DD)', 'value' => $tmpDate]); ?></div>
                <?php $locations = ['2nd Street' => '2nd Street', 'M3'=>'M3']; ?>
                <div class='col-xs-2'><?php echo $this->Form->input('et_location', ['options'=>$locations, 'empty'=>true, 'label'=>'ET Location']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('recipient_strain', ['default' => 'CD-1']); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'anesthetic', 
                    $this->CustomForm->getAnestheticList(),
                    true,
                    ['empty' => true]
                    ); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('anesthetic_lot_no',['label' => 'Anesthetic Lot #']); ?></div>
            </div>
            <div class='row'>
<!--                 <?php $etOptions = ['DLY' => 'DLY', 'KMJ' => 'KMJ', 'JZ' => 'JZ', 'LNB' => 'LNB', 'NLA' => 'NLA', 'PTD' => 'PTD', 'VLG' => 'VLG']; ?>
                <div class='col-xs-4'><?php echo $this->Form->input('et_by', ['label' => 'ET By', 'options' => $etOptions, 'empty' => true]); ?></div> -->
                <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'analgesic', 
                    $this->CustomForm->getAnalgesicList(),
                    true,
                    ['empty' => true]
                    ); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('analgesic_lot_no',['label' => 'Analgesic Lot #']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('comments'); ?></div>
            </div>
        </fieldset>
    </div>

<?php } else { ?>

<div class="embryoTransfers form large-9 medium-8 columns content">

    <?= $this->Form->create($embryoTransfer, ['id'=>'et-form']) ?>

        <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Edit Embryo Transfer') ?><?php
        echo $this->html->link('<span class="glyphicon glyphicon-share-alt"></span> ' . __('Switch to MTGL View'), ['controller' => 'embryoTransfers', 'action' => 'edit', $embryoTransfer->id, 'mtgl'], array('escape' => false, 'class' => 'btn btn-warning pull-right','style' => 'margin-left:10px;'));
        ?></legend>
            <div class='alert alert-info' role='alert'>Embryo Source</div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('job_id', ['type'=>'text']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('embryo_resus_id', ['label'=>'Embryo RS', 'type'=>'text']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('ivf_id', ['label'=>'IVF', 'type'=>'text']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('bl_no', ['label' => 'BL #']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pn_cr_no', ['label' => 'PN/CR #']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('injection_id', ['label' => 'Injection ID', 'type'=>'text']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'membership', 
                        $this->CustomForm->getMembershipList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('pts_ko_mo_no', ['label' => 'PTS/KO/MO #']); ?></div>
                <?php 
                if ($embryoTransfer->crispr) {
                        $open = 'checked'; $closed = '';
                    } else {
                        $open = ''; $closed = 'checked';
                    }
                ?>  
                <div class='col-xs-3'>
                    <label class="control-label" for="crispr">CRISPR?</label>
                    <div class="switch-toggle well">
                        <input id="crispr-yes" name="crispr" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="crispr-yes">Yes</label>
                        <input id="crispr-no" name="crispr" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="crispr-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>             
                <div class='col-xs-3'><?php echo $this->Form->input('et_purpose', ['label' => 'ET Purpose']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('embryo_cryo_id', ['label'=>'EC #', 'type'=>'text']); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Strain Information</div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('investigator'); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('lab_contact', ['type'=>'text']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('background'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('mmrrc_no', ['label' => 'MMRRC #']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('strain_name'); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Transfer Information</div>
            <div class='row'>
                <?php
                    $tmpDate = '';
                    if (isset($embryoTransfer->et_date)) {
                      $tmpDate = $embryoTransfer->et_date->format('Y-m-d');
                } ?> 
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('et_date', ['label'=>'ET Date (YYYY-MM-DD)', 'value' => $tmpDate]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('et_lab', ['label' => 'ET Lab']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('et_time', ['label' => 'ET Time']); ?></div>
                <?php
                    $tmpDate = '';
                    if (isset($embryoTransfer->expected_dob)) {
                      $tmpDate = $embryoTransfer->expected_dob->format('Y-m-d');
                } ?> 
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('expected_dob', ['label'=>'Expected DOB (YYYY-MM-DD)', 'value' => $tmpDate]); ?></div>
            </div>
            <div class='row'>
                <!-- <div class='col-xs-3'><?php echo $this->Form->input('et_by', ['label' => 'ET By']); ?></div> -->
                <?php $locations = ['2nd Street' => '2nd Street', 'M3'=>'M3']; ?>
                <div class='col-xs-3'><?php echo $this->Form->input('et_location', ['options'=>$locations, 'label'=>'ET Location', 'default'=>'2nd Street', 'empty'=>true]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('fresh_frozen', ['label' => 'Fresh/Frozen']); ?></div>
                <?php 
                if ($embryoTransfer->icsi_embryos) {
                        $open = 'checked'; $closed = '';
                    } else {
                        $open = ''; $closed = 'checked';
                    }
                ?>
                <div class='col-xs-3'>
                    <label class="control-label" for="icsi_embryos">ICSI Embryos?</label>
                    <div class="switch-toggle well">
                        <input id="icsi_embryos-yes" name="icsi_embryos" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="icsi_embryos-yes">Yes</label>
                        <input id="icsi_embryos-no" name="icsi_embryos" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="icsi_embryos-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'assisted_ivf_embryos', 
                    $this->CustomForm->getAssistedIvfEmbryoList(),
                    true,
                    ['label' => 'Assisted IVF Embryos', 'empty'=>true]
                    ); ?></div>
                <?php 
                if ($embryoTransfer->save_pups) {
                        $open = 'checked'; $closed = '';
                    } else {
                        $open = ''; $closed = 'checked';
                    }
                ?>
                <div class='col-xs-3'>
                    <label class="control-label" for="save_pups">Save Pups?</label>
                    <div class="switch-toggle well">
                        <input id="save_pups-yes" name="save_pups" type="radio" value="1"<?= $open ?> >
                        <label class="pointer" for="save_pups-yes">Yes</label>
                        <input id="save_pups-no" name="save_pups" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="save_pups-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'send_tails_to', 
                    ['MGAL' => 'MGAL', 'MGEL' => 'MGEL', 'MCRL' => 'MCRL', 'MBP-PI' => 'MBP-PI', 'N/A' => 'N/A'],
                    true,
                    ['label' => 'Send Tails To', 'empty'=>true]
                    ); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'anesthetic', 
                    $this->CustomForm->getAnestheticList(),
                    true,
                    ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('anesthetic_lot_no',['label' => 'Anesthetic Lot #']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'analgesic', 
                    $this->CustomForm->getAnalgesicList(),
                    true,
                    ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('analgesic_lot_no',['label' => 'Analgesic Lot #']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('comments'); ?></div>
            </div>

            <div class='alert alert-info' role='alert'>Pups</div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                        'maternity_updated_by', 
                        $this->CustomForm->getNameList(),
                        true,
                        ['empty' => true]
                    ); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                        'pup_genotype_updated_by', 
                        $this->CustomForm->getNameList(),
                        true,
                        ['empty' => true]
                    ); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Recharge Information</div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'primary_recharge',  
                    $this->CustomForm->getPrimaryRechargeList(),
                    true,
                    ['empty' => true]
                    ); ?></div>
                <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                    'secondary_recharge',  
                    $this->CustomForm->getSecondaryRechargeList(),
                    true,
                    ['empty' => true]
                    ); ?></div>
            </div>
        </fieldset>
    </div>
<?php }; ?>

    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
    <?php
        echo $this->Form->hidden('user_id', [
            'options' => $users,
            'default' => $this->request->session()->read('Auth.User.id')
            ]);

    ?>
</div>
