<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Colony'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="colonies index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Colonies') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>Colony Id</th>
                <th>Name</th>
                <th>Gene</th>
                <th>Project</th>
                <th>Injection</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($colonies as $colony): ?>
            <tr>
                <td><?= $colony->id ?></td>
                <td><?= $colony->name ?></td>
                <td>
                <?php
                if (isset($colony->mgi_genes_dump->marker_symbol)) {
                    echo $colony->mgi_genes_dump->marker_symbol.' (';
                    echo "<a href='/mgi-genes-dump/view/{$colony->mgi_accession_id}'>";
                    echo $colony->mgi_accession_id.')';
                    echo '</a>';
                } else {
                    echo '-';
                }
                ?>
                </td>
                <td>
                <?php if (isset($colony->project_id)) { ?>
                    <a href="/projects/view/<?= $colony->project_id ?>">proj_id:<?= $colony->project_id ?></a></td>
                <?php } ?>
                <td><a href="/injections/view/<?= $colony->injection_id ?>">inj_id:<?= $colony->injection_id ?></a></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $colony->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $colony->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $colony->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $colony->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
