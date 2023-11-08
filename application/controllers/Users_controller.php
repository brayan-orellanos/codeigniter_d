<?php

/**
 * @author    Brayan Orellanos
 * @copyright 2022 Conectera
 * @version   v 0.0
**/

defined('BASEPATH') or exit('No direct script access allowed');

include_once 'vendor/autoload.php';

class Users_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('users_model', '_users_model');

        $this->_view->assign('path_resources',                                  constant('RESOURCES'));
        $this->_view->assign('path_view_users_list',                            site_url('users'));
        $this->_view->assign('path_users_list',                                 site_url('users/list'));
        $this->_view->assign('path_view_add_users',                             site_url('users/view/add'));
        $this->_view->assign('path_view_detail_user',                           site_url('users/view/detail'));
        $this->_view->assign('path_view_edit_user',                             site_url('users/view/edit'));
        $this->_view->assign('path_users_display',                              site_url('users/display'));
        $this->_view->assign('path_users_add',                                  site_url('users/add'));
        $this->_view->assign('path_users_edit',                                 site_url('users/edit'));
        $this->_view->assign('path_users_udrop',                                site_url('users/udrop'));

    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    void
    **/
    public function view()
    {
        $list_enterprises                                                       =   $this->_users_model->list_enterprises();
        $this->_view->assign('enterprises',$list_enterprises['data']);
        $this->_view->display('admin/users/view.tpl');
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    void
    **/
    public function view_add()
    {
        $data                                                                   =   array();
        $list_enterprises                                                       =   $this->_users_model->list_enterprises();
        $list_areas                                                             =   $this->_users_model->list_areas();
        $list_users                                                             =   $this->_users_model->list(0,0,'//');
        $list_roles                                                             =   $this->_users_model->list_roles();
        $list_occupations                                                       =   $this->_users_model->list_occupations();
        $list_countries                                                         =   $this->_users_model->list_countries();
        $data['enterprises']                                                    =   $list_enterprises['data'];
        $data['areas']                                                          =   $list_areas['data'];
        $data['users']                                                          =   $list_users['data'];
        $data['roles']                                                          =   $list_roles['data'];
        $data['occupations']                                                    =   $list_occupations['data'];
        $data['countries']                                                      =   $list_countries['data'];         
        $this->_view->assign('data', $data);
        $this->_view->display('admin/users/add.tpl');
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    array
    **/
    public function add()
    {
        $params                                                                 =   $_POST;

        if($params)
        {
            $add                                                                =   $this->_users_model->add($params);
            echo json_encode($add);
            exit();
        } else
        {
            echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
            exit();
        }
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    array
    **/
    public function edit()
    {
        $params                                                                 =   $_POST;

        if($params)
        {
            $edit                                                                =   $this->_users_model->edit($params);
            echo json_encode($edit);
            exit();
        } else
        {
            echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
            exit();
        }
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    array
    **/
    public function list()
    {
        $params                                                                 =   $this->security->xss_clean($_POST);

        if ($params)
        {   
            $pageNumber                                                         =   $params['pageNumber'];
            $length                                                             =   $params['pageSize'];
            $start                                                              =   ($pageNumber - 1) * $length;
            $search                                                             =   $params['search'];
            $count_rows                                                         =   $this->_users_model->count_rows_users($search);
            $list                                                               =   $this->_users_model->display_list($length,$start,$search);
            $json_data                                                          =   array(
                "recordsTotal"                                                      =>  intval($count_rows['total']),
                "recordsFiltered"                                                   =>  intval($count_rows['total_filtered']),
                "data"                                                              => $list
            );
            echo json_encode($json_data);
            exit();
        }
        else
        {
            echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
            exit();
        }
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    void
    **/
    public function view_detail($id)
    {
        $data_user                                                              =   $this->_users_model->detail($id);
        if(empty($data_user['data']['photo']) || file_exists('resources/img/users/'. $data_user['data']['photo']) === FALSE)
        {
            $data_user['data']['photo']                                         =   'default.png';    
        }
        $this->_view->assign('data_user',$data_user);
        $this->_view->display('admin/users/detail.tpl');
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    void
    **/
    public function view_edit($id)
    {
        $data                                                                   =   array();
        $secundary_roles_ids                                                    =   array();
        $list_enterprises                                                       =   $this->_users_model->list_enterprises();
        $list_areas                                                             =   $this->_users_model->list_areas();
        $list_users                                                             =   $this->_users_model->list(0,0,'//');
        $list_roles                                                             =   $this->_users_model->list_roles();
        $list_occupations                                                       =   $this->_users_model->list_occupations();
        $list_countries                                                         =   $this->_users_model->list_countries();
        $user                                                                   =   $this->_users_model->detail($id);
        $data['enterprises']                                                    =   $list_enterprises['data'];
        $data['areas']                                                          =   $list_areas['data'];
        $data['users']                                                          =   $list_users['data'];
        $data['roles']                                                          =   $list_roles['data'];
        $data['occupations']                                                    =   $list_occupations['data'];  
        $data['countries']                                                      =   $list_countries['data']; 
        $data['user']                                                           =   $user['data'];
        
        foreach($data['user']['secundary_roles'] as $role)
        {
            $secundary_roles_ids[]                                              =   $role['id'];
        }

        $data['user']['secundary_roles_ids']                                    =   $secundary_roles_ids;

        if(empty($data['user']['photo']) || file_exists('resources/img/users/'. $data['user']['photo']) === FALSE)
        {
            $data['user']['photo']                                                 =   'default.png';    
        }

        $this->_view->assign('data', $data);
        $this->_view->display('admin/users/edit.tpl');
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    void
    **/
    public function view_trace($id)
    {
        $this->_view->assign('data_trace',$this->_users_model->trace_register($id));
        $this->_view->assign('path_trace',                                      site_url('users'));
        $this->_view->display('admin/users/trace.tpl');
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    array
    **/
    public function display()
    {
        $params                                                                 =   $this->security->xss_clean($_POST);

        if($params)
        {
            $status_user_display                                                =   $this->_users_model->display($params);
            echo json_encode($status_user_display);
            exit();

        } else
        {
            echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
            exit();
        }
    }

    /**
     * @author    Diego Pineda
     * @copyright 2023 Conectera
     * @since     v0.0
     * @param
     * @return    array
    **/
    public function udrop()
    {
        $param                                                                  =   $this->security->xss_clean($_POST);

        if ($param)
        {
            $udrop                                                              =   $this->_users_model->udrop($param);
            echo json_encode($udrop);
            exit();
        } else
        {
            echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
        }
    }

}