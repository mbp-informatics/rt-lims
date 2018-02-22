<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Komp Vials Dump'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="kompVialsDump form large-9 medium-8 columns content">
    <?= $this->Form->create($kompVialsDump) ?>
    <fieldset>
        <legend><?= __('Add Komp Vials Dump') ?></legend>
        <?php
            echo $this->Form->input('gene');
            echo $this->Form->input('komp_gene_id');
            echo $this->Form->input('clone_name');
            echo $this->Form->input('clone_nickname');
            echo $this->Form->input('mouse_clone_id');
            echo $this->Form->input('mutation');
            echo $this->Form->input('mutation_id_no');
            echo $this->Form->input('cell_line');
            echo $this->Form->input('mgi_accession_id');
            echo $this->Form->input('epd');
            echo $this->Form->input('komp_vial_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
