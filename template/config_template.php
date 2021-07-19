<?php
include_once __ROOT__ . '/config.php';
$navbar = array(
    array( // obrigatório
        'type' => 'brand',
        'text' => 'TPPA CRCEA',
        'href' => urlController("Pregao", 'index'),
        'icon' => 'fas fa-laugh-wink', // opcional.
    ),
    array( // link de acesso direto
        'type' => 'link',
        'text' => 'Dashboard',
        'href' => urlController("Dashboard", 'index'),
        'icon' => 'fas fa-fw fa-tachometer-alt', // opcional
    ),
    array( // texto de cabeçalho de cada menu
        'type' => 'heading',
        'text' => 'Pregão'
    ),
    array( // link de acesso direto
        'type' => 'link',
        'text' => 'Pregão',
        'href' => urlController("Pregao", 'index'),
        'icon' => 'fas fa-clipboard-list fa-2x text-gray-300', // opcional
    ),

);



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
//     array( // link em sub itens obs: tem 'S' 
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
