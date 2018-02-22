<div class="mutations view large-9 medium-8 columns content">
    <h3><?= __('Mutation')." #".h($mutation->type) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($mutation->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($mutation->id) ?></td>
        </tr>
    </table>
    <div class="related horizontal-table">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($mutation->projects)): ?>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Project Type Id') ?></th>
                <th><?= __('Project Status Id') ?></th>
                <th><?= __('Mutation Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
            </tr>
            <?php foreach ($mutation->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->project_type_id) ?></td>
                <td><?= h($projects->project_status_id) ?></td>
                <td><?= h($projects->mutation_id) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
             </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
