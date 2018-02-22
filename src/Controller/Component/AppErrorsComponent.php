<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class AppErrorsComponent extends Component
{
    public function saveError($errorType, $error, $entityId=null) {
        $errorsTable = TableRegistry::get('Errors');
        $error = $errorsTable->newEntity([
            'error_type' => $errorType,
            'error' => $error,
            'this_object_dump_json' => json_encode($this),
            'entity_id_no' => $entityId, //e.g. Injection ID when adding an injection
            'user_id' => $_SESSION['Auth']['User']['id']
        ]);
        return $errorsTable->save($error);
    }
}