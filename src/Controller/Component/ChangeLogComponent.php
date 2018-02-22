<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ChangeLogComponent extends Component
{
    public function getAssocChangeLog($parentModel, $children, $manyToManyDefs=null) {
        $dataSet = [];
        $id = $parentModel['id'];
        //Get Parent table changes
        $t = TableRegistry::get('ChangeLog');
        $res = $t
            ->find('all')
            ->where(['table_alias'=> $parentModel['tableName']])
            ->andWhere(['entity_id'=> $id])
            ->order(['id' => 'desc']);
        $dataSet[$parentModel['tableName']] = $res->toArray();

        //Get associated table changes (left joins)
        foreach ($children['tables'] as $childTable) {
           $res = $t            
            ->find('all')
            ->where(['table_alias'=> $childTable])
            ->andWhere(['old_entity LIKE'=> '%"'.$children['fk'].'";i:'. $id .'%']) //old_entity holds serialized data, to look through this data without deserializing, we need this fancy string (e.g. LIKE '%"job_id";i:14639%')
            ->order(['id' => 'desc']); 
        $dataSet[$childTable] = $res->toArray();
        }

        if (!isset($manyToManyDefs)) {
            return $dataSet;
        }

        //Get associated table changes (many-to-many)
        foreach ($manyToManyDefs as $def) {
            //Get current lookup table values to identify the associated entries
            $tl = TableRegistry::get($def['lookup']['table']);
            $res = $tl           
                ->find('all')
                ->where([ $children['fk'] => $id])->toArray();

            //now get any changes logged for these entries
            $manyToManyChanges = [];
            foreach ($res as $entry) {
                $res = $t            
                    ->find('all')
                    ->where(['table_alias'=> $def['target']['table']])
                    ->andWhere(['old_entity LIKE'=> '%"'.$def['target']['pk'].'";i:'. $entry[$def['lookup']['fk']] .'%'])
                    ->order(['id' => 'desc']);
                foreach ($res->toArray() as $ch) { //flatten the result set
                    $manyToManyChanges[] = $ch;
                }
            }
            $dataSet[$def['target']['table']] = $manyToManyChanges;
        }
        return $dataSet;
    }
}