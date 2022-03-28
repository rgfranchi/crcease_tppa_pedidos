<?php
namespace TPPA\APP\controller;
use TPPA\CORE\controller\BasicController;
use function TPPA\CORE\basic\pr;

class SessionController extends BasicController
{

    function __construct()
    {
        $this->loadView('user');
        $this->loadBasicMapper("User","UserForm");
    }

    function menu()
    {
        $_SESSION['menu']['toggled'] = !$_SESSION['menu']['toggled'];
    }

    function login()
    {
        $postLogin = $this->view->dataPost();
        if($this->lpad_login($postLogin['login'],$postLogin['password'])) {
            $data = $this->user_map_user_form->domain()->findBy(["login", "==", $postLogin['login']]);
            if(empty($data)) {
                $this->create_session("CREATE_USER", false);
                return $this->view->redirect('User','add_lpad', array('login' => $postLogin['login'], 'cadastro' => "SISTEMA"));
            } else {
                $this->dataLoad($data[0]);
            }
        } else {
            $postLogin['password'] = $this->encryptPassword($postLogin['login'], $postLogin['password']);
            $data = $this->user_map_user_form->domain()->findBy([["login", "==", $postLogin['login']],["password", "==", $postLogin['password']]]);
            
            if(empty($data)) {
                return $this->view->render("info_cadastro", 
                    array(
                        'Usuário não localizado',
                        '<a href="index.php?controller=Dashboard&action=index">Retornar</a>'
                    )
                );
            } else {
                $this->dataLoad($data[0]);
            }
        }
    }

    function dataLoad($user) {
        if($user->ativo) {
            $this->user_session($user);
            $this->create_session($user->grupo);
        } else {
            if(is_object($user)) {
                $user = (array) $user;
            }
            return $this->view->render("info_cadastro", 
                array(
                    'Usuário inativo:',
                    'Login > ' . $user['login'],
                    'Usuário > ' . $user['nome'],
                    'Contato > "Seção de Projetos e Aquisições" <_tppa.crcease@fab.mil.br>'
                )
            );
        }
    }

    function inactive_user($data) {
           
    }

    function create_session($grupo = 'BASICO', $reload = true) {
        switch($grupo) {
            case 'CREATE_USER' :
                $_SESSION['login']['create_user'] = true;
                break;            
            case 'BASICO' :
                $_SESSION['login']['basico'] = true;
                break;            
            case 'GERENTE' :
                $_SESSION['login']['gerente'] = true;
                break;                
            case 'ADMIN' :
                $_SESSION['login']['admin'] = true;
                break;
            default :    
                $this->logout();
        }
        if($reload) { 
            $this->view->reloadHistory();
        }
    }

    function user_session($data_user) {
        if(is_object($data_user)) {
            $data_user = (array) $data_user;
        }
        unset($data_user['password']);
        $_SESSION['user'] = $data_user;
    }

    function logout()
    {
        unset($_SESSION['login']);
        unset($_SESSION['user']);
        $this->view->redirect('Dashboard', 'index');
    }

    function del()
    {
        pr($_SESSION);
        unset($_SESSION);
        pr($_SESSION);
    }    

    function encryptPassword($user, $password) {
        return base64_encode($user."jafgagLJNffepngPNGPEGNpafaaf".$password);
    }

    private function lpad_login($login, $password) {

        $config = lpad_config();

        // $user = "guerrargf".$domain;
        // $ldap_pass   = "Guerr2@06";
        $ldap_con = ldap_connect($config['server'], $config['port']) or die("Could not connect to LDAP server.");
    
        if ($ldap_con){
            // binding to ldap server
            //$ldapbind = ldap_bind($ldapconn, $user, $ldap_pass);
            $bind = @ldap_bind($ldap_con, $login.$config['domain'], $password);
            // verify binding
            if ($bind) {
                return true;
            } else {
                return false;
            }
        
        }        

    }

}