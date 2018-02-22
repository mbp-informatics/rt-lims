<div class="colonies view large-9 medium-8 columns content">
    <h3><?= __('Colony')." #".h($colony->id) ?></h3>
    <table class="table stripe order-column">
    <tr>
            <th><?= __('Colony Id') ?></th>
            <td><?= h($colony->colony_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Denotation') ?></th>
            <td><?= h($colony->denotation) ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($colony->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Injection ID') ?></th>
            <td><?= h($colony->injection_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Project ID') ?></th>
            <td><?= h($colony->injection_id) ?></td>
        </tr>
        <tr>
            <th><?= __('MGI Accession Id') ?></th>
            <td><a href='/mgi-genes-dump/view/<?= $colony->mgi_accession_id ?>'><?= h($colony->mgi_accession_id) ?></a></td>
        </tr>
    </table>
</div>
