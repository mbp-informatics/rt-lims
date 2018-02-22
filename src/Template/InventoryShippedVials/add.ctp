<!-- Check if the MO-, KO-, or MBP- prefix is present in the order number field. -->
<script>
    function validateName(x){
        // Validation rule
        var mo = /MO-[0-9]+/;
        var ko = /KO-[0-9]+/;
        var mbp = /MBP-[0-9]+/;
        // Check input
        if (mo.test(x.value) || ko.test(x.value) || mbp.test(x.value)){
            document.getElementById('hidden_msg').innerHTML="";
            return true;
        } else {
            x.value = '';
            lightUp($('#order-no'));
            document.getElementById('hidden_msg').innerHTML="Order # must have a KO-, MO-, or MBP- prefix";
            return false; 
        }
    }
</script>

<div class="inventoryShippedVials form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryShippedVial) ?>
    <fieldset>
        <legend><?= __('Ship/Thaw Vial') ?></legend>
        <p style="text-align:center; display:none" id="ajax-loader"><img src="/img/ajax-loader.gif"> <small>Please wait...</small></p>
        <div class='row'>
            <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('ship_thaw_date', ['empty'=>false, 'label'=>'Ship/Thaw Date', 'required' => true]); ?></div>
            <div class='col-sm-4'><div class="form-group text"><label class="control-label" for="order-no">Order Number</label><input type="text" name="order_no" maxlength="255" id="order-no" class="form-control" onblur="validateName(this)"></div></div> 
            <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                    'ship_thaw_reason', 
                    $this->CustomForm->getShipReasonList(),
                    true,
                    ['empty'=>true, 'label' => 'Ship/Thaw reason', 'required' => true]
                ); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-12'>
                    <?php echo $this->Form->input('comments', ['label' => 'Comments', 'required' => false, 'type' => 'textarea' ]); ?>
                </div>
            </div>
            <?php
                echo $this->Form->hidden('user_id', [
                'value' => $this->request->session()->read('Auth.User.id')
                ]);
            ?>
    </fieldset>
    <div id="hidden_msg"></div>
    <?= $this->Form->button(__('Ship away!'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>



