<?php
namespace TPPA\APP\component;

use DateTime;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

use function TPPA\CORE\basic\pr;

// include_once('helper/ItemPregaoHelper.php');

/**
 * Realiza calculo com os itens do pregão.

 */
class PregaoFunctionsComponent extends BasicComponent
{
    function data_vencimento_color($data, $params) {
        $pregao = $data->findById($params['pregao_id']);
        $dateNow = new DateTime();
        $dateVencimento = new DateTime($pregao['data_limite_solicitacao']); 
        $diff = $dateNow->diff($dateVencimento);
        $pregao['data_vencimento_color'] = "green";

        if($diff->invert == 1) {
            $pregao['data_vencimento_color'] = "red";
        } else {
            if($diff->m < 3) {
                $pregao['data_vencimento_color'] = "#DAA520";
            }
        }
        return (object) $pregao;
    }
}