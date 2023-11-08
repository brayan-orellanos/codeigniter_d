<?php
/**
 * @author    Brayan Orellanos
 * @copyright Conectera
 * @version   v 0.0
**/

defined('BASEPATH') or exit('No direct script access allowed');


class Actions_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright Conectera
     * @since     v0.0
     * @param     int $role, varchar $submodule
     * @return    array
    **/
    public function actions_by_role($role, $submodule)
    {
        return $this->_datamax_model->actions_by_role($role, $submodule);
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright Conectera
     * @since     v0.0
     * @param     string $submodule
     * @return    array | boolean
    **/
    public function get_breadcrumb($submodule)
    {
        return $this->_datamax_model->get_breadcrumb($submodule);
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright Conectera
     * @since     v0.0
     * @param     string $search
     * @return    array $result
    **/
    public function count_rows_actions($search)
    {
        $result                                                                 =   array();
        $this->db->from('dtm_actions');
        $this->db->where('flag_drop', 0);

        $total                                                                  =   $this->db->count_all_results();

        if (!empty($search)) 
        {
            $this->db->select('name_es');
            $this->db->where('flag_drop', 0);
            $this->db->group_start();
            $this->db->like('name_es', $search);
            $this->db->or_like('DATE_FORMAT(date_insert, \'%d/%m/%Y\')', $search);
            $this->db->group_end();
            $this->db->from('dtm_actions');

            $total_filtered                                                     =   $this->db->count_all_results();
        } else 
        {
            $total_filtered                                                     =   $total;
        }

        $result['total']                                                        =   $total;
        $result['total_filtered']                                               =   $total_filtered;
        return $result;
        exit();
    }


    /**
     * @author    Brayan Orellanos
     * @copyright Conectera
     * @since     v0.0
     * @param     int $start, $length; varchar $search array $actions
     * @return    array $result
    **/
    public function all_rows_actions($start, $length, $search, $actions)
    {
        $result                                                                 =   array();
        $this->db->select('dtm_actions.id, dtm_actions.name, dtm_actions.name_es, dtm_actions.icon, DATE_FORMAT(dtm_actions.date_insert, "%d-%m-%Y %h:%i %p") AS date_insert, CONCAT(dtm_users.name," ", dtm_users.lastname) AS name_user');
        $this->db->join('dtm_users', 'dtm_actions.user_insert = dtm_users.id');
        $this->db->where('dtm_actions.flag_drop', 0);
  

        if (!empty($search)) 
        {
            $this->db->group_start();
            $this->db->like('dtm_actions.name_es', $search);
            $this->db->or_like('dtm_actions.name', $search);
            $this->db->or_like('CONCAT(dtm_users.name," ", dtm_users.lastname)', $search);
            $this->db->group_end();
        }

        $this->db->order_by('name', 'ASC');
        $this->db->limit($length, $start);

        $query                                                                  =   $this->db->get('dtm_actions');

        if ($query->num_rows() > 0) 
        {
            $list_actions                                                       =   array();
            
            foreach ($query->result_array() as $key => $row) 
            {
                $content                                                        =   '<div class="col-12 card-list">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="icon_module mr-3">
                                <i class="'. $row['icon'] .' icon-card"></i>
                            </div>
                            <div class="ft-left">
                                <p class="titles mg-y-5">' . ucfirst(strtolower($row['name']))  . '</p>
                                <p class="subtitles">' . ucfirst(strtolower($row['name_es'])) . '</p>
                            </div>
                        </div>
                        <div class="col-lg-7 mg-b-5 mg-lg-b-0 action_border mg-lg-l-0 mg-lg-r-0 mg-l-15 mg-r-15">
                            <h6 class="mg-b-10">Creado por</h6>
                            <p class="titles mg-0">'. $row['name_user'] .'</p>
                        </div>
                        <div class="col-1 d-flex justify-content-end align-items-end mg-l-auto">';

                            if (in_array('EDIT', $actions) || in_array('DETAILS', $actions) || in_array('UDROP', $actions) || in_array('TRACE', $actions) || in_array('VIEW', $actions)) 
                            {
                                $content                                        .= '<div class="text-center">
                                    <div class="dropdown dropdown-table wd-25">
                                        <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                                            <img class="wd-20" src="' . RESOURCES . 'img/options_icon.svg">
                                        </a>
                                        <div class="dropdown-menu pd-0-force">
                                            <ul class="list-unstyled user-profile-nav">';

                                                if (in_array('EDIT', $actions)) 
                                                {
                                                    $content                    .=  '<li><a href="actions/view/edit/' . $row['id'] . '" class="edit-row pd-x-5-force" data-id="' . $row['id'] . '"><i class="fas fa-pencil-alt"></i> Editar</a></li>';
                                                }
                                                if (in_array('UDROP', $actions)) 
                                                {
                                                    $content                    .=  '<li><a href="javascript:void(0)" class="remove-row pd-x-5-force" data-id="' . $row['id'] . '"><i class="fas fa-trash-alt"></i> Eliminar</a></li>';
                                                }
                                                if (in_array('TRACE', $actions)) 
                                                {
                                                    $content                    .=  '<li><a href="' . site_url('actions/view/trace/' . $row['id'] . '') . '" class=" pd-x-5-force"><i class="fas fa-history"></i> Trazabilidad</a></li>';
                                                }

                                            $content                            .=  '</ul>
                                        </div>
                                    </div>
                                </div>';
                            }

                    $content                                                    .=  '</div>  
                    </div>                              
                </div>';
                
                $list_actions[]                                                 =   $content;
            }

            $result                                                             =   $list_actions;
        }

        return $result;
        exit();
    }

    // start prueba
    /**
     * @author    
     * @copyright Conectera
     * @since     v0.0
     * @param     int $id, string $action
     * @return    array $result
    **/
    public function list($search)
    {
        if (isset($search['name']) && ($search['name'] != ""))
        {
            $result                                                                 =   array();
    
            $this->db->select('dtm_actions.id, dtm_actions.name, dtm_actions.name_es, dtm_actions.icon, DATE_FORMAT(dtm_actions.date_insert, "%d-%m-%Y %h:%i %p") AS date_insert, CONCAT(dtm_users.name," ", dtm_users.lastname) AS name_user');
            $this->db->join('dtm_users', 'dtm_actions.user_insert = dtm_users.id');
            $this->db->where('dtm_actions.flag_drop', 0);
      
            if (!empty($search['name'])) 
            {
                $this->db->group_start();
                $this->db->like('dtm_actions.name_es', $search['name']);
                $this->db->or_like('dtm_actions.name', $search['name']);
                $this->db->or_like('CONCAT(dtm_users.name," ", dtm_users.lastname)', $search['name']);
                $this->db->group_end();
            }
    
            $this->db->order_by('name', 'ASC');
    
            $query                                                              =   $this->db->get('dtm_actions');
    
            if ($query->num_rows() > 0)
            {
                $list_action                                                    =   $query->result_array();
    
                $result['data']                                                 =   $list_action;
                $result['message']                                              =   FALSE;
            }
            else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'No se han encontrado datos relacionados con la acción.';
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'La clave name y su valor no ha sido proporcionada.';
        }

        return $result;
        exit();
    }
    // end prueba

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params
     * @return    array $string
    **/
    public function exist_action($params)
    {
        $result                                                                 =   array();
        $this->db->select('name');
        $this->db->where('flag_drop', 0);
        $this->db->where('name', trim(mb_strtoupper($params['name'])));

        $query                                                                  =   $this->db->get('dtm_actions');

        if (count($query->result_array()) > 0) 
        {
            $result['value']                                                    =   FALSE;
            $result['message']                                                  =   'Ya existe una acción con ese nombre';
        } else 
        {
            $result['value']                                                    =   TRUE;
            $result['message']                                                  =   FALSE;
        }

        return $result;
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params, array $actions  
     * @return    array $result
    **/
    public function add($params, $actions)
    {
        $result                                                                 =   array();
        $this->form_validation->set_rules('name', 'Nombre', 'required');
        $this->form_validation->set_rules('description', 'Descripcion', 'required');
        $this->form_validation->set_rules('icon', 'Icono', 'required');

        if ($this->form_validation->run()) 
        {
            $data['name']                                                       =   mb_strtoupper($this->_datamax_model->accents($params['name']));
            $data['icon']                                                       =   mb_strtolower($this->_datamax_model->accents($params['icon']));
            $data['name_es']                                                    =   ucfirst(mb_strtolower($this->_datamax_model->accents($params['description'])));
            $data['user_insert']                                                =   $this->session->userdata['id_user'];

            $this->db->trans_start();
                $result['id']                                                   =   $this->_datamax_model->insert_data($data, 'dtm_actions');

                $data_hcal['id']                                                =   intval($result['id']);
                $data_hcal['name']                                              =   mb_strtoupper($this->_datamax_model->accents($params['name']));
                $data_hcal['icon']                                              =   mb_strtolower($this->_datamax_model->accents($params['icon']));
                $data_hcal['name_es']                                           =   ucfirst(mb_strtolower($this->_datamax_model->accents($params['description'])));
                $data_hcal['action']                                            =   'ADD';
                $data_hcal['user_update']                                       =   $this->session->userdata['id_user'];

                $this->_datamax_model->insert_data($data_hcal, 'dtm_actions_hcal');
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) 
            {
                if($params['id_submodule']!='')
                {
                    $this->db->select('id, name');
                    $this->db->where('id',intval($params['id_submodule']));

                    $query                                                      =   $this->db->get('dtm_submodules');

                    if ($query->num_rows() > 0)
                    {
                        $row                                                    =   $query->row_array();

                        $data2['action']                                        =   $result['id'];  
                        $data2['name_action']                                   =   $data['name'];
                        $data2['submodule']                                     =   intval($row['id']);
                        $data2['name_submodule']                                =   mb_strtoupper($this->_datamax_model->accents($row['name']));
                        $data2['user_insert']                                   =   $this->session->userdata['id_user'];

                        $this->_datamax_model->insert_data($data2, 'dtm_actions_submodule');
                    }
                }else if ($params['id_act_submodule']!='')
                {
                    $this->db->select('id, name');
                    $this->db->where('id',intval($params['id_act_submodule']));

                    $query                                                      =   $this->db->get('dtm_submodules');

                    if ($query->num_rows() > 0)
                    {
                        $row                                                    =   $query->row_array();

                        $data2['action']                                        =   $result['id'];  
                        $data2['name_action']                                   =   $data['name'];
                        $data2['submodule']                                     =   intval($row['id']);
                        $data2['name_submodule']                                =   mb_strtoupper($this->_datamax_model->accents($row['name']));
                        $data2['user_insert']                                   =   $this->session->userdata['id_user'];

                        $this->_datamax_model->insert_data($data2, 'dtm_actions_submodule');

                    }
                }

                $result['value']                                                =   TRUE;
                $result['message']                                              =   'acción agregada con éxito!';
                
            } else 
            {
                $result['value']                                                =   FALSE;
                $result['message']                                              =   'Hubo un problema al guardar la acción.';
            }
        }
        else
        {
            $result['value']                                                    =   FALSE;
            $result['message']                                                  =   'Completa todos los campos.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright Conectera
     * @since     v0.0
     * @param     int $id, string $action
     * @return    array $result
    **/
    public function detail($id, $action)
    {
        $result                                                                 =   array();
        $this->db->select('id, name, name_es, icon');
        $this->db->where('flag_drop', 0);
        $this->db->where('id', intval($id));

        $query                                                                  =   $this->db->get('dtm_actions');

        if ($query->num_rows() > 0)
        {
            if ($action == 'detail')
            {
                $list_action                                                    =   $query->row_array();
            }

            $result['data']                                                     =   $list_action;
            $result['message']                                                  =   FALSE;
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'No se han encontrado datos relacionados con la acción.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright conectera
     * @since     v0.0
     * @param     string $id, string $table
     * @return    boolean
    **/
    public function exist_id ($id, $table) 
    {
        $result                                                                 =   array();

        if($id)
        {
            $this->db->select('*');
            $this->db->where('id', intval($id));
            $this->db->where('flag_drop', 0);

            $query                                                              =   $this->db->get($table);

            if(count($query->result_array()) > 0)
            {
                $result['value']                                                =   TRUE;    
            }
            else
            {
                $result['value']                                                =   FALSE;
            }
        }

        return $result;
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     array $params, array $actions  
     * @return    array $result
    **/
    public function edit($params, $actions)
    {
        $result                                                                 =   array();
        $this->form_validation->set_rules('description', 'Descripcion', 'required');
        $this->form_validation->set_rules('icon', 'Icono', 'required');

        if ($this->form_validation->run()) 
        {
            $this->db->select('*');
            $this->db->where('id', intval($params['id']));

            $query                                                              =   $this->db->get('dtm_actions');

            $row                                                                =   $query->row_array();
            $data['icon']                                                       =   mb_strtolower($this->_datamax_model->accents($params['icon']));
            $data['name_es']                                                    =   ucfirst(mb_strtolower($this->_datamax_model->accents($params['description'])));
            $data['user_update']                                                =   $this->session->userdata['id_user'];
            $data['date_update']                                                =   date("Y-m-d H:i:s");

            $this->db->where('id', $params['id']);
            $this->db->trans_start();
                $this->db->update('dtm_actions', $data);

                if($row)
                {
                    if($row['name_es'] != $data['name_es'] or $row['icon'] != $data['icon'])
                    {
                        $data_hcal['id']                                        =   intval($row['id']);
                        $data_hcal['name']                                      =   mb_strtoupper($this->_datamax_model->accents($row['name']));
                        $data_hcal['icon']                                      =   mb_strtolower($this->_datamax_model->accents($row['icon']));
                        $data_hcal['name_es']                                   =   ucfirst(mb_strtolower($this->_datamax_model->accents($row['name_es'])));
                        $data_hcal['action']                                    =   'EDIT';
                        $data_hcal['user_update']                               =   $this->session->userdata['id_user'];
                        
                        $this->_datamax_model->insert_data($data_hcal, 'dtm_actions_hcal');
                    }
                }  

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) 
            {
                $result['value']                                                =   TRUE;
                $result['message']                                              =   'acción actualizada con éxito!';
            } else
            {
                $result['value']                                                =   FALSE;
                $result['message']                                              =   'Hubo un problema al actualizar la acción.';
            }
        }
        else
        {
            $result['value']                                                    =   FALSE;
            $result['message']                                                  =   'Completa todos los campos.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright 2022 Conectera
     * @since     v0.0
     * @param     arraay $param
     * @return    array $result
    **/
    public function udrop($param)
    {
        $result                                                                 =   array();

        if ($param) 
        {
            $this->db->select('*');
            $this->db->where('id', $param['id']);

            $query                                                              =   $this->db->get('dtm_actions');

            $row                                                                =   $query->row_array();
            $data['flag_drop']                                                  =   1;

            $this->db->where('id', intval($param['id']));
            $this->db->trans_start();
                $this->db->update('dtm_actions', $data);

                $data_hcal['id']                                                =   $row['id'];    
                $data_hcal['name']                                              =   $row['name'];
                $data_hcal['name_es']                                           =   $row['name_es'];
                $data_hcal['icon']                                              =   $row['icon'];  
                $data_hcal['flag_drop']                                         =   1;      
                $data_hcal['action']                                            =   'UDROP';  
                $data_hcal['user_update']                                       =   $this->session->userdata['id_user'];

                $this->_datamax_model->insert_data($data_hcal, 'dtm_actions_hcal');

                $this->db->where('submodule', $param['id']);
                $this->db->delete('dtm_permissions');
                $this->db->where('submodule', $param['id']);
                $this->db->delete('dtm_actions_submodule');
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE)
            {
                $result['value']                                                =   TRUE;
                $result['message']                                              =   'acción eliminada con éxito!';    
            }
            else
            {
                $result['value']                                                =   FALSE;
                $result['message']                                              =   'Hubo un problema al eliminar la acción.';    
            }
        } else 
        {
            $result['value']                                                    =   FALSE;
            $result['message']                                                  =   'Hubo un problema al eliminar la acción.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Brayan Orellanos
     * @copyright conectera
     * @since     v0.0
     * @param     numeric $id
     * @return    array $result
    **/
    public function trace_register($id)
    {
        $result                                                                 =   array();
        $result['html']                                                         =   '';
        $trace_global                                                           =   $this->_datamax_model->global_trace_register_new('dtm_actions_hcal', 'id', $id, 'acción');

        if ($trace_global['value']) 
        {
            $result['html']                                                     .=  $trace_global['history'];
        }

        return $result;
        exit();
    }
}