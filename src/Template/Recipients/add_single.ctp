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
    });
</script>

<div class="recipients form large-9 medium-8 columns content">
    <?= $this->Form->create($recipient) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Add Recipient') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ear_mark'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('weight', ['label' => 'Weight (g)']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('dob', ['empty'=>true, 'label'=>'DOB (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'embryo_stage', 
                        ['e0.5' => 'e0.5',
                        'e2.5' => 'e2.5',
                        ],
                        true,
                        ['empty'=>true, 'label' => 'Embryo Stage']
                    ) ?>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('anesthetic_vol', ['label' => 'Anesthetic Volume (mL)']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('analgesic_vol', ['default' => '0.1', 'label' => 'Analgesic Volume (mL)']); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('cl'); ?></div>
                <div class='col-xs-2'><?php echo $this->Form->input('amp'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('tx_l'); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('tx_r'); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('total_tx'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-4'><?php echo $this->Form->input('male_pups'); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('female_pups'); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('total_pups'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('male_mut'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('female_mut'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('male_wt'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('female_wt'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-6'><?php echo $this->Form->input('pups_born'); ?></div>
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
            <?php 
                echo 
                    $this->Form->input('embryo_transfer_id', [
                    'options' => $embryoTransfers,
                    'empty' => false,
                    'default' => $embryo_transfer_id[0],
                    'label' => 'Embryo Transfer ID',
                    'type'=>'hidden'
                    ]);?>
        </fieldset>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
