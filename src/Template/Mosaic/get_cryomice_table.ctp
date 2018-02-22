    <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <thead>
                <tr>
                    <th>Mouse ID</th>
                    <th>Age (days)</th>
                    <th>Sex</th>
                    <th>Group Strain</th>
                    <th>Genotype</th>
                    <th>Disposition Date</th>
                    <th>Disposition</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result_rows as $animal): ?>
                <tr>
                    <td><?= h($animal["colony"]) ?>-<?= h($animal["mouse_label"]) ?></td>
                    <td><?= h($animal["age_days"]) ?></td>
                    <td><?= h($animal["gender"]) ?></td>
                    <td><?= h($animal["group_strain"]) ?></td>
                    <td><?= h($animal["genotype"]) ?></td>
                    <td><?= h($animal["disposition_date"]) ?></td>
                    <td><?= h($animal["status"]) ?></td>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>