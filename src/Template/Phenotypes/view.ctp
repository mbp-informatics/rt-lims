<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="phenotypes view large-9 medium-8 columns content">
    <h3><?= h($phenotype->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($phenotype->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($phenotype->id) ?></td>
        </tr>
    </table>
    <div class="related horizontal-table">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($phenotype->projects)): ?>
        <table class="data-table table stripe order-column">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Project Type Id') ?></th>
                <th scope="col"><?= __('Project Status Id') ?></th>
                <th scope="col"><?= __('Mutation Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Phenotype Id') ?></th>
                <th scope="col"><?= __('Pts Id No') ?></th>
                <th scope="col"><?= __('Komp Id No') ?></th>
                <th scope="col"><?= __('Mmrrc Id No') ?></th>
            </tr>
            <?php foreach ($phenotype->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->project_type_id) ?></td>
                <td><?= h($projects->project_status_id) ?></td>
                <td><?= h($projects->mutation_id) ?></td>
                <td><?= h($projects->user_id) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
                <td><?= h($projects->phenotype_id) ?></td>
                <td><?= h($projects->pts_id_no) ?></td>
                <td><?= h($projects->komp_id_no) ?></td>
                <td><?= h($projects->mmrrc_id_no) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
