<?php

namespace TPPA\APP\view\template;

use TPPA\CORE\BasicFunctions;

// use function TPPA\CORE\basic\pr;

// include_once __ROOT__ . '/config.php';

$navbar = array(
    array( // obrigatório apenas 1 por array
        'type' => 'brand',
        'text' => 'CRCEA-SE<br>TPPA',
        'href' => array('controller' => CONFIG['HOME_PAGE']['controller'], 'action' => CONFIG['HOME_PAGE']['action']),
        'icon' => 'fas fa-fighter-jet', // opcional.
    ),
    array( // link de acesso direto
        'type' => 'link',
        'text' => 'Dashboard',
        'href' => array('controller' => "Dashboard", 'action' => 'index'),
        'icon' => 'fas fa-fw fa-tachometer-alt', // opcional
    ),
    array( // texto de cabeçalho de cada menu
        'type' => 'heading',
        'text' => 'Pregão',
        'itens' => array(
            array( // link de acesso direto
                'type' => 'link',
                'text' => 'Cadastro',
                'href' => array('controller' => "Pregao", 'action' => 'index'),
        
                'icon' => 'fas fa-folder-plus text-gray-300', // opcional
            ),
            array( // link de acesso direto
                'type' => 'links',
                'text' => 'Solicitação',
                'icon' => 'fas fa-fw fa-cog', // opcional
                'href' => array('controller' => "PedidoPregao", 'action' => 'index'),
                'icon' => 'fas fa-truck-moving text-gray-300', // opcional
                'sub_itens' => array(
                        array(
                            'type' => 'link',
                            'href' => array('controller' => "PedidoPregao", 'action' => 'index'),
                            'text' => 'Pedidos',
                        ),
                        array(
                            'type' => 'link',
                            'href' => array('controller' => "PesquisarPedidoPregao", 'action' => 'index'),
                            'text' => 'Pesquisar',
                        ),                        
                    )
            ),                     
        )
    ),
    array( // texto de cabeçalho de cada menu
        'type' => 'heading',
        'text' => 'Necessidade',
        'itens' => array(
            array( // link de acesso direto
                'type' => 'link',
                'text' => 'Necessiade',
                'href' => array('controller' => "Necessidade", 'action' => 'index'),
        
                'icon' => 'far fa-play-circle text-gray-300', // opcional
            ),
        )
    ),    
    array( // texto de cabeçalho de cada menu
        'type' => 'heading',
        'text' => 'Usuário',
        'itens' => array(
            array( // link de acesso direto
                'type' => 'link',
                'text' => 'Usuários',
                'href' => array('controller' => "User", 'action' => 'index'),
                'icon' => 'fas fa-fw fa-users', // opcional
            ),    
            array( // link de acesso direto
                'type' => 'link',
                'text' => 'Minhas Informações',
                'href' => array('controller' => "User", 'action' => 'my_info'),
                'icon' => 'fas fa-fw fa-user-tag', // opcional
            ),   
        )
    ),
);

/**
 * Converte href array para string.
 * Verifica se tem acesso a url (urlController).
 * Se não exclui valor da url.
 */
function navbarConvertHref(&$arrNavbar) {
    if(!is_array($arrNavbar)) {
        return;
    }
    $basicFunctions = new BasicFunctions();

    // var_dump($basicFunctions);

    foreach($arrNavbar as $key => &$valor) {
        if(is_array($valor)) {
            if(($key == "href") && isset($valor['controller']) && isset($valor['action'])) {
                $valor = $basicFunctions->urlController($valor['controller'], $valor['action']);
                if(is_null($valor)) {
                    return false;
                }
            } 
            if(navbarConvertHref($valor) === false) {
                unset($arrNavbar[$key]);
            }
        }
    }

}

navbarConvertHref($navbar); 


// pr($navbar);
// die;
/**
 * Exemplo sidebar conforme template 
 * https://startbootstrap.com/theme/sb-admin-2.
 * key: type => brand, link, links, heading
 */
// $navbar = array(
//     array( // obrigatório
//         'type' => 'brand',
//         'text' => 'SB Admin <sup>2</sup>',
//         'href' => 'index.html',
//         'icon' => 'fas fa-laugh-wink', // opcional.
//     ),
//     array( // link de acesso direto
//         'type' => 'link',
//         'text' => 'Dashboard',
//         'href' => 'index.html',
//         'icon' => 'fas fa-fw fa-tachometer-alt', // opcional
//     ),
//     array( // texto de cabeçalho de cada menu
//         'type' => 'heading',
//         'text' => 'Interface'
//     ),
//     array( // link em sub itens obs: 'linkS' com 'S' 
//         'type' => 'links',
//         'icon' => 'fas fa-fw fa-cog', // opcional
//         'text' => 'Components',
//         'sub_itens' => array(
//             array(
//                 'type' => 'title',
//                 'text' => 'Custom Components:'
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'buttons.html',
//                 'text' => 'Buttons',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'cards.html',
//                 'text' => 'Cards',
//             ),
//         )
//     ),
//     array(
//         'type' => 'links',
//         'icon' => 'fas fa-fw fa-wrench', // opcional
//         'text' => 'Utilities',
//         'sub_itens' => array(
//             array(
//                 'type' => 'title',
//                 'text' => 'Custom Utilities:'
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'utilities-color.html',
//                 'text' => 'Colors',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'utilities-border.html',
//                 'text' => 'Borders',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'utilities-animation.html',
//                 'text' => 'Animations',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'utilities-other.html',
//                 'text' => 'Other',
//             ),
//         )
//     ),
//     array(
//         'type' => 'heading',
//         'text' => 'Addons'
//     ),
//     array( // nav-item
//         'type' => 'links',
//         'icon' => 'fas fa-fw fa-folder', // opcional
//         'text' => 'Pages',
//         'sub_itens' => array(
//             array(
//                 'type' => 'title',
//                 'text' => 'Login Screens:'
//             ), //collapse-header
//             array(
//                 'type' => 'link',
//                 'href' => 'login.html',
//                 'text' => 'Login',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'register.html',
//                 'text' => 'Register',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'forgot-password.html',
//                 'text' => 'Forgot Password',
//             ),
//             array(
//                 'type' => 'title',
//                 'text' => 'Other Pages:'
//             ), //collapse-header            
//             array(
//                 'type' => 'link',
//                 'href' => '404.html',
//                 'text' => '404 Page',
//             ),
//             array(
//                 'type' => 'link',
//                 'href' => 'blank.html',
//                 'text' => 'Blank Page',
//             ),
//         )
//     ),
//     array(
//         'type' => 'link',
//         'icon' => 'fas fa-fw fa-chart-area', // opcional
//         'text' => 'Charts',
//         'href' => 'charts.html',
//     ),
//     array(
//         'type' => 'link',
//         'icon' => 'fas fa-fw fa-table', // opcional
//         'text' => 'Tables',
//         'href' => 'tables.html',
//     ),
// );
