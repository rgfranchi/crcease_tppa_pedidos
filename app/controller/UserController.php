<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;
use function TPPA\CORE\basic\pr;

class UserController extends BasicController
{
    private $session = null;

    function __construct()
    {
        $this->loadView('user');
        $this->userRepository = $this->loadRepository("User");
        $this->session = new SessionController();
    }

    function index()
    {
        $this->view->setTitle("Usuários do Sistema");
        $this->view->render("index", $this->userRepository->findAll(['login' => 'asc']));
    }

    function add_lpad()
    {
        if(isset($_SESSION['user'])) {
            $this->view->redirect('Dashboard','index');
        }        
        $data = $this->view->dataGet();
        $this->view->setTitle("Cadastro primeiro acesso");
        $this->view->render("form_lpad", (Object) $data);
    }

    function save_lpad()
    {
        if(isset($_SESSION['user'])) {
            $this->view->redirect('Dashboard','index');
        }        
        $data = $this->view->dataPost();
        $data['ativo'] = true;
        $this->save($data);
        $this->session->create_session('BASICO', false);
        $this->view->redirect("Dashboard", "index");
    }

    function add_externo()
    {
        if(isset($_SESSION['user'])) {
            $this->view->render("info_cadastro", 
                array(
                    'Para criar cadastro EXTERNO é necessário realizar "LOGOUT"',
                )
            );
        }
        $this->view->setTitle("Solicitação de cadastro");
        $this->view->render("form_externo");
    }

    function save_externo() {
        if(isset($_SESSION['user'])) {
            $this->view->redirect('Dashboard','index');
        }        
        $data = $this->view->dataPost();
        $data['ativo'] = false;
        $data['password'] = $this->session->encryptPassword($data['login'], $data['password']);
        $this->save($data);
        unset($data['password']);
        $this->view->render("info_cadastro", 
            array(
                'Caro:'.$data['nome'],
                'Solicito enviar e-mail a TPPA informado que o cadastro foi realizado.',
                '"Seção de Projetos e Aquisições" <_tppa.crcease@fab.mil.br>',
            )
        );
    }

    function save($data) {
        if(!$this->exist_user($data)) {
            if($data['ativo'] == true) {
                $this->session->user_session($data);
            }    
            $this->userRepository->save($data);
        }
    }

    private function exist_user($data) {
        $ret = false;
        $user = $this->userRepository->firstBy(["login", "==", $data['login']]);
        if(!empty($resp)) {
            $ret = true;     
            $this->view->render("info_cadastro", 
                array(
                    'Usuário já cadastrado:',
                    'Login > ' . $user['login'],
                    'Usuário > ' . $user['nome'],
                    'Contato > "Seção de Projetos e Aquisições" <_tppa.crcease@fab.mil.br>' 
                )
            );       
        }
        return $ret;
    }


    function my_info() {
        $data = $_SESSION['user'];
        if(isset($data['password']) && !empty($data['password'])) {
            $data->password = "";
        }
        $this->view->render("form_my_info", $data);
    }

    function my_info_update() {
        $this->update(true);
        $this->view->redirect("Dashboard", "index");
    }

    function edit()
    {
        $this->view->setTitle("Atualizar informações do usuário");
        $data = $this->userRepository->findById($this->view->dataGet()['id']);
        $this->view->render("form", $data);
    }

    function edit_update() {
        $this->update();
        $this->view->redirect("User", "index");
    }

    function update($update_session = false) {
        $data = $this->view->dataPost();
        if(!isset($data['ativo'])) {
            $data['ativo'] = false;
        }
        if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = $this->session->encryptPassword($data['login'], $data['password']);
        }
        $this->userRepository->update($data);
        $update_session ? $this->session->user_session($data) : null;
    }

    function delete()
    {
        $this->userRepository->delete($this->view->dataGet()['id']);
        $this->view->redirect("User", "index");
    }

    // function download_file()
    // {
    //     $obj = $this->loadBasicStores("Pregao")->findAll(['nome' => 'asc']);
    //     $file_path = $this->php_spreadsheet->saveFile($obj, 'tmp_file');
    //     $this->view->download($file_path, "Pregao", "index");
    // }

}
