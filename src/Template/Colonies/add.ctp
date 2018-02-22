<div class="colonies form large-9 medium-8 columns content">
    <?= $this->Form->create($colony) ?>
    <fieldset>
        <legend><?= __('Add Colony') ?></legend>
        <?php
        echo $this->Form->input('colony_id', ['type' => 'text', 'label' => 'Colony Id']);
        echo $this->Form->input('denotation');
        echo $this->Form->input('name');
        echo $this->Form->input('injection_id', ['type' => 'text', 'label' => 'Injection Id']);
        echo $this->Form->input('project_id', ['type' => 'text', 'label' => 'Project Id']);
        echo $this->Form->input('mgi_accession_id', ['type' => 'text', 'label' => 'MGI Accession Id']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
