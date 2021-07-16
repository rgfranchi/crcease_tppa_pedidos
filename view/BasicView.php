<?php

include_once(__ROOT__ . "/config.php");

class BasicView
{
    private $folder;
    // Variavel de tramiação dos valores com o controller.
    private $data = array();
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
        pr($this->data);
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
     * Renderiza do controller para view.
     * Carrega componente com o mesmo nome do 'folder' e 'render' em CamelCase.
     * @param string $render nome da view que será carregada
     * @param string/object $component sobrescreve componente a ser carregado
     */
    function render($render = "index", $component = null)
    {
        if (is_null($component)) {
            $component = snakeToCamelCase($this->folder . '_' . $render . "_component");
            include __ROOT__ . "/components/" . $component . ".php";
            $new_data = new $component();
            $this->data = $this->loadData($new_data);
        } else {
            $this->data = $component;
        }
        // Todo: criar classe para carrgar templates e incluir pagina render.... 
        include __ROOT__ . "/template/menu.php";
        include $this->folder . "/" . $render . ".php";
    }

    private function loadData($data)
    {
        if (empty($this->data)) {
            return $data;
        }
        foreach ($this->data as $key => $value) {
            $data->$key = $value;
        }
        return $data;
    }

    /**
     * Redireciona página para outro controller..
     */
    function redirect($controller, $action, $parameter = array())
    {
        $url = $_SERVER['HTTP_HOST']
            . dirname($_SERVER['PHP_SELF']) . "/"
            . urlController($controller, $action, $parameter);
        header("Location: http://" . $url);
    }


    /**
     * Direciona ação da view para o controller.
     */
    function action($controller, $action, $parameter = array())
    {
        return urlController($controller, $action, $parameter);
    }
}
