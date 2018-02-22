<div class="qcGenotypes view large-9 medium-8 columns content">
    <h3><?= __('QcGenotype')." #".h($qcGenotype->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $qcGenotype->has('user') ? $this->Html->link($qcGenotype->user->name, ['controller' => 'Users', 'action' => 'view', $qcGenotype->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($qcGenotype->id) ?></td>
        </tr>
        <tr>
            <th><?= __('ES Cell ID') ?></th>
            <td><?= $this->Number->format($qcGenotype->es_cell_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started By') ?></th>
            <td><?= h($qcGenotype->started_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Finished By') ?></th>
            <td><?= h($qcGenotype->finished_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Pass') ?></th>
            <td><?= h($qcGenotype->pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Test5') ?></th>
            <td><?= h($qcGenotype->test5) ?></td>
        </tr>
        <tr>
            <th><?= __('Test3') ?></th>
            <td><?= h($qcGenotype->test3) ?></td>
        </tr>
        <tr>
            <th><?= __('Testcopy1') ?></th>
            <td><?= h($qcGenotype->testcopy1) ?></td>
        </tr>
        <tr>
            <th><?= __('Testcopy1value') ?></th>
            <td><?= h($qcGenotype->testcopy1value) ?></td>
        </tr>
        <tr>
            <th><?= __('TestLRPCR5') ?></th>
            <td><?= h($qcGenotype->testLRPCR5) ?></td>
        </tr>
        <tr>
            <th><?= __('Test Integrity5') ?></th>
            <td><?= h($qcGenotype->test_integrity5) ?></td>
        </tr>
        <tr>
            <th><?= __('Test Genome') ?></th>
            <td><?= h($qcGenotype->test_genome) ?></td>
        </tr>
        <tr>
            <th><?= __('Lost Y') ?></th>
            <td><?= h($qcGenotype->lost_y) ?></td>
        </tr>
        <tr>
            <th><?= __('Positive Control') ?></th>
            <td><?= h($qcGenotype->positive_control) ?></td>
        </tr>
        <tr>
            <th><?= __('Test Identity') ?></th>
            <td><?= h($qcGenotype->test_identity) ?></td>
        </tr>
        <tr>
            <th><?= __('TestLRPCR3') ?></th>
            <td><?= h($qcGenotype->testLRPCR3) ?></td>
        </tr>
        <tr>
            <th><?= __('Test Loxp') ?></th>
            <td><?= h($qcGenotype->test_loxp) ?></td>
        </tr>
        <tr>
            <th><?= __('Loxp Result') ?></th>
            <td><?= h($qcGenotype->loxp_result) ?></td>
        </tr>
        <tr>
            <th><?= __('3prime Loxp Result') ?></th>
            <td><?= h($qcGenotype->prime3_loxp_result) ?></td>
        </tr>
        <tr>
            <th><?= __('Kompvialid') ?></th>
            <td><?= h($qcGenotype->kompvialid) ?></td>
        </tr>
        <tr>
            <th><?= __('Quality Control Id') ?></th>
            <td><?= h($qcGenotype->quality_control_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Started') ?></th>
            <td><?= h($qcGenotype->started) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished') ?></th>
            <td><?= h($qcGenotype->finished) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date5') ?></th>
            <td><?= h($qcGenotype->date5) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date3') ?></th>
            <td><?= h($qcGenotype->date3) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Copy') ?></th>
            <td><?= h($qcGenotype->date_copy) ?></tr>
        </tr>
        <tr>
            <th><?= __('DateLRPCR5') ?></th>
            <td><?= h($qcGenotype->dateLRPCR5) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Integrity5') ?></th>
            <td><?= h($qcGenotype->date_integrity5) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Genome') ?></th>
            <td><?= h($qcGenotype->date_genome) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Y') ?></th>
            <td><?= h($qcGenotype->date_y) ?></tr>
        </tr>
        <tr>
            <th><?= __('Last Changed') ?></th>
            <td><?= h($qcGenotype->last_changed) ?></tr>
        </tr>
        <tr>
            <th><?= __('DateLRPCR3') ?></th>
            <td><?= h($qcGenotype->dateLRPCR3) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Loxp') ?></th>
            <td><?= h($qcGenotype->date_loxp) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date Loxp Result') ?></th>
            <td><?= h($qcGenotype->date_loxp_result) ?></tr>
        </tr>
        <tr>
            <th><?= __('Date 3prime Loxp Result') ?></th>
            <td><?= h($qcGenotype->date_3prime_loxp_result) ?></tr>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($qcGenotype->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($qcGenotype->modified) ?></tr>
        </tr>
    </table>
</div>
