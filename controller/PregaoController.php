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
        pr($params);
        // $newPregao = new PregaoStore();
        // pr($newPregao->findAll());
        pr($this->pregao->findAll());
    }
    function add()
    {
        $this->view->render("form");
    }
    function edit()
    {
        pr("Carregar VIEW");
    }
    function insert()
    {
        $post =  $this->view->getData()['post'];
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
