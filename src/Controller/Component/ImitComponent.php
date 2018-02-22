<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;
require_once(($_SERVER['DOCUMENT_ROOT'].'/vendor/mbp/custom/imits.php'));

class ImitComponent extends Component
{
    //Gets Crispr sequence based on gRNA sequence
    public function getSeq($seq = null){
        if(isset($this->request->query["grna"])){
            $seq = $this->request->query["grna"];
        }
        if ($seq) {
            $http = new Client();
            $response = $http->get(
                'http://www.sanger.ac.uk/htgt/wge/api/search_by_seq', 
                ["seq" => $seq, "pam_right" => 2, "get_db_data" => 1, "species" => "Mouse"]
            );
            return $response->json;
        } 
        return array("error" => "A look up for gRNA {$seq} in Sanger API didn't return any values.");
    }
}
