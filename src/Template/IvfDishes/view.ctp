<?php
echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __('Edit IVF Dish'), ['controller' => 'IvfDishes', 'action' => 'edit', $ivfDish->id], array('escape' => false, 'class' => 'btn btn-warning pull-right'));
?>
<div class="ivfDishes view large-9 medium-8 columns content">
    <h3><?= __('IvfDish')." #".h($ivfDish->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('IVF ID') ?></th>
            <td><?= $ivfDish->has('ivf') ? $this->Html->link($ivfDish->ivf->id, ['controller' => 'Ivfs', 'action' => 'view', $ivfDish->ivf->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Dish #') ?></th>
            <td><?= $this->Number->format($ivfDish->dish_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Clutches #') ?></th>
            <td><?= $this->Number->format($ivfDish->clutches_no) ?></td>
        </tr>
        <tr>
            <th><?= __('COCs in dish time') ?></th>
            <td><?= h($ivfDish->cocs_in_dish_time) ?></tr>
        </tr>
        <tr>
            <th><?= __('Insemination Time') ?></th>
            <td><?= h($ivfDish->insemination_time) ?></tr>
        </tr>
        <tr>
            <th><?= __('Sperm (µl)') ?></th>
            <td><?= $this->Number->format($ivfDish->sperm_ul) ?></td>
        </tr>
        <tr>
            <th><?= __('1 Cell #') ?></th>
            <td><?= $this->Number->format($ivfDish->one_cell_no) ?></td>
        </tr>
        <tr>
            <th><?= __('2 Cell #') ?></th>
            <td><?= $this->Number->format($ivfDish->two_cell_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Fert rate (%)') ?></th>
            <td><?= $this->Number->format($ivfDish->fert_rate) ?></td>
        </tr>

        <tr>
            <th><?= __('Dish Note') ?></th>
            <td><?= h($ivfDish->note) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($ivfDish->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($ivfDish->modified) ?></tr>
        </tr>
    </table>
</div>
<?php
        echo $this->Html->link('' . __('Go back'), ['controller' => 'Ivfs', 'action' => 'view', '#' => 'ivf-dishes', $ivfDish->ivf_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
            ));
?>
