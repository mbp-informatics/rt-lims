<div class="jobAstatuses view large-9 medium-8 columns content">
    <h3><?= __('JobAstatus')." #".h($jobAstatus->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($jobAstatus->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($jobAstatus->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($jobAstatus->modified) ?></tr>
        </tr>
    </table>
</div>
