<?php //debug($result_rows); ?>
<div class="users index large-9 medium-8 columns content">
    <h2><?= __('Litters') ?></h2>
    <hr/>
    <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <thead>
                <tr>
                    <th>Progeny colony</th>
                    <th>Female</th>
                    <th>Number</th>
                    <th>Litter</th>
                    <th>DOB</th>
                    <th>Progeny count female</th>
                    <th>Progeny count male</th>
                    <th>Progeny count total</th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result_rows as $litters): ?>
                <tr>
                    <td><?= h($litters["progeny_colony"]) ?></td>
                    <td><?= h($litters["female"]) ?></td>
                    <td><?= h($litters["number"]) ?></td>
                    <td><?= h($litters["litter"]) ?></td>
                    <td><?= h(date_format(date_create($litters["dob"]), 'Y-m-d')); ?></td>
                    <td><?= h($litters["progeny_count_female"]) ?></td>
                    <td><?= h($litters["progeny_count_male"]) ?></td>
                    <td><?= h($litters["progeny_count_total"]) ?></td>
                    <td class="actions">
                    <button>action</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>