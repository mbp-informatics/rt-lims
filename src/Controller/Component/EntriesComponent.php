<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class EntriesComponent extends Component
{
    public function sumTotalPlugs($orderId)
    {
    	$entriesTable = TableRegistry::get('PseudopregnantRecipientOrderEntries');
    	$res = $entriesTable->find('all', [
    		'conditions' => ['pseudopregnant_recipient_order_id =' => $orderId]
		]);
		$sumTotalPlugs = 0;
		foreach ($res as $entity) {
			$sumTotalPlugs += $entity['quantity'];
		}
        return $sumTotalPlugs;
    }

    public function saveTotalPlugsInOrder($orderId, $total_plugs)
    {
    	$ordersTable = TableRegistry::get('PseudopregnantRecipientOrders');
    	$order = $ordersTable->get($orderId);
    	$order->total_plugs = $total_plugs;
    	if ($ordersTable->save($order)) {
    		return true;	
    	} else {
    		return false;
    	}
		
    }
}