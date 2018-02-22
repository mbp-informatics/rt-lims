<div class="jobBstatuses view large-9 medium-8 columns content">
    <h3><?= __('JobBstatus')." #".h($jobBstatus->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($jobBstatus->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($jobBstatus->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($jobBstatus->modified) ?></tr>
        </tr>
    </table>
</div>
