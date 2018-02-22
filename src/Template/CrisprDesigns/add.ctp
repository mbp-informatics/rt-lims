<div class="crisprDesigns form large-9 medium-8 columns content">
    <?= $this->Form->create($crisprDesign) ?>
    <fieldset>
        <legend><?= __('New CRISPR Design') ?></legend>
        <?php
            echo $this->CustomForm->displayField('project_id', $projects);
            echo $this->Form->input('vector_name');
            echo $this->Form->input('nuclease');
            echo $this->Form->input('comments');
        ?>
    </fieldset>
 <?= $this->Form->button(__('Save and continue'),
        array(
        'class' => 'btn btn-success pad-button',
        'div' => false
        ));
        echo $this->Html->link('' . __('Cancel'), ['controller' => 'CrisprDesigns', 'action' => 'index'], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    )); ?>
    <?= $this->Form->end() ?>
    </div>
</div>
