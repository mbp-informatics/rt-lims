<div class="crisprDesigns view large-9 medium-8 columns content">
    <h3>CRISPR Design #<?= h($crisprDesign->id) ?>
    <?php
        echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit CRISPR details'), ['controller' => 'CrisprDesigns', 'action' => 'edit', $crisprDesign->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
    ?>
    </h3>
    <table class="data-table table stripe order-column">
        <tr>
            <th><?= __('MI Plan ID') ?></th>
            <td>
            <?php 
                $mi_plans = [];
                foreach ($crisprDesign->project->mgi_genes_dump as $gene) {
                    if (isset($gene->imits_dump_mi_plan)) {
                        echo "<a href='/imits-dump-mi-plans/view/{$gene->imits_dump_mi_plan->imits_mi_plan_id}'>".$gene->imits_dump_mi_plan->imits_mi_plan_id."</a>";
                    } else {
                        echo "<em><small>No MI Plan assigned with this gene.</small></em>";
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Project') ?></th>
            <td>
            <a href="/projects/view/<?= $crisprDesign->project_id ?>"><?= $crisprDesign->project_name ?></a>
            </td>
        </tr>
        <tr>
            <th><?= __('Gene') ?></th>
            <td>
            <?php
            if (isset($crisprDesign->project->mgi_genes_dump)) { 
                foreach ($crisprDesign->project->mgi_genes_dump as $gene) { ?>
                    <?= h($gene->marker_symbol) ?> <small>(<?= $this->Html->link($gene->mgi_accession_id, ['action' => 'view', 'controller' => 'mgi-genes-dump', $gene->mgi_accession_id]);  ?>)</small> <br/>
                <?php } ?>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Vector Name') ?></th>
            <td><?= h($crisprDesign->vector_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Nuclease') ?></th>
            <td><?= h($crisprDesign->nuclease) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($crisprDesign->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($crisprDesign->modified) ?></tr>
        </tr>
        <tr>
            <th><?= __('Comments') ?></th>
            <td><?= h($crisprDesign->comments) ?></td>
        </tr>
    </table>
</div>
<br/>
  <div class="related">
        <?php if (!empty($crisprDesign->crispr_attributes)): ?>
        <h4><?= __('Attributes') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Sequence') ?></th>
                <th><?= __('Chromosome') ?></th>
                <th><?= __('Chr start') ?></th>
                <th><?= __('Chr end') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
                
            </tr>
            <?php foreach ($crisprDesign->crispr_attributes as $attribute): ?>
            <tr>
                <td><?= h($attribute->id) ?></td>
                <td><?= h($attribute->sequence) ?></td>
                <td><?= h($attribute->chromosome) ?></td>
                <td><?= h($attribute->chr_start) ?></td>
                <td><?= h($attribute->chr_end) ?></td>  
                <td class="actions"> <?php 
                 echo '<span data-toggle="tooltip" title="Edit">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['controller' => 'crisprAttributes', 'action' => 'edit', $attribute->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>';
                 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ',
                                        ['controller' => 'crisprAttributes', 'action' => 'delete', $attribute->id],
                                 array(
                                     'escape' => false,
                                     'class' => 'label label-danger action-pad',
                                     'confirm' => __('Are you sure you want to delete attribute # {0}?', $attribute->id)
                                        )) . '</span>';
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
<hr />
    <?php endif; ?>
<?php
  echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Attribute'), ['controller' => 'crisprAttributes', 'action' => 'add', $crisprDesign->id], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
    echo $this->Html->link('' . __('Go back'), ['controller' => 'crisprDesigns', 'action' => 'index'], array(
            'escape' => false,
            'class' => 'btn btn-default pad-button'
    ));
?>
    </div>
</div>