<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h2><?= __('Requests') ?></h2>
    <hr/>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th>Mating ID</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
            <tr>
                <td><?= $request["request_guid"] ?></td>
                <td><?= h($request["requested_arrival_date"]) ?></td>
                <td class="actions">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>