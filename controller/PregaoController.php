<?php

include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores('Pregao');
        $this->loadView('pregao');
    }

    function index($params)
    {
        pr($this->pregao->findAll());

        // $this->view->setData($this->pregao->findAll());

        $this->view->render("index",$this->pregao->findAll());

    }
    function add()
    {
        $this->view->render("form","PregoesForm");
    }
    function edit()
    {
        $getId = $this->view->getData()['get']['id'];
        $this->view->render("form",$this->pregao->findById($getId));
        pr("Carregar VIEW");
        
    }
    function insert()
    {
verificar erro ao salvar.
        $post = $this->view->getData()['post'];
        $this->pregao->create((object) $post);
        $this->view->redirect('Pregao', "index");
    }
    function update()
    {

        // $data = $this->pregao->read(1);
        // $this->view->setData($data);
        pr("Carregar VIEW");
    }

    function save($data)
    {
        pr($this->pregao->create($data));
    }
}
