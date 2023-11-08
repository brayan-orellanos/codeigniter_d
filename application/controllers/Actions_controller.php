<?php

/**
 * @author    Brayan Orellanos
 * @copyright 2022 Conectera
 * @version   v 0.0
**/

defined('BASEPATH') or exit('No direct script access allowed');

include_once 'vendor/autoload.php';

class Actions_controller extends CI_Controller
{
    private $actions;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('actions_model', '_actions_model');
        $this->actions                                                          =   $this->_actions_model->actions_by_role($this->session->userdata['id_role'], 'ACTIONS');

        if ($this->session->userdata['id_role'] != "1")
        {
            if (in_array('ACTIONS', $this->session->userdata['actions']) == FALSE) 
            {
                header("Location: " . $this->session->userdata['initial_site']);
                exit();
            }
        }

        $this->_view->assign('act_drop',                                        in_array('UDROP', $this->actions));
        $this->_view->assign('act_add',                                         in_array('ADD', $this->actions));
        $this->_view->assign('act_edit',                                        in_array('EDIT', $this->actions));
        $this->_view->assign('act_view',                                        in_array('VIEW', $this->actions));
        $this->_view->assign('act_detail',                                      in_array('DETAILS', $this->actions));
        $this->_view->assign('act_trace',                                       in_array('TRACE', $this->actions));
        $this->_view->assign('act_display',                                     in_array('DISPLAY', $this->actions));

        $this->_view->assign('path_view',                                       site_url('actions/datalist'));
        $this->_view->assign('path_actions_new',                                site_url('actions/list'));
        $this->_view->assign('path_view_add',                                   site_url('actions/view_add'));
        $this->_view->assign('path_view_edit',                                  site_url('actions/view/edit'));
        $this->_view->assign('path_actions',                                    site_url('actions'));
        $this->_view->assign('path_add',                                        site_url('actions/add'));
        $this->_view->assign('path_drop',                                       site_url('actions/udrop'));
        $this->_view->assign('path_view_add_submodule',                         site_url('modules/view/add_submodule'));
        $this->_view->assign('path_view_edit_submodule',                        site_url('modules/view/edit_submodule'));
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param
     * @return    boolean
    **/
    public function view()
    {
        if ($this->actions != FALSE) 
        {
            /*if ($this->session->userdata['id_role'] != "1") 
            {
                $this->_actions_model->add_usability('USERS');
            }*/

            $this->_view->display('admin/actions/view.tpl');
        } 
        else 
        {
            header("Location: " . $this->session->userdata['initial_site']);
        }

        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param
     * @return    array json
    **/
    public function datalist()
    {
        if(in_array('VIEW', $this->actions))
        {
            $pageNumber                                                         =   $this->input->get('pageNumber');
            $length                                                             =   $this->input->get('pageSize');
            $start                                                              =   ($pageNumber - 1) * $length;
            $search                                                             =   $this->input->get('search');
            $count_rows                                                         =   $this->_actions_model->count_rows_actions($search);
            $all_rows                                                           =   $this->_actions_model->all_rows_actions($start, $length, $search, $this->actions);
            $json_data                                                          =   array(
                "recordsTotal"                                                      =>  intval($count_rows['total']),
                "recordsFiltered"                                                   =>  intval($count_rows['total_filtered']),
                "data"                                                              =>  $all_rows
            );
            echo json_encode($json_data);
            exit();
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }

            exit();
        }
    }

    // start prueba
    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params
     * @return    json array
    **/
    public function list()
    {
        $params                                                                 =   $this->security->xss_clean($_POST);

        if ($params)
        {
            $list                                                               =   $this->_actions_model->list($params);
            echo json_encode($list);
            exit();
        }
        else
        {
            echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
            exit();
        }
    }
    // end prueba

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param
     * @return    boolean
    **/
    public function view_add()
    {
        if(in_array('ADD', $this->actions))
        {
            $this->_view->assign('path_add',                                    site_url('actions/add'));
            $this->_view->display('admin/actions/add.tpl');
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }
        }

        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param
     * @return    boolean
    **/
    public function actions_view_add($id)
    {
        if(in_array('ADD', $this->actions))
        {
            $this->_view->assign('id_module',                                          $id);
            $this->_view->assign('path_add',                                    site_url('actions/add'));

            $this->_view->display('admin/actions/add.tpl');
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }
        }

        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param
     * @return    boolean
    **/
    public function editsub_actions_view_add($sub)
    {
        if(in_array('ADD', $this->actions))
        {
            
            $this->_view->assign('id_submodule',                                       $sub);
            $this->_view->assign('path_add',                                    site_url('actions/add'));

            $this->_view->display('admin/actions/add.tpl');
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }
        }

        exit();
    }

    /**
    * @author    juan sebastian ropero
    * @copyright 2022 Fabrica de Desarrollo
    * @since     v 2.0
    * @param
    * @return    array json
    **/
    public function view_add_actions($id_act_submodule)
    {
        if(in_array('ADD', $this->actions))
        {

            $this->_view->assign('id_act_submodule',                                   $id_act_submodule);
            $this->_view->assign('path_add',                                    site_url('actions/add'));

            $this->_view->display('admin/actions/add.tpl');
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }
        }
        exit();
    }

    /**
    * @author    juan sebastian ropero
    * @copyright 2022 Fabrica de Desarrollo
    * @since     v 2.0
    * @param
    * @return    array json
    **/
    public function editper_view_add_actions($edit_id_act_sub)
    {
        if(in_array('ADD', $this->actions))
        {

            $this->_view->assign('edit_id_act_sub',                              $edit_id_act_sub);
            $this->_view->assign('path_add',                                    site_url('actions/add'));

            $this->_view->display('admin/actions/add.tpl');
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }
        }
        exit();
    }


    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params
     * @return    json array
    **/
    public function add()
    {
        if(in_array('ADD', $this->actions))
        {
            $params                                                             =   $this->security->xss_clean($_POST);

            if ($params)
            {
                $exist_action                                                   =   $this->_actions_model->exist_action($params);

                if ($exist_action['value'])
                {
                    $add                                                        =   $this->_actions_model->add($params, $this->actions);
                    echo json_encode($add);
                    exit();
                }
                else
                {
                    echo json_encode($exist_action);
                    exit();
                }
            }
            else
            {
                if ($this->input->method(TRUE) == 'GET')
                {
                    header("Location: " . site_url('actions'));
                }
                else
                {
                    echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
                }

                exit();
            }
        } 
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }

            exit();
        } 
    }

    /** 
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     int $id  
     * @return    array
    **/
    public function view_edit($id)
    {
        if(in_array('EDIT', $this->actions))
        {
            if ($id)
            {
                $exist_id                                                       =   $this->_actions_model->exist_id($id, 'dtm_actions');

                if($exist_id['value'])
                { 
                    $this->_view->assign('data_action',                         $this->_actions_model->detail($id, 'detail'));
                    $this->_view->assign('path_edit',                           site_url('actions/edit'));
                    $this->_view->display('admin/actions/edit.tpl');
                    exit();
                }
                else 
                {
                    header("Location: " . site_url('actions'));
                }
            }
            else
            {
                if ($this->input->method(TRUE) == 'GET')
                {
                    header("Location: " . site_url('actions'));
                }
                else
                {
                    echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
                }
            }
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }
        }

        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params
     * @return    json array
    **/
    public function edit()
    {
        if(in_array('EDIT', $this->actions))
        {
            $params                                                             =   $this->security->xss_clean($_POST);

            if ($params)
            {
                $edit                                                           =   $this->_actions_model->edit($params, $this->actions);
                echo json_encode($edit);
                exit();
            }
            else
            {
                if ($this->input->method(TRUE) == 'GET')
                {
                    header("Location: " . site_url('actions'));
                }
                else
                {
                    echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
                }

                exit();
            }
        } 
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }

            exit();
        } 
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params
     * @return    json array
    **/
    public function udrop()
    {
        if(in_array('UDROP', $this->actions))
        {
            $param                                                              =   $this->security->xss_clean($_POST);

            if ($param)
            {
                $udrop                                                          =   $this->_actions_model->udrop($param);
                echo json_encode($udrop);
                exit();
            }
            else
            {
                if ($this->input->method(TRUE) == 'GET')
                {
                    header("Location: " . site_url('actions'));
                }
                else
                {
                    echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
                }

                exit();
            }
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }

            exit();
        }
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     int $id
     * @return    json array
    **/
    public function view_trace($id)
    {
        if(in_array('TRACE', $this->actions))
        {
            if ($id)
            {
                $exist_id                                                       =   $this->_actions_model->exist_id($id, 'dtm_actions');

                if($exist_id['value'])
                { 
                    $this->_view->assign('data_trace',                          $this->_actions_model->trace_register($id));
                    $this->_view->assign('path_trace',                          site_url('actions'));
                    $this->_view->display('trace.tpl');
                    exit();
                } 
                else 
                {
                    header("Location: " . site_url('actions'));
                }
            }
            else
            {
                if ($this->input->method(TRUE) == 'GET')
                {
                    header("Location: " . site_url('actions'));
                }
                else
                {
                    echo json_encode(array('data'=> FALSE, 'message' => 'Los campos enviados no corresponden a los necesarios para ejecutar esta solicitud.'));
                }

                exit();
            }
        }
        else
        {
            if ($this->input->method(TRUE) == 'GET')
            {
                header("Location: " . site_url('actions'));
            }
            else
            {
                echo json_encode(array('data'=> FALSE, 'message' => 'No cuentas con los permisos necesarios para ejecutar esta solicitud.'));
            }

            exit();
        }
    }
}