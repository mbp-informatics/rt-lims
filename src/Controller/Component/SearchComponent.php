<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class SearchComponent extends Component
{
    public $components = ['Paginator'];

    //Not all table names follow cake's conventions. ooopsie!
    public $realModelNames = [
        //'what_cake_inflects' => 'real_table_name'
        'embryo_resuses' => 'embryo_resus',
        'komp_clones_dumps' => 'komp_clones_dump',
        'komp_genes_dumps' => 'komp_genes_dump',
        'komp_vials_dumps' => 'komp_vials_dump',
        'mgi_genes_dumps' => 'mgi_genes_dump',
        'change_logs' => 'change_log'
    ];

    public $excludedControllers = ['GeneNameChanges']; //e.g. model-less controllers
    public $includedActions = ['index'];

    public function initialize(array $config)
    {
        /**
         *  Pass table field names to the view - required by pagination input.
         *  Do this only if action = index
         */
        $controller = $this->_registry->getController();
        if (in_array($this->request->action, $this->includedActions) && !in_array($controller->name, $this->excludedControllers) ) {
            $db = ConnectionManager::get('default');
            $collection = $db->schemaCollection();
            $modelName = \Cake\Utility\Inflector::tableize($controller->modelClass);
            if (isset($this->realModelNames[$modelName])) {
                $modelName = $this->realModelNames[$modelName];
            }
            $tableSchema = $collection->describe($modelName);
            $columns = $tableSchema->columns();
            $controller->set('modelFields', $tableSchema->columns());
        }
    }

    public function getDataTablesResultSetForAdvancedSearch($request, $modelName, array $contain=null) {
        $request = !empty($request->query) ? $request->query : $request->data; //GET vs POST request
        $searchString = explode('advs|', $request['search']['value'])[1];
        /**
         * Parse the query into chunks (1 chunk = 1 field data)
         * and link them with AND/OR operators. Resulting structure will
         * look something like this:

            $chunkedQuery =
                             [
                                (int) 0 => [
                                    (int) 0 => 'strain_name',
                                    (int) 1 => 'equals',
                                    (int) 2 => 'C57'
                                ],
                                (int) 1 => 'OR',
                                (int) 2 => [
                                    (int) 0 => 'job_id',
                                    (int) 1 => 'not_equals',
                                    (int) 2 => '16987'
                                ],
                                (int) 3 => 'AND',
                                (int) 4 => [
                                    (int) 0 => 'job_status',
                                    (int) 1 => 'contains',
                                    (int) 2 => 'closed'
                                ]
                            ]
        */

        $chunkedQuery = [];
        $i = 0;
        foreach (explode('|', $searchString) as $k=>$queryPart) {
            $i++;
            if ($queryPart == 'AND' || $queryPart == 'OR') {
                $chunkedQuery[] = $queryPart;
                $i = 0;
                continue;
            }
            $chunk[] = $queryPart;
            if ($i%3 === 0) {
                $chunkedQuery[] = $chunk;
                $chunk = [];
                $i = 0;
            }
        }

        //Now let's build a query
        $table = TableRegistry::get($modelName);
        $query = $table->find('all');
        $operator = 'OR'; //default operator for the first chunk
        foreach ($chunkedQuery as $chunk) {
            if (is_array($chunk)) {
                $f = (string) $chunk[0]; //field name
                $v = (string) $chunk[2]; //value
                switch ($operator) {
                    case 'AND':
                        $methodName = 'andWhere';
                    break;
                    case 'OR':
                        $methodName = 'orWhere';
                    break;
                }
                switch ($chunk[1]) { //comparison operator
                    case 'equals':
                        $whereArr = [$modelName.'.'.$f.' =' => $v]; //e.g. "Jobs.id = 3"
                    break;
                    case 'not_equals':
                    $whereArr = [$modelName.'.'.$f.' !=' => $v];
                    break;
                    case 'contains':
                    $whereArr = [$modelName.'.'.$f.' LIKE' => '%'.$v.'%'];
                    $defType = [$modelName.'.'.$f => 'string'];
                    break;
                    case 'not_contains':
                    $whereArr = [$modelName.'.'.$f.' NOT LIKE' => '%'.$v.'%'];
                    $defType = [$modelName.'.'.$f => 'string'];
                    break;
                    case 'greater_than':
                    $whereArr = [$modelName.'.'.$f.' >' => $v];
                    break;
                    case 'less_than':
                    $whereArr = [$modelName.'.'.$f.' <' => $v];
                    break;
                }
            
            }

            //This will be used in the next iteration
            if (is_string($chunk)) {
                $operator = $chunk;
            }

            //No search params = return empty set
            if (!isset($methodName) || !isset($whereArr)) {
                return ['data'=>[]];
            }
            //Chain the query with appropriate method and where statement.
            if (isset($contain) && !empty($contain)){
                $query->$methodName($whereArr, isset($defType) ? $defType : [])->contain($contain);
            } else {
                $query->$methodName($whereArr, isset($defType) ? $defType : []);
            }
        }

        $len = $query->count();
        $resp['iTotalRecords'] = $len;
        $resp['iTotalDisplayRecords'] = $len;

        /**
        * Pagination rules:
        * Cater for the fact, that Cake's pagination begins 
        * at 1 not 0 (unlike DataTable's)...
        */
        $start = (int) $request['start'];
        $length = (int) $request['length'];
        $pageNo = $start / $length;
        $pageNo = ($pageNo==0) ? 1 : $pageNo+1;

        //Ordering rules
        $orderRules = [];
        foreach ($request['order'] as $cond){
            $colNo = $cond['column'];
            $colName = $request['columns'][$colNo]['data'];
            $dir = $cond['dir'];
            $orderRules[$colName] = $dir;
        }
        //Prepare the data set
        $settings = [
            'limit' => $length,
            'maxLimit' => 1000000, //this is a global setting, make it high enough! A million rows should do, right?
            'page' => $pageNo,
            'order' => $orderRules
        ];
        $resp['data'] = $this->Paginator->paginate($query, $settings)->toArray();
        $resp = $this->formatDates($resp);
        $resp = $this->formatBools($resp);
        return $resp;
    }

    /**
     * This method prepares the result set to be displayed by 
     * dataTables.js. It parses Cake's request object for dataTable.js paramters and
     * returns a proper restult set.
     * Tomek 8/21/2017
     */
    public function getDataTablesResultSet($request, $modelName, $assoc = [], $where = null) {
        //Input validation
        foreach ($assoc as $str) {
            if (is_array($str)) {
                throw new \Exception("getDataTablesResultSet() method accepts a FLAT array as its third argument. If you want to use deep associations, please specify them using the dot notation e.g.: 'Injections.Projects.MgiGenesDump' instead of arrays");
            }
        }
        $table = TableRegistry::get($modelName);
        $query = $table->find('all');
        // Use 'where' condition
        if (isset($where)) {
            $query->where($where);    
        }
        $query->contain($assoc);

        $request = !empty($request->query) ? $request->query : $request->data; //GET vs POST request

        //Search conditions
        if ($param = !empty($request['search']['value']) ? $request['search']['value'] : null ) {
            $controller = $this->_registry->getController();
            $cond = $this->getSearchConditions($param, $controller, $assoc, $modelName);
             foreach ($assoc as $assocModel) {
                $query->leftJoinWith($assocModel);
            }
            $query->where(['OR' => $cond])->group($modelName . '.id');
        }
        $len = $query->count();
        $resp['iTotalRecords'] = $len;
        $resp['iTotalDisplayRecords'] = $len;

        if (empty($request)) { // first page - use default pagination settings
            $resp['data'] = $this->Paginator->paginate($query, [
                'limit' => 10,
                'page' => 1
        ])->toArray();
            $resp = $this->formatDates($resp);
            $resp = $this->formatBools($resp);
            return $resp;
        }

        /**
        * Pagination rules:
        * Cater for the fact, that Cake's pagination begins 
        * at 1 not 0 (unlike DataTable's)...
        */
        $start = (int) $request['start'];
        $length = (int) $request['length'];
        $pageNo = $start / $length;
        $pageNo = ($pageNo==0) ? 1 : $pageNo+1;

        //Ordering rules
        $orderRules = [];
        foreach ($request['order'] as $cond){
            $colNo = $cond['column'];
            $colName = $request['columns'][$colNo]['data'];
            $dir = $cond['dir'];
            $orderRules[$colName] = $dir;
        }
        //Prepare the data set
        $settings = [
            'limit' => $length,
            'maxLimit' => 1000000, //this is a global setting, make it high enough! A million rows should do, right?
            'page' => $pageNo,
            'order' => $orderRules
        ];
        $resp['data'] = $this->Paginator->paginate($query, $settings)->toArray();
        $resp = $this->formatDates($resp);
        $resp = $this->formatBools($resp);
        return $resp;
    }

    private function formatDates($resp) {
        //reformat time/date objects
        foreach ($resp['data'] as $k=>$row) {
            foreach ($row->toArray() as $field=>$val) {
                if ($val instanceof \Cake\I18n\Date) {
                    $resp['data'][$k][$field] = $val->format('Y-m-d');
                }
                if ($val instanceof \Cake\I18n\Time) {
                    $resp['data'][$k][$field] = $val->format('Y-m-d H:i:s');
                }
            }
        }
        return $resp;
    }

    private function formatBools($resp) {
            //present booleans in an aesthetic manner
            foreach ($resp['data'] as $k=>$row) {
                foreach ($row->toArray() as $field=>$val) {
                    if ($val === true) {
                        $resp['data'][$k][$field] = '<span class="bool-yes glyphicon glyphicon-ok"> Yes</span>';
                    }
                    if ($val === false) {
                        $resp['data'][$k][$field] = '<span class="bool-no glyphicon glyphicon-remove"> No</span>';
                    }
                }
            }
            return $resp;
    }

    /**
     * Global search function used on index pages:
     * It is searching all fields of a parent table
     * Tomek 8/24/2017
     */
    public function getSearchConditions($searchPhrase, $controllerInstance, $associations, $model_name) {
        $inner_conds = array();
        if (!$searchPhrase) { return False; } //abort if there's no search phrase
        if (!isset($model_name)) {
            //Get some meta information
            $model_name = $controllerInstance->modelClass;
        }

        $table = TableRegistry::get($model_name);
        // Prepare conditions for the main table
        foreach ($table->schema()->columns() as $col) {
            $col_type = $table->schema()->columnType($col);
            if ($this->processColumns($searchPhrase, $col, $col_type, $inner_conds, $model_name) === false) {
                continue; //skip booleans
            }
        }

        //unpack dot notation to a flat array
        $flatAssoc = [];            
        foreach ($associations as $assoc) {
            if (strstr($assoc, '.')) {
                $flatAssoc = array_merge(
                    $flatAssoc,
                    array_map(function($assoc) {
                        return $assoc;
                    },explode('.', $assoc)));
            } else {
                $flatAssoc[] = $assoc;
            }
        }

        // Prepare conditions for associated tables
        foreach ($flatAssoc as $a) {
            $model_name = $a;
            $t = TableRegistry::get($model_name);
            //Get associated table column names and populate the array
            foreach ($t->schema()->columns() as $col){
                $col_type = $t->schema()->columnType($col);
                if ($this->processColumns($searchPhrase, $col, $col_type, $inner_conds, $model_name) === false) {
                    continue; //skip booleans
                }
            } //end foreach columns()
        } //end foreach associations
        return $inner_conds;
    }

     /**
     * A wrapper used by getSearchConditions() to generate query
     * conditions per table column. It's destructive in a sense that it's 
     * modifing the global $inner_conds
     * Tomek 8/24/2017
     */
    private function processColumns($searchPhrase, $col, $col_type, &$inner_conds, $model_name) {
        if ($col_type == 'boolean' ) { //skip booleans
            return false;
        }
        if ($col_type != 'integer') { // we have a string
            $searchPhraseString = '%'.$searchPhrase.'%';
            $key = $model_name.'.'.$col.' LIKE';
            $inner_conds[$key] =  $searchPhraseString;
        } elseif (($col_type == 'integer' || $col_type == 'float') && is_numeric($searchPhrase)) { //we have a numeric
            $searchPhraseString = (int) $searchPhrase;
            $key = $model_name.'.'.$col;
            $inner_conds[$key] =  $searchPhraseString;
        }
        return true;
    }

}