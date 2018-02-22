<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="genesStatuses form large-9 medium-8 columns content" style="padding:20px; background-color:white">
    <?= $this->Form->create($genesStatus) ?>
    <fieldset>
        <legend>
            <div class="pull-right"><?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Available Statuses'), ['action' => 'index', 'controller' => 'gene-statuses'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?></div>
            <div style="margin-bottom:20px;"><?= __('Add Gene Status') ?></div>
        </legend>
        <div class="clearfix"></div>
        <?php
        if (isset($mgiAccessionId)) {
            echo $this->Form->input('mgi_accession_id', ['type'=>'text', 'value'=>$mgiAccessionId, 'readonly' => true]);
        } else {
            echo $this->customForm->displayMgiGenesDropdown();
        }           
            echo $this->Form->input('gene_status_id', ['options' => $geneStatuses]);
            echo $this->Form->input('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
