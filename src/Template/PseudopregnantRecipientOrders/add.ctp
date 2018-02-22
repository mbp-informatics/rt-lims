<?php
$header = isset($in_house) ? 'New In-house B6NCRL Mice Order' : 'New Pseudopregnant Recipient Order';
$formUrlParams = isset($in_house) ? ['url' => ['in_house' => '1']] : [];
?>
<div class="pseudopregnantRecipientOrders form large-9 medium-8 columns content">
    <?= $this->Form->create($pseudopregnantRecipientOrder, $formUrlParams) ?>

    <fieldset>
        <legend><?= $header ?></legend>
        <?php
            echo $this->Form->input('protocol', ['label' => 'Protocol #']);
            
            echo $this->Form->input('protocol_expiration', [
                'label' => 'Protocol expiry date'
                ]);
        
            echo $this->Form->input('protocol_Investigator', [ 'default' => 'Kent Lloyd']);
            echo $this->Form->input('user_id', [
                'label' => 'Requested by',
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
            echo $this->Form->hidden('total_plugs', [
                'label' => 'Total plugs this week',
                'default' => 0
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

    <?= $this->Form->button(__('Save and continue'),
        array(
        'class' => 'btn btn-success pad-button',
        'div' => false
        ));
        echo $this->Html->link('' . __('Cancel'), ['controller' => 'PseudopregnantRecipientOrders', 'action' => 'index'], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    )); ?>
    <?= $this->Form->end() ?>
</div>

