<p>This is a new order for In-house B6NCRL Mice from <a href="http://rt-lims.mousebiology.org/">RT-LIMS</a>. If you have any questions about this order please contact the requester directly.
<br/><br/>
<strong><small>ORDER DETAILS</small></strong>
<hr/>
<table>
<tr>
<tr>
    <th align="left" width="200"><?= __('Record#') ?></th>
    <td><?= h($order->id) ?></td>
</tr>
    <th align="left"><?= __('Protocol Investigator') ?></th>
    <td><?= h($order->protocol_Investigator) ?></td>
</tr>
<tr>
    <th align="left"><?= __('Requested by') ?></th>
    <td><a href="mailto:<?= $requestor->email ?>"><?= $requestor->name ?></a></td>
</tr>
<tr>
    <th align="left"><?= __('Submit Date') ?></th>
    <td><?= h($order->created) ?></tr>
</tr>
<tr>
    <th align="left"><?= __('Protocol #') ?></th>
    <td><?= $order->protocol ?></td>
</tr>
<tr>
    <th align="left"><?= __('Total Plugs This Week') ?></th>
    <td><?= $order->total_plugs ?></td>
</tr>
<tr>
    <th align="left"><?= __('Protocol Expiry Date') ?></th>
    <td><?= h(date_format(date_create($order->protocol_expiration), 'Y-m-d')); ?></td>
</tr>
<tr>
    <th align="left"><?= __('For The Week Of') ?></th>
    <td><?= h(date_format(date_create($order->time_period_start), 'Y-m-d')); ?></td>
</tr>
<tr>
    <th align="left"><?= __('Through') ?></th>
    <td><?= h(date_format(date_create($order->time_period_end), 'Y-m-d')); ?></td>
</tr>

<tr>
    <th align="left"><?= __('Modified') ?></th>
    <td><?= h($order->modified) ?></tr>
</tr>
<tr>
    <th align="left"><?= __('Status') ?></th>
    <td><?= $order->status ?> on <?php echo $order->finalize_date; ?></span>
    </tr>
</tr>
<tr>
    <th align="left"><?= __('Note') ?></th>
    <td><?= h($order->note); ?></span>
    </tr>
</tr>
</table>
<br/>
<strong><small>ENTRIES</small></strong>
<hr/>
        <table>
            <tr>
                <th><?= __('Recharge') ?></th>
                <th><?= __('Location') ?></th>
                <th><?= __('Date PMSG Recieved') ?></th>
                <th><?= __('Date Brought Out') ?></th>
                <th><?= __('Quantity') ?></th>
                <?php if ($order->status == 'open') { ?>
                <th class="actions"><?= __('Actions') ?></th>
                <?php } ?>
            </tr>
            <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?= h($entry->recharge) ?></td>
                <td><?= h($entry->location) ?></td>
                <td><?= h(date_format(date_create($entry->date_plugged), 'Y-m-d')); ?></td>
                <td><?= h(date_format(date_create($entry->date_needed), 'Y-m-d')); ?></td>
                <td><?= h($entry->quantity) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>


