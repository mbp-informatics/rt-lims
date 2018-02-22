<script>
    $( document ).ready(function() {
        $('#tx-l, #tx-r').change(function(){
            var l = parseFloat($('#tx-l').val() );
            var r = parseFloat($('#tx-r').val() );
            var Total = parseFloat( l+r );
            $('#total-tx').val(Total);
        });
        $('#male-pups, #female-pups').change(function(){
            var Male = parseFloat($('#male-pups').val() );
            var Female = parseFloat($('#female-pups').val() );
            var Total = parseFloat( Male+Female );
            $('#total-pups').val(Total);
        });
        $('#pups_born-no').change(function(){
            console.log($('#pups_born-no'));
            if ($('#pups_born-no')) {
                $('#total-pups').val(0);
                $('#male-pups').val(0);
                $('#female-pups').val(0);
                $('#male-mut').val(0);
                $('#female-mut').val(0);
            }
        });
    });
</script>

<div class="recipients form large-9 medium-8 columns content">
    <?= $this->Form->create($recipient) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Edit Recipient') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ear_mark'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('weight', ['label' => 'Weight (g)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('embryo_transfer_id', ['label' => 'ET', 'type'=>'text']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'embryo_stage', 
                        ['2-Cell' => '2-Cell', 'Zygote' => 'Zygote', '8-cell/Early Morula' => '8-cell/Early Morula', 'Mor/Early Blast 2.5' => 'Mor/Early Blast 2.5', 'Blast 3.5' => 'Blast 3.5'],
                        true,
                        ['empty'=>true, 'label' => 'Embryo Stage']
                    ) ?>
                </div>
            </div>
            <div class='row'>
                <?php $typeOptions = ['mL' => 'mL', '%' => '%']; ?>  
                <div class='col-xs-3'><?php echo $this->Form->input('anesthetic_vol', ['label' => 'Anesthetic Volume']); ?></div>
                <div class='col-sm-1'><?php echo $this->Form->input('anesthetic_vol_type', ['label' => '', 'options' => $typeOptions]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('analgesic_vol', ['default' => '0.1', 'label' => 'Analgesic Volume (mL)']); ?></div>
                <div class='col-xs-1'><?php echo $this->Form->input('cl'); ?></div>
                <div class='col-xs-1'><?php echo $this->Form->input('amp'); ?></div>
                <?php $etOptions = ['DLY' => 'DLY', 'KMJ' => 'KMJ', 'JZ' => 'JZ', 'LNB' => 'LNB', 'NLA' => 'NLA', 'PTD' => 'PTD', 'VLG' => 'VLG', 'KLW'=>'KLW']; ?>
                <div class='col-sm-3'><?php echo $this->Form->input('et_by', ['options' => $etOptions, 'label'=>'ET By', 'empty'=>true]); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('tx_l'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('tx_r'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('total_tx'); ?></div>
                <?php 
                    if ($recipient->pups_born == 1) {
                            $open = 'checked'; $closed = ''; $unknown = '';
                        } elseif ($recipient->pups_born == 0) {
                            $open = ''; $closed = 'checked'; $unknown = '';
                        } else {
                            $open = ''; $closed = ''; $unknown = 'checked';
                        }
                ?>
                <div class='col-xs-3'><label class="control-label" for="pups_born">Pups Born? </label>
                    <div class="switch-toggle well">
                        <input id="pups_born-yes" name="pups_born" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="pups_born-yes">Litter</label>
                        <input id="pups_born-no" name="pups_born" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="pups_born-no">No Litter</label>
                        <input id="pups_born-pend" name="pups_born" value="2" type="radio" <?= $unknown ?> >
                        <label class="pointer" for="pups_born-pend">Pending</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('total_pups'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('male_pups'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('female_pups'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('male_mut'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('female_mut'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('comments'); ?></div>
            </div>
            <?php 
                echo $this->Form->input('user_id', [
                    'label' => 'Added by',
                    'options' => $users,
                    'empty' => false,
                    'default' => $this->request->session()->read('Auth.User.id'),
                    'type'=>'hidden'
                    ]); ?>
        </fieldset>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
