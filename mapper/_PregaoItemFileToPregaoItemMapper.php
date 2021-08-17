<?php 

include_once 'BasicMapper.php';

class PregaoItemFileToPregaoItemMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("PregaoItem", "PregaoItemFile");
    }


    function dataPregaoItem($post) {
        $pregao_id = $post['pregao_id'];
        $typeField = $post['typeField'];
        $data = $post['data_load'];
        $newData = array();
        foreach($data as $itens) {
            $pregaoItem = new PregaoItemDomain();
            $pregaoItem->pregao_id = $pregao_id;

            foreach($itens as $key => $value) {
                $type = $typeField[$key];
                $value = trim($value);
                switch($type) {
                    case 'null':
                        continue;
                        break;
                    case 'valor_unitario':  
                    case 'valor_solicitado':  
                        is_numeric($value) ? $pregaoItem->{$type} = str_replace(',','',$value) : "";
                        break;
                    default:
                        $pregaoItem->{$type} = $value;
                }
            }
            $newData[] = $pregaoItem;
        }
        return $newData;
    }

}