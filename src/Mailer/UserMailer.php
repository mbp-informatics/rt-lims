<?php
namespace App\Mailer;
use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    public function finalize($order, $email=null)
    {
        if ($email) {
            $this->addTo($email);
        }
        $this
            ->emailFormat('both');
        
        $subject = 'New pseudopregnant recipient order#';
        if ($order->pseudopregnant_recipient_order_entries[0]['type'] == 'in-house B6NCRL') {
            $this->template('finalize_b6n', 'default');    
            $subject = 'New in-house B6NCRL mice order#';
        }
        $this
            ->subject(sprintf($subject.$order->id))
            ->viewVars(['order' => $order])
            ->viewVars(['requestor' => $order->user])
            ->viewVars(['entries' => $order->pseudopregnant_recipient_order_entries]);
    }
}
