<br/>
<div class="jobContacts form large-9 medium-8 columns content">
    <div class='container-fluid'>
        <?= $this->Form->create($contact) ?>
        <fieldset>
            <legend><?= __('Add Contact') ?></legend>
            <div class='row'>
                <div class='col-sm-3'><?php echo $this->Form->input('first_name', ['label' => 'Contact First Name']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('last_name', ['label' => 'Contact Last Name']); ?></div>           
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'campus_company', 
                       	$this->CustomForm->getCampusList(),
                        true,
                        ['empty'=>true, 'label' => 'Campus/Institution']
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('contact_type_id', [
                    'options' => $ContactTypes,
                    'empty' => true,
                    'label' => 'Contact Type'
                    ]);  ?></div>              
            </div>
            <div class='row'>
                <div class='col-sm-3'><?php echo $this->Form->input('email'); ?></div>
            </div>
            <?php echo $this->Form->input('user_id', [
                'label' => 'Added by',
                'options' => $users,
                'empty' => false,
                'default' => $this->request->session()->read('Auth.User.id'),
                'type'=>'hidden'
                ]); ?>
        </fieldset>
    </div>
    <?= $this->Form->button(__('Add Contact'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Contacts', 'action' => 'index'], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
        ));
    ?>
    <?= $this->Form->end() ?>
</div>
