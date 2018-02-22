<div class="qcGrowths form large-9 medium-8 columns content">
    <?= $this->Form->create($qcGrowth) ?>
    <div class='container-fluid'>
        <fieldset>
            <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive']; ?>
            <legend><?= __('Add QC Viable Growth Morphology') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('inventory_vial_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true, 'default' => $qcID]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('image_name'); ?></div> 
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'confluency', 
                        ['Slight' => 'Slight', 'Moderate' => 'Moderate', 'Full'=> 'Full'],
                        true,
                        ['empty'=>true, 'label' => 'Confluency']
                    ); ?>
                </div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'size', 
                        ['Small' => 'Small', 'Medium' => 'Medium', 'Large'=> 'Large'],
                        true,
                        ['empty'=>true, 'label' => 'Size']
                    ); ?>
                </div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'shape', 
                        ['Round' => 'Round', 'Flat, Stretched' => 'Flat, Stretched'],
                        true,
                        ['empty'=>true, 'label' => 'Shape']
                    ); ?>
                </div>
            </div>
            <div class='row'>      
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'texture', 
                        ['Smooth' => 'Smooth', 'Rough' => 'Rough'],
                        true,
                        ['empty'=>true, 'label' => 'Texture']
                    ); ?>
                </div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'color', 
                        ['Bright' => 'Bright', 'Dark' => 'Dark'],
                        true,
                        ['empty'=>true, 'label' => 'Color']
                    ); ?>
                </div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'dead_cells', 
                        ['Few' => 'Few', 'Moderate' => 'Moderate', 'Most'=>'Most'],
                        true,
                        ['empty'=>true, 'label' => 'Dead Cells']
                    ); ?>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('comment'); ?></div>       
            </div>
        </fieldset>
        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
        ?>
    </div>
    <strong>Failing VGM will fail the entire QC project and will set the clone to unavailable </strong>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
