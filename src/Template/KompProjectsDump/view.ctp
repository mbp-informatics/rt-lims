<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="kompProjectsDump view large-9 medium-8 columns content">
    <h3><?= h($kompProjectsDump->id) ?></h3>
    <table class="vertical-table table">
        <tr>
            <th scope="row"><?= __('Colony Name') ?></th>
            <td><?= h($kompProjectsDump->colony_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gene') ?></th>
            <td><?= h($kompProjectsDump->gene) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Clone Name') ?></th>
            <td><?= h($kompProjectsDump->clone_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Clone Nickname') ?></th>
            <td><?= h($kompProjectsDump->clone_nickname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mouse Clone') ?></th>
            <td><?= $kompProjectsDump->has('mouse_clone') ? $this->Html->link($kompProjectsDump->mouse_clone->name, ['controller' => 'MouseClones', 'action' => 'view', $kompProjectsDump->mouse_clone->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mutation') ?></th>
            <td><?= h($kompProjectsDump->mutation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mutation Id No') ?></th>
            <td><?= h($kompProjectsDump->mutation_id_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cell Line') ?></th>
            <td><?= h($kompProjectsDump->cell_line) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Epd') ?></th>
            <td><?= h($kompProjectsDump->epd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($kompProjectsDump->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Komp Gene Id') ?></th>
            <td><a href="/komp-genes-dump/view/<?= $kompProjectsDump->komp_gene_id ?>"><?= $kompProjectsDump->komp_gene_id ?></a></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mgi Number') ?></th>
            <td><?= $this->Number->format($kompProjectsDump->mgi_number) ?></td>
        </tr>
    </table>
</div>
