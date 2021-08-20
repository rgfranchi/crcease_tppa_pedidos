<?php

include_once(__ROOT__ . "/config.php");

class BasicView extends BasicSystem
{
    private $folder;
    public $component;
    // Variável de tramitação dos valores com o controller.
    private $data = array();
    // titilo utilizado no body_start.php
    public $title = null;
    public $template_js = null;

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
        return $_GET;
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
     * @param string $render nome da view que será carregada
     * @param string/object $dataComponent sobrescreve componente a ser carregado
     */
    function render($render = "index", $dataComponent = null)
    {
        $this->data = $dataComponent;
        include "template/config_template.php"; // array com menu da aplicação.
        include "template/header.php";
        include "template/body_start.php"; // importa sidebar.php (menu)
        include $this->folder . "/" . $render . ".php";
        include "template/body_end.php"; // inclui scripts.
        pr($this->data);
        // include $this->folder . "/" . $render . ".php";
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
