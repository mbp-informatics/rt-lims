<div class="contactsJobs form large-9 medium-8 columns content">
    <?= $this->Form->create($contactsJob) ?>
    <fieldset>
        <legend><?= __('Edit Contacts Job') ?></legend>
        <?php
            echo $this->Form->input('job_id', ['options' => $jobs, 'empty' => true]);
            echo $this->Form->input('contact_id', ['options' => $contacts, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
