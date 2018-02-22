<script>
    /** Calculates the percentage of Blast Rate and
     *  populates the field with calculated value
     */
    $( document ).ready(function() {
        $('#one-cell-no, #two-cell-no').change(function(){
            var oneCell = parseFloat( $('#one-cell-no').val() );
            var twoCell = parseFloat( $('#two-cell-no').val() );
            var perc = parseFloat( (twoCell/(oneCell + twoCell))*100 );
            $('#fert-rate').val(perc.toFixed(2));
            lightUp('#fert-rate', 'yellow');
        });
    });
</script>
<div style="margin-bottom:20px;">
<?php
 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete IVF Dish',
                                    ['action' => 'delete',$ivfDish->id],
                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-danger pull-right',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $ivfDish->id)
                                    )) . '</span>';
?>
</div>
<div class="clearfix"></div>
<div class="ivfDishes form large-9 medium-8 columns content">
    <?= $this->Form->create($ivfDish) ?>
    <fieldset>
        <legend><?= __('Edit IVF Dish #' . $ivfDish->id) ?></legend>
  		<div class="important" style="margin-bottom:25px;">
<!--             <?php
            $options = [
                'label'=> 'IVF ID',
                'empty' => 'Click to select Job ID from dropdown...'
            ];
            if (isset($ivf_id)) {
                $options['default'] = $ivf_id;
                $options['readonly'] = 'readonly';
                $options['required'] = 'required';
            }
            echo $this->Form->input('ivf_id', $options);
        ?> -->
        <?php echo $this->Form->input('ivf_id', ['label' => 'IVF ID', 'type'=>'text', 'required'=>'required']); ?>
        </div>
  <div class="row">
                <div class='col-sm-3'><?php echo $this->Form->input('dish_no', ['label' => 'Dish #']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('clutches_no', ['label' => 'Clutches #']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('cocs_in_dish_time', ['label' => 'COCs in dish time', 'empty' => true]); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('insemination_time', ['empty'=>true]); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-3'><?php echo $this->Form->input('sperm_ul', ['label' => 'Sperm (µl)']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('one_cell_no', ['label' => '1-Cell #']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('two_cell_no', ['label' => '2-Cell #']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('fert_rate', ['label' => 'Fert rate (%)']); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-12'>
                    <?php echo $this->Form->input('note', ['label' => 'Dish Note']); ?>
                </div>
            </div>
    </fieldset>
    <hr/>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
        echo $this->Html->link('' . __('Go back'), ['controller' => 'Ivfs', 'action' => 'view', '#' => 'ivf-dishes', $ivfDish->ivf_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
            ));
?>
    <?= $this->Form->end() ?>
</div>
