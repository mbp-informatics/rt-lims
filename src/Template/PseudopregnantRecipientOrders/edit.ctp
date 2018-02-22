<div class="pseudopregnantRecipientOrders form large-9 medium-8 columns content">
    <?= $this->Form->create($pseudopregnantRecipientOrder) ?>
    <fieldset>
        <legend><?= __('Editing Pseudopregnant Recipient | in-house B6NCRL Mice Order #'. $pseudopregnantRecipientOrder['id']) ?></legend>
        <?php
            echo $this->Form->input('protocol', ['label' => 'Protocol #']);
            
            echo $this->Form->input('protocol_expiration', [
                'label' => 'Protocol expiry date'
                ]);
        
            echo $this->Form->input('protocol_Investigator');
            echo $this->Form->input('user_id', ['label' => 'Requested by', 'options' => $users, 'empty' => true]);
            echo $this->Form->hidden('total_plugs', [
                'label' => 'Total plugs this week'
                ]);
            echo '<hr/>';
            echo $this->Form->input('time_period_start', ['label' => 'For the week of']);
            
            #Calculate +7 days
            $date = new DateTime();
            $date->add(new DateInterval('P7D'));
            $nextWeek = $date->format('Y-m-d');

            echo $this->Form->input('time_period_end', ['label' => 'through', 'default' => $nextWeek]);
            echo '<hr/>';
            echo $this->Form->input('note');
            echo $this->Form->hidden('status', ['empty' => true, 'default' => 'open']);
        ?>

    <?= $this->Form->button(__('Save'),
        array(
        'class' => 'btn btn-success pad-button',
        'div' => false
        ));
        echo $this->Html->link('' . __('Cancel'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'view', $pseudopregnantRecipientOrder['id']], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    )); ?>
    <?= $this->Form->end() ?>
</div>




