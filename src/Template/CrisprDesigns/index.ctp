<hr/>
<?php
echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('New CRISPR Design'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
if ($this->request->session()->read('Auth.User.role.name') == 'admin') {
    echo $this->Html->link('' . __('<span class="glyphicon glyphicon-floppy-open"></span> Bulk CRISPR upload (from file)'), ['controller' => 'CrisprDesigns', 'action' => 'bulkUpload'], array(
    'escape' => false,
    'class' => 'btn btn-danger pad-button'
    ));
} 
?>
<hr/>
<div class="crisprDesigns index large-9 medium-8 columns content horizontal-table">
    <h2><?= __('Crispr Designs') ?></h2>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Vector name</th>
                <th>Nuclease</th>
                <th>Comment</th>
                <th>Created</th>
                <th>Modified</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($crisprDesigns as $crisprDesign): ?>
             <tr>
                <td><?= $this->Number->format($crisprDesign->id) ?></td>
                <td>
                <?php
                if (isset($crisprDesign->project_name)) { ?>
                <a href="/projects/view/<?= $crisprDesign->project_id ?>"><?= $crisprDesign->project_name ?></a>
                <?php } ?>
                </td>
                <td><?= h($crisprDesign->vector_name) ?></td>
                <td><?= h($crisprDesign->nuclease) ?></td>
                <td><?= h($crisprDesign->comments) ?></td>
                <td><?= h($crisprDesign->created) ?></td>
                <td><?= h($crisprDesign->modified) ?></td>
                <td class="actions">
                <?php
                echo '<span data-toggle="tooltip" title="View/Edit">' . $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $crisprDesign->id], array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>';
                echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ',
                                ['action' => 'delete', $crisprDesign->id],
                                array(
                                    'escape' => false,
                                    'class' => 'label label-danger action-pad',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $crisprDesign->id)
                                )) . '</span>';
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
