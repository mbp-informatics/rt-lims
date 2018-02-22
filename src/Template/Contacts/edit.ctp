<div class="jobContacts form large-9 medium-8 columns content">
<?php echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete Contact ',
                                    ['action' => 'delete', $contact->id],
                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-danger pull-right',
                                        'style' => 'color:#fff;',
                                        'confirm' => __('Are you sure you want to delete contact # {0}? This WILL REMOVE the contact from the database. This will also REMOVE all associations for this contact. Proceed?', $contact->id)
                                    )) . '</span>'; ?>
<div class="clearfix"></div>
    <div class='container-fluid'>
        <?= $this->Form->create($contact) ?>
        <fieldset>
            <legend><?= __('Edit Contact') ?></legend>
            <div class='row'>
                <div class='col-sm-4'><?php echo $this->Form->input('first_name', ['label' => 'Contact First Name']); ?></div>
                <div class='col-sm-4'><?php echo $this->Form->input('last_name', ['label' => 'Contact Last Name']); ?></div>           
                <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                        'campus_company', 
                        $this->CustomForm->getCampusList(),
                        true,
                        ['empty'=>true, 'label' => 'Campus/Institution']
                    ); ?></div>
                </div>
                <div class='row'>        
                <div class='col-sm-6'><?php echo $this->Form->input('contact_type_id', [
                    'options' => $ContactTypes,
                    'empty' => true,
                    'label' => 'Contact Type'
                    ]);  ?>
                </div>              
                <div class='col-sm-6'><?php echo $this->Form->input('email'); ?></div>
            </div>
            <?php echo $this->Form->input('user_id', [
                'label' => 'Added by',
                'options' => $users,
                'empty' => false,
                'default' => $this->request->session()->read('Auth.User.id'),
                'type'=>'hidden'
                ]); ?>
            <hr/>
            <button class="btn btn-success" type="submit">Save Contact</button>
    </div>
    <?= $this->Form->end() ?>
            </fieldset>
</div>
