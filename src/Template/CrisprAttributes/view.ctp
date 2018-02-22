<hr/>
<?php
echo $this->Form->postLink(
                __('<span class="glyphicon glyphicon glyphicon-trash"></span> ' . 'Delete Crispr Attribute'),
                ['action' => 'delete',  $crisprAttribute->id],
                array(
                    'escape' => false,
                    'class' => 'btn btn-danger pad-button',
                    'confirm' => __('Are you sure you want to delete # {0}?', $crisprAttribute->id)
                ));
echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-pencil"></span> ' . __('Edit Crispr Attribute'), ['action' => 'edit', $crisprAttribute->id], array('escape' => false, 'class' => 'btn btn-success pad-button'));
echo $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' . __('List Crispr Attributes'), ['controller' => 'CrisprAttributes', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New Crispr Attribute'), ['controller' => 'CrisprAttributes', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
echo $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' . __('List Crispr Designs'), ['controller' => 'CrisprDesigns', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New Crispr Design'), ['controller' => 'CrisprDesigns', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
?>
<hr/>
<div class="crisprAttributes view large-9 medium-8 columns content">
    <h3>Crispr Attribute</h3>
    <table class="data-table table stripe order-column">
        <tr>
            <th><?= __('Crispr Design') ?></th>
            <td><?= $crisprAttribute->has('crispr_design') ? $this->Html->link($crisprAttribute->crispr_design->name, ['controller' => 'CrisprDesigns', 'action' => 'view', $crisprAttribute->crispr_design->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Sequence') ?></th>
            <td><?= h($crisprAttribute->sequence) ?></td>
        </tr>
        <tr>
            <th><?= __('Chromosome') ?></th>
            <td><?= h($crisprAttribute->chromosome) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($crisprAttribute->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Chr Start') ?></th>
            <td><?= $this->Number->format($crisprAttribute->chr_start) ?></td>
        </tr>
        <tr>
            <th><?= __('Chr End') ?></th>
            <td><?= $this->Number->format($crisprAttribute->chr_end) ?></td>
        </tr>
    </table>
</div>
