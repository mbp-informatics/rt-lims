<div class="pseudopregnantRecipientOrderEntries form large-9 medium-8 columns content">
    <?= $this->Form->create($pseudopregnantRecipientOrderEntry) ?>
    <fieldset>
    <?php
        $dp = 'Date PMSG Received';
        $dn = 'Date brought out';
        if (isset($recipients)) {
            $dp = 'Date Plugged';
            $dn = 'Date Needed';
            $type = 'Recipient';
            echo $this->Html->script('recipient-orders.js');
            echo $this->Form->hidden('type', ['value' => $type]);
        } else {
            $type = 'in-house B6NCRL';
            echo $this->Form->hidden('type', ['value' => $type]);
        }
    ?>
        <legend><?= __("Adding {$type} entry to order #") ?><?= $currentOrderId[0] ?></legend>
        <?php
            echo $this->Form->hidden('pseudopregnant_recipient_order_id', ['options' => $pseudopregnantRecipientOrders, 'empty' => true, 'default' => $currentOrderId[0]]);
        ?>
        <div class="form-group text">
          <label class="control-label" for="recharge">Recharge</label>
          <select name="recharge" id="recharge" class="form-control" placeholder="Select from dropdown or type in new..." required="required" />
            <option value="">Select recharge from dropdown or type in new...</option>
                <option value="VMB4">VMB4 - MTGL</option>
                <option value="CP92">CP92 - MTGL</option>
                <option value="KL64">KL64 - MTGL</option>
                <option value="KL77">KL77 - MTGL</option>
                <option value="MR71">MR71 - MCRL</option>
                <option value="MR81">MR81 - MCRL</option>
                <option value="CRL2">CRL2 - MCRL</option>
                <option value="CRYC">CRYC - KOMP repository</option>
                <option value="KP84">KP84 - MTGL</option>
                <option value="VV75">VV75 - MVP</option>
                <option value="JW05">JW05</option>
            </select>
        </div>
        <div class="form-group text"><label class="control-label" for="location">Location</label>
          <select name="location" id="location" class="form-control" placeholder="Select from dropdown or type in new..." required="required" />
              <?php
              if ($type == 'in-house B6NCRL') {?>
                  <option value="MBP" selected>MBP</option>                  
              <?php } else { ?>
                  <option value="">Select location from dropdown</option>
                  <option value="M3">M3</option>
                  <option value="MBP">MBP</option>
              <?php } ?>
          </select>
        </div>        
        <?php echo $this->Form->input('date_plugged',[
            'label' => $dp
            ]); ?>

        <?php
         if (isset($recipients)) { ?>
            <div class="form-group text">
              <label class="control-label" for="pseudo-state">Pseudo&nbsp;state</label>
              <select name="pseudo_state" id="pseudo-state" class="form-control" placeholder="Select from dropdown or type in new..." required="required" />
                <option value="">Select Pseudo State from dropdown or type in new...</option>
                    <option value="e0.5">e0.5</option>
                    <option value="e2.5">e2.5</option>
                </select>
            </div>   
        <?php } ?>

        <?php echo $this->Form->input('date_needed', [
            'label' => [
                'class' => 'date-needed',
                'text' => $dn
            ]
            ]); ?>
        <?php echo $this->Form->input('quantity'); ?>
    </fieldset>
    <?= $this->Form->button(__('Add entry'),
        array(
        'class' => 'btn btn-success pad-button',
        'div' => false
        ));
        echo $this->Html->link('' . __('Go back'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'view', $currentOrderId[0]], array(
        'escape' => false,
        'class' => 'btn btn-default pad-button'
    ));?>

    <?= $this->Form->end() ?>
</div>