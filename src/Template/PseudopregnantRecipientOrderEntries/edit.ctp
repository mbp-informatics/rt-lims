<?php
    if (isset($recipients)) {
        $this->Html->script('recipient-orders.js');
    }
?>
<div class="pseudopregnantRecipientOrderEntries form large-9 medium-8 columns content">
    <?= $this->Form->create($pseudopregnantRecipientOrderEntry) ?>
    <fieldset>
        <?php $currentOrderId = $pseudopregnantRecipientOrderEntry['pseudopregnant_recipient_order_id']; ?>
        <legend><?= __('Editing entry of order #') ?><?= $currentOrderId ?></legend>
        <?php
            echo $this->Form->hidden('pseudopregnant_recipient_order_id', ['options' => $pseudopregnantRecipientOrders, 'empty' => true, 'default' => $currentOrderId]);
        ?>
        <div class="form-group text">
          <label class="control-label" for="recharge">Recharge</label>
          <select name="recharge" id="recharge" class="form-control" placeholder="Select from dropdown or type in new..." required="required"/>
            <option value="">Select recharge from dropdown or type in new...</option>
            <?php
            $rechargeInput = array(
                "VMB4" => "VMB4 - MTGL",
                "CP92" => "CP92 - MTGL",
                "KL64" => "KL64 - MTGL",
                "KL77" => "KL77 - MTGL",
                "MR71" => "MR71 - MCRL",
                "MR81" => "MR81 - MCRL",
                "CRL2" => "CRL2 - MCRL",
                "CRYC" => "CRYC - KOMP repository",
                "KP84" => "KP84 - MTGL",
                "VV75" => "VV75 - MVP",
                "JW05" => "JW05"
                );
                displayFormOptions($rechargeInput, $pseudopregnantRecipientOrderEntry['recharge']); //custom function defined in this file below
            ?>
        </select>
        </div>
        <div class="form-group text"><label class="control-label" for="location">Location</label>
          <select name="location" id="location" class="form-control" placeholder="Select from dropdown or type in new..." required="required"/>
            <option value="">Select recharge from dropdown or type in new...</option>
            <?php
            $locInput = array(
                "M3" => "M3",
                "MBP" => "MBP"
                );
                displayFormOptions($locInput, $pseudopregnantRecipientOrderEntry['location']); //custom function defined in this file below
            ?>
          </select>
        </div>        
        <?php echo $this->Form->input('date_plugged'); ?>
        <div class="form-group text">
          <label class="control-label" for="pseudo-state">Pseudo&nbsp;state</label>
          <select name="pseudo_state" id="pseudo-state" class="form-control" placeholder="Select from dropdown or type in new..." required="required"/>
            <option value="">Select Pseudo State from dropdown or type in new...</option>
            <?php
            $pseudoStateInput = array(
            "e0.5" => "e0.5",
            "e2.5" => "e2.5"
            );
            displayFormOptions($pseudoStateInput, $pseudopregnantRecipientOrderEntry['pseudo_state']); //custom function defined in this file below
             ?>
            </select>
        </div>
        <?php echo $this->Form->input('date_needed', [
            'label' => [
            'class' => 'date-needed'
            ]]); ?>
        <?php
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save entry'),
        array(
        'class' => 'btn btn-success pad-button',
        'div' => false
        ));

        echo $this->Html->link('' . __('Cancel'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'view', $currentOrderId], array(
        'escape' => false,
        'class' => 'btn btn-default pad-button'
    ));?>

    <?= $this->Form->end() ?>
</div>

<?php
function displayFormOptions(array $input, $currentVal) {
    //the entry has been added manually by user and is not found in the dictionary
    if (!array_key_exists($currentVal, $input)) { ?>
        <option value="<?= $currentVal; ?>" selected>
                <?= $currentVal; ?> 
                </option>
    <?php }
    //process dictionary entries
    foreach ($input as $value=>$text): ?>
                <option value="<?= $value; ?>"
                <?php echo $currentVal == $value ? 'selected':''; ?>>
                <?= $text; ?> 
                </option>
            <?php endforeach;
}