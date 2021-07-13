<?php

include_once(__ROOT__ . "/config.php");

class BasicView
{
    private $folder;
    private $data;
    function __construct($folder)
    {
        $this->folder = $folder;
    }

    /**
     * Envida dados para a view
     */
    function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Recebe dados da view
     */
    function getData()
    {
        $this->data['get'] = $_GET;
        $this->data['post'] = $_POST;
        return $this->data;
    }

    /**
     * Renderiza a tela.
     * @param string $render nome da view que será carregada
     * @param string/object $componentName nome do componente de /components ou objeto data.
     */
    function render($render = "index", $componentName = null)
    {
        if($componentName != null) {
            if(is_string($componentName)) {
                $component = $componentName."Component";
                include __ROOT__. "/components/" .$component.".php";
                $this->data = new $component();
            } else {
                $this->data = $componentName;
            }
        }
        include $this->folder . "/" . $render . ".php";
    }

    /**
     * Redireciona página.
     */
    function redirect($controller, $action, $parameter = array())
    {
        $url = $_SERVER['HTTP_HOST']
            . dirname($_SERVER['PHP_SELF']) . "/"
            . urlController($controller, $action, $parameter);
        header("Location: http://" . $url);
    }


    /**
     * carrega a ação.
     */
    function action($controller, $action, $parameter = array())
    {
        return urlController($controller, $action, $parameter);
    }
}
