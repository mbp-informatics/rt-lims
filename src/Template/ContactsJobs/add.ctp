<html>
<head>
</head>
<body>
<script>
</script>
<div class="contactsJobs form large-9 medium-8 columns content">
    <?= $this->Form->create($contactsJob) ?>
    <div style="border-bottom:1px solid #aaa; margin-bottom:15px">
    <fieldset">
    <?php 
    if (count($contacts) > 0) { 
        if ($job_id) { ?>
            <legend><?= __('Associate a contact with Job #' . $job_id ) ?></legend>
            <?php
                echo $this->Form->hidden('job_id');
            } else {
                echo $this->Form->input('job_id');
            }
                echo $this->CustomForm->displayField(
                        'contact_id', 
                        $contacts,
                        false,
                        ['empty'=>true, 'label' => 'Select contact']
                    );
            }
        ?>
    </fieldset>
    </div>
    <?php
    if (count($contacts) > 0) {
    echo $this->Form->button(__('Assign'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            ));
    }

    if (count($contacts) < 1) { 
        echo "<p>No contacts can be associated with this job (all possible contacts already associated?). Use the button below to add a new contact.</p></div>";
    }?> 
        <?php
        echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add a new contact'), ['controller' => 'contacts', 'action' => 'add', ], array('escape' => false, 'class' => 'btn btn-default pull-right'));
        ?>
    <?= $this->Form->end() ?>
</div>
</body>
</html>
