<?php //debug($result_rows); ?>
<div class="users index large-9 medium-8 columns content">
    <h2><?= __('Colony') ?></h2>
    <hr/>
    <div class="table-responsive">
        <table class="data-table table stripe order-column">
            <thead>
                <tr>
                    <th>Colony number</th>
                    <th>Colony name</th>
                    <th>Colony strain</th>
                    <th>Colony background</th>
                    <th>Colony type</th>
                    <th>Animal</th>
                    <th>Code/Ear Mark</th>
                    <th>Mother's Code/Ear Mark</th>
                    <th>Label</th>
                    <th>Mutations</th>
                    <th>Genotypes</th>
                    <th>Gender</th>
                    <th>Coat color</th>
                    <th>Eye Color</th>
                    <th>dob</th>
                    <th>dod</th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result_rows as $animal): ?>
                <tr>
                    <td><?= h($animal["colony_number"]) ?></td>
                    <td><?= h($animal["colony_name"]) ?></td>
                    <td><?= h($animal["colony_strain"]) ?></td>
                    <td><?= h($animal["colony_background"]) ?></td>
                    <td><?= h($animal["colony_type"]) ?></td>
                    <td><?= h($animal["animal"]) ?></td>
                    <td><?= h($animal["mother_ear_mark"]) ?></td>
                    <td><?= h($animal["ear_mark"]) ?></td>
                    <td><?= h($animal["label"]) ?></td>
                    <td><?= h($animal["mutations"]) ?></td>
                    <td><?= h($animal["genotypes"]) ?></td>
                    <td><?= h($animal["gender"]) ?></td>
                    <td><?= h($animal["coat_color"]) ?></td>
                    <td><?= h($animal["eye_color"]) ?></td>
                    <td><?= h(date_format(date_create($animal["dob"]), 'Y-m-d')); ?></td>
                    <td><?= h(date_format(date_create($animal["dod"]), 'Y-m-d')); ?></td>
                    <td class="actions">
                    <button>action</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>