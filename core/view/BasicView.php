<?php
namespace TPPA\CORE\view;

use TPPA\CORE\BasicSystem;
use TPPA\CORE\BasicFunctions;

use function TPPA\CORE\basic\pr;

// include_once(__ROOT__ . "/config.php");

class BasicView extends BasicSystem
{
    private $folder;
    public $basicFunctions;
    public $component;
    // Variável de tramitação dos valores com o controller.
    private $data = array();
    // titilo utilizado no body_start.php
    public $title = null;
    public $template_js = null;

    public $controller;
    public $action;

    function __construct($folder)
    {
        $this->folder = $folder;
        $this->basicFunctions = new BasicFunctions();
    }

    /**
     * Envida dados para a view
     */
    function setData($data)
    {
        $this->data = $data;
    }

    /**
     * retorna array com chave get e post.
     */
    function getData()
    {
        $this->data['get'] = $_GET;
        $this->data['post'] = $_POST;
        return $this->data;
    }

    /**
     * Retorna get
     */
    function dataGet()
    {
        $get = $_GET;
        $this->controller = $get['controller'];
        unset($get['controller']);
        $this->action = $get['action'];
        unset($get['action']);
        return $get;
    }

    /**
     * Retorna post
     */
    function dataPost()
    {
        return $_POST;
    }

    /**
     * Renderiza do controller para view.
     * Carrega componente com o mesmo nome do 'folder' e 'render' em CamelCase.
     * @TODO: melhor maneira de renderizar a pagina, utilizando (namespace e use)
     * @param string $render nome da view que será carregada
     * @param string/object $dataComponent sobrescreve componente a ser carregado
     */
    function render($render = "index", $dataComponent = null)
    {
        $this->data = $dataComponent;
        include __APP_VIEW__."/template/config_template.php";
        include __APP_VIEW__."/template/header.php";
        include __APP_VIEW__."/template/body_start.php";
        include __APP_VIEW__."/" .  $this->folder . "/" . $render . ".php";
        include __APP_VIEW__."/template/body_end.php";
        if(strpos(__DIR__, 'PRODUCAO') === false) {
            pr($this->data);
        }
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Redireciona página para outro controller..
     */
    function redirect($controller, $action, $parameter = array())
    {
        $url = $_SERVER['HTTP_HOST']
            . dirname($_SERVER['PHP_SELF']) . "/"
            . $this->basicFunctions->urlController($controller, $action, $parameter);
        header("Location: http://" . $url);
    }

    /**
     * Redireciona para a URL do histórico.
     */
    function reloadHistory() {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

    /**
     * Download do arquivo e redirecionamento and Redirect.
     */
    function download($path)
    {
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($path));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        header("Content-Type: " . mime_content_type($path));
        // header("Content-Type: text/plain");
        readfile($path);            
    }


    /**
     * Direciona ação da view para o controller.
     */
    function action($controller, $action, $parameter = array())
    {
        $urlController = $this->basicFunctions->urlController($controller, $action, $parameter);
        if(is_null($urlController)) {
            return $this->basicFunctions->urlController("Exception", "access_denied");
        }
        return $urlController;
    }
}
