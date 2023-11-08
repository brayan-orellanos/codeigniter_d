<?php
/**
 * @author    Brayan Orellanos
 * @copyright Conectera
 * @version   v 0.0
**/

defined('BASEPATH') or exit('No direct script access allowed');


class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     string $search
     * @return    array $result
    **/
    public function list($length,$start,$search)
    {
        if (isset($search))
        {
            $search_explode                                                     =   explode('/',$search);
            $filter_users_status                                                =   $search_explode[0];
            $filter_users_enterprises                                           =   $search_explode[1];
            $filter_search_users                                                =   $search_explode[2];
            $result                                                             =   array();
    
            $this->db->select('dtm_users.*,dtm_enterprises.name as name_enterprise,dtm_enterprises.logo as logo_enterprise, dtm_roles.name as name_role, dtm_areas.name as name_area, dtm_occupations.name as name_occupation')->from('dtm_users');
            $this->db->join('dtm_roles', 'dtm_roles.id = dtm_users.role');
            $this->db->join('dtm_enterprises', 'dtm_enterprises.id = dtm_users.enterprise');
            $this->db->join('dtm_areas', 'dtm_areas.id = dtm_users.area');
            $this->db->join('dtm_occupations', 'dtm_occupations.id = dtm_users.occupation');
            $this->db->group_start();
            $this->db->like('dtm_users.name',$filter_search_users);
            $this->db->or_like('dtm_users.lastname',$filter_search_users);
            $this->db->or_like('dtm_users.document_type',$filter_search_users);
            $this->db->or_like('dtm_users.document_number',$filter_search_users);
            $this->db->or_like('dtm_occupations.name',$filter_search_users);
            $this->db->or_like('dtm_areas.name',$filter_search_users);
            $this->db->or_like('dtm_users.country_indicator',$filter_search_users);
            $this->db->or_like('dtm_users.cell_phone_number',$filter_search_users);
            $this->db->or_like('dtm_users.email',$filter_search_users);
            $this->db->group_end();
            if(strlen($filter_users_status) > 0)
            {
                $this->db->where_in('dtm_users.flag_block',$filter_users_status);
            }
            if(strlen($filter_users_enterprises) > 0)
            {
                $this->db->where_in('dtm_users.enterprise',$filter_users_enterprises);
            }
            $this->db->where('dtm_users.flag_drop',0);
            $this->db->order_by('dtm_users.name', 'ASC');
            if($length > 0)
            {
                $this->db->limit($length, $start);
            }
            $query                                                              =   $this->db->get();

            if($query->num_rows() > 0) 
            {
                $list_users                                                     =   $query->result_array();

                foreach($list_users as &$user) {
                    $this->db->select('dtm_roles.*')->from('dtm_roles');
                    $this->db->join('dtm_users_roles','dtm_users_roles.id_role = dtm_roles.id');
                    $this->db->where('dtm_users_roles.id_user',intval($user['id']));
                    $query_roles_by_user                                        =   $this->db->get();
                    $user['secundary_roles']                                    =   $query_roles_by_user->result_array();
                }

                $result['data']                                                 =   $list_users;
                $result['message']                                              =   FALSE;
            } else {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'No se han encontrado datos relacionados con la búsqueda.';
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'La clave search y su valor no ha sido proporcionada.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     string $search
     * @return    array $result
    **/
    public function add($params)
    {
        $result                                                                 =   array();

        if(isset($params))
        {
            $data['name']                                                       =   $params['name'];
            $data['lastname']                                                   =   $params['lastname'];
            $data['document_type']                                              =   $params['document_type'];
            $data['document_number']                                            =   $params['document_number'];
            $data['email']                                                      =   $params['email'];
            $data['cell_phone_number']                                          =   $params['cell_phone_number'];
            $data['country_indicator']                                          =   $params['country_indicator'];
            $data['enterprise']                                                 =   $params['enterprise'];
            $data['area']                                                       =   $params['area'];
            $data['occupation']                                                 =   $params['occupation'];
            $data['password']                                                   =   'password';
            $data['role']                                                       =   $params['role'];
            $data['photo']                                                      =   'default.png';
            $data['user_insert']                                                =   $params['user_insert'];
            $data['date_insert']                                                =   date('Y-m-d H:i:s');

            $id_user                                                            =   $this->_datamax_model->insert_data($data, 'dtm_users');

            $status_image = $this->_datamax_model->upload_image(UPLOAD_ERR_OK,$_FILES['avatar_file_resize']['name'],'resources/img/users/',$_FILES['avatar_file_resize']['size'],$_FILES['avatar_file_resize']['tmp_name'],600,600,false,false,$id_user);

            $img_explode = explode('.', $_FILES['avatar_file_resize']['name']); 
            $extension_img = end($img_explode);

            $this->_datamax_model->update_data(array('photo' => $id_user.'.'.$extension_img, 'id' => $id_user),'id','dtm_users');

            if($id_user)
            {
                $roles_secundary_explode                                        =   explode(',',$params['roles_secundary']);
                foreach($roles_secundary_explode as $role)
                {
                    $data_secundary_role['id_user']                             =   $id_user;
                    $data_secundary_role['id_role']                             =   $role;
                    $data_secundary_role['user_insert']                         =   $params['user_insert'];
                    $data_secundary_role['date_insert']                         =   date('Y-m-d H:i:s');

                    $this->_datamax_model->insert_data($data_secundary_role, 'dtm_users_roles');
                    
                }
                
                $this->db->select('id,name,lastname,document_type,document_number,email,cell_phone_number,country_indicator,enterprise,area,occupation,password,role,photo,date_keepalive,hash_security,flag_block,flag_drop,flag_security,flag_valid_mail')->from('dtm_users');
                $this->db->where('id',$id_user);
                $query                                              =   $this->db->get();
                $result_user                                        =   $query->row_array();
                $result_user['action']                              =   'ADD';
                $result_user['user_update']                         =   $data['user_insert'];
                $result_user['date_update']                         =   $data['date_insert'];

                if($this->_datamax_model->insert_data($result_user,'dtm_users_hcal'))
                {
                    $result['data']                                         =   TRUE;
                    $result['message']                                      =   'Usuario registrado correctamente';
                } else
                {
                    $result['data']                                         =   FALSE;
                    $result['message']                                      =   'No se pudo realizar la asignación de los roles secundarios';
                }
            } else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'No se pudo realizar la creación del usuario';
            }

        } else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Completa todos los campos.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     string $search
     * @return    array $result
    **/
    public function edit($params)
    {
        $result                                                                 =   array();

        if(isset($params))
        {
            $data['id']                                                         =   $params['id'];
            $data['name']                                                       =   $params['name'];
            $data['lastname']                                                   =   $params['lastname'];
            $data['document_type']                                              =   $params['document_type'];
            $data['document_number']                                            =   $params['document_number'];
            $data['email']                                                      =   $params['email'];
            $data['cell_phone_number']                                          =   $params['cell_phone_number'];
            $data['country_indicator']                                          =   $params['country_indicator'];
            $data['enterprise']                                                 =   $params['enterprise'];
            $data['area']                                                       =   $params['area'];
            $data['occupation']                                                 =   $params['occupation'];
            $data['password']                                                   =   'password';
            $data['role']                                                       =   $params['role'];
            $data['user_update']                                                =   $params['user_update'];
            $data['date_update']                                                =   date('Y-m-d H:i:s');

            if($this->_datamax_model->update_data($data,'id','dtm_users'))
            {
                if(strlen($params['avatar_img']) > 0)
                {
                    $img_explode = explode('.', $_FILES['avatar_file_resize']['name']); 
                    $extension_img = end($img_explode);
                    $status_image = $this->_datamax_model->upload_image(UPLOAD_ERR_OK,$_FILES['avatar_file_resize']['name'],'resources/img/users/',$_FILES['avatar_file_resize']['size'],$_FILES['avatar_file_resize']['tmp_name'],600,600,false,false,$data['id']);

                    $this->_datamax_model->update_data(array('photo' => $data['id'].'.'.$extension_img, 'id' => $data['id']),'id','dtm_users');
                }

                if($this->db->delete('dtm_users_roles',array('id_user' => $data['id'])))
                {
                    $roles_secundary_explode                                    =   explode(',',$params['roles_secundary']);
                    foreach($roles_secundary_explode as $role)
                    {
                        $data_secundary_role['id_user']                         =   $data['id'];
                        $data_secundary_role['id_role']                         =   $role;
                        $data_secundary_role['user_insert']                     =   $params['user_update'];
                        $data_secundary_role['date_insert']                     =   date('Y-m-d H:i:s');

                        $this->_datamax_model->insert_data($data_secundary_role, 'dtm_users_roles');
                    }
                    
                    $this->db->select('id,name,lastname,document_type,document_number,email,cell_phone_number,country_indicator,enterprise,area,occupation,password,role,photo,date_keepalive,hash_security,flag_block,flag_drop,flag_security,flag_valid_mail')->from('dtm_users');
                    $this->db->where('id',$data['id']);
                    $query                                              =   $this->db->get();
                    $result_user                                        =   $query->row_array();
                    $result_user['action']                              =   'EDIT';
                    $result_user['user_update']                         =   $data['user_update'];
                    $result_user['date_update']                         =   $data['date_update'];

                    if($this->_datamax_model->insert_data($result_user,'dtm_users_hcal'))
                    {
                        $result['data']                                 =   TRUE;
                        $result['message']                              =   'Usuario actualizado correctamente';
                    } else
                    {
                        $result['data']                                 =   TRUE;
                        $result['message']                              =   'No se pudo realizar el registro de hcal';
                    }

                } else
                {
                    $result['data']                                             =   FALSE;
                    $result['message']                                          =   'No se pudo realizar la actulización de los roles secundarios';
                }
                
            } else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'No se pudo realizar la actualización del usuario';
            }

        } else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Completa todos los campos.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     string $search
     * @return    array $result
    **/
    public function display_list($length,$start,$search)
    {
        $list_users                                                             =   $this->list($length,$start,$search);
        $list_users_content                                                     =   array();

        if($list_users['data'] !== FALSE)
        {
            foreach($list_users['data'] as $user)
            {
                $avatar_photo                                                   =   $user['photo'];
                if(empty($user['photo']) || file_exists('resources/img/users/'. $user['photo']) === FALSE)
                {
                    $avatar_photo                                               =   'default.png';    
                }  
                
                $content                                                            =   '<div class="card-user">
                                                                                            <div class="content-icon-list">
                                                                                                <div>
                                                                                                    <img width="40" height="40" class="avatar" src="resources/img/users/'. $avatar_photo .'" alt="logo-user" />
                                                                                                </div>
                                                                                                <div>
                                                                                                    <p class="text fontWeight-600 fontSize-13">'. strtoupper($user['name']). ' ' . strtoupper($user['lastname']) .'</p>
                                                                                                    <p class="text fontSize-13">'. $user['document_type'] .' '. $user['document_number'] .'</p>
                                                                                                    <p class="text-link fontSize-12 fontStyle-Italic mb-0">'.$user['name_occupation'].'</p>
                                                                                                    <p class="text-link fontSize-12 fontStyle-Italic mb-0">'.$user['name_area'].'</p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p class="text p-top-5">
                                                                                                    <i class="px-2 fa-solid fa-mobile-screen icon-user-info"></i>
                                                                                                    (+'.$user['country_indicator'].') '. $user['cell_phone_number'].'</p>
                                                                                                <p class="text p-top-5">
                                                                                                    <i class="px-2 fa-solid fa-envelope icon-user-info"></i>
                                                                                                    '.$user['email'].'
                                                                                                </p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p class="text fontWeight-600">Empresa</p>
                                                                                                <div class="container-section-company-user">
                                                                                                    <img width="50" height="50" class="logo-company" src="resources/img/enterprises/'.$user['logo_enterprise'].'" alt="logo-company" />
                                                                                                    <p class="text center">'.$user['name_enterprise'].'</p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p class="text fontWeight-600">Roles</p>
                                                                                                <ul class="list-roles-user">
                                                                                                    <li>'.$user['name_role'].'</li>
                                                                                                </ul>
                                                                                                <p class="text-small">('.count($user['secundary_roles']).' roles más)</p>
                                                                                            </div>
                                                                                            <div class="container-visualization-card">
                                                                                                <div class="d-flex justify-content-end">
                                                                                                    <div class="d-inline-flex gap-10">';
                                                                                                        if($user['flag_block'] == 0) 
                                                                                                        {
                                                                                                            $content .= '<p id="label_status_user_'.$user['id'].'" class="label-switch-on">Trabajador Activo</p>
                                                                                                            <label class="switch">
                                                                                                                <input data-index='.$user['id'].' class="switch-status-user-id" checked="checked" type="checkbox" />
                                                                                                                <span class="slider round"></span>
                                                                                                            </label>';
                                                                                                        } else
                                                                                                        {
                                                                                                            $content .= '<p id="label_status_user_'.$user['id'].'" class="label-switch-off">Trabajador Inactivo</p>
                                                                                                            <label class="switch">
                                                                                                                <input data-index='.$user['id'].' class="switch-status-user-id" type="checkbox" />
                                                                                                                <span class="slider round"></span>
                                                                                                            </label>';
                                                                                                        }
                $content .=                                                                           '</div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-end container-icon-dropdown">
                                                                                                    <img data-index="'.$user['id'].'" class="display-dropdown icon-visualization display-dropdown-id"
                                                                                                        src="resources/img/visualization.png" alt="visualization-card" width="14" height="14">
                                                                                                    <div id="dropdown_'.$user['id'].'" class="content-options-visualization">
                                                                                                        <a href="users/view/detail/'.$user['id'].'">
                                                                                                            <i class="px-1 fa-solid fa-bullseye"></i>
                                                                                                            Visualizar
                                                                                                        </a>
                                                                                                        <a href="users/view/edit/'.$user['id'].'">
                                                                                                            <i class="px-1 fa-solid fa-pencil"></i>
                                                                                                            Editar
                                                                                                        </a>
                                                                                                        <a data-index="'.$user['id'].'" class="udrop-user-id">
                                                                                                            <i class="px-1 fa-solid fa-trash-can"></i>
                                                                                                            Eliminar
                                                                                                        </a>
                                                                                                        <a href="users/view/trace/'.$user['id'].'">
                                                                                                            <i class="px-1 fa-solid fa-clock-rotate-left"></i>
                                                                                                            Trazabilidad
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>';
                
                $list_users_content[]                                               = $content;
            }
        }
        return $list_users_content;
        exit();
        
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     string $search
     * @return    array $result
    **/
    public function count_rows_users($search)
    {
        $result                                                                 =   array();
        $this->db->from('dtm_users');
        $this->db->where('flag_drop', 0);

        $total                                                                  =   $this->db->count_all_results();

        if (!empty($search)) 
        {
            $this->db->select('name');
            $this->db->where('flag_drop', 0);
            $this->db->from('dtm_users');

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
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     int $id
     * @return    array $result
    **/
    public function detail($id)
    {
        if (isset($id))
        {
            $result                                                             =   array();
    
            $this->db->select('dtm_users.*,dtm_enterprises.name as name_enterprise,dtm_enterprises.logo as logo_enterprise, dtm_roles.name as name_role, dtm_roles.date_insert as role_date_insert, dtm_areas.name as name_area, dtm_occupations.name as name_occupation')->from('dtm_users');
            $this->db->join('dtm_roles', 'dtm_roles.id = dtm_users.role');
            $this->db->join('dtm_enterprises', 'dtm_enterprises.id = dtm_users.enterprise');
            $this->db->join('dtm_areas', 'dtm_areas.id = dtm_users.area');
            $this->db->join('dtm_occupations', 'dtm_occupations.id = dtm_users.occupation');
            $this->db->where('dtm_users.id',intval($id));
            $query                                                              =   $this->db->get();

            if($query->num_rows() > 0) {
                $user                                                           =   $query->row_array();
                $this->db->select('dtm_roles.*')->from('dtm_roles');
                $this->db->join('dtm_users_roles','dtm_users_roles.id_role = dtm_roles.id');
                $this->db->where('dtm_users_roles.id_user',intval($id));
                $query_roles_by_user                                            =   $this->db->get();
                $user['secundary_roles']                                        =   $query_roles_by_user->result_array();
                $result['data']                                                 =   $user;
                $result['message']                                              =   FALSE;
            } else {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'No se han encontrado datos relacionados con la búsqueda.';
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'La clave id y su valor no ha sido proporcionada.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     int $id
     * @return    array $result
    **/
    public function display($params)
    {
        $result                                                                 =   array();

        $data['flag_block']                                                     =   $params['display'];

        if($params['id'] > 0)
        {
            $this->db->where('id',$params['id']);
        }
        
        if($this->db->update('dtm_users',$data))
        {
            if($params['id'] > 0)
            {
                $this->db->select('id,name,lastname,document_type,document_number,email,cell_phone_number,country_indicator,enterprise,area,occupation,password,role,photo,date_keepalive,hash_security,flag_block,flag_drop,flag_security,flag_valid_mail')->from('dtm_users');
                $this->db->where('id',$params['id']);
                $query                                                          =   $this->db->get();
                $result_user                                                    =   $query->row_array();
                $result_user['action']                                          =   'EDIT';
                $result_user['user_update']                                     =   1;
                $result_user['date_update']                                     =   date('Y-m-d H:i:s');

                if($this->_datamax_model->insert_data($result_user,'dtm_users_hcal'))
                {
                    $result['status']                                           =   TRUE;
                    $result['message']                                          =   'La actualización del estado de visualización del usuario se ha realizado con éxito.';
                } else
                {
                    $result['data']                                             =   FALSE;
                    $result['message']                                          =   'Hubo un problema al actualizar el estado de visualización del usuario.';
                }

            } else 
            {
                $this->db->select('id,name,lastname,document_type,document_number,email,cell_phone_number,country_indicator,enterprise,area,occupation,password,role,photo,date_keepalive,hash_security,flag_block,flag_drop,flag_security,flag_valid_mail')->from('dtm_users');
                $this->db->where('flag_drop',0);
                $query_result                                                   =   $this->db->get();
                $list_users                                                     =   $query_result->result_array();

                foreach($list_users as $user)
                {
                    $user['action']                                          =   'EDIT';
                    $user['user_update']                                     =   1;
                    $user['date_update']                                     =   date('Y-m-d H:i:s');

                    $this->_datamax_model->insert_data($user,'dtm_users_hcal');
                }

                $result['status']                                               =   TRUE;
                $result['message']                                              =   'La actualización del estado de visualización de los usuarios se ha realizado con éxito.';
            }

        } else
        {
            $result['status']                                                   =   FALSE;
            $result['message']                                                  =   'Hubo un problema al actualizar el estado de visualización del usuario.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     int $id
     * @return    array $result
    **/
    public function udrop($params)
    {
        $result                                                                 =   array();

        $data['flag_drop']                                                      =   1;

        $this->db->where('id',$params['id_user']);
        
        if($this->db->update('dtm_users',$data))
        {
            $this->db->select('id,name,lastname,document_type,document_number,email,cell_phone_number,country_indicator,enterprise,area,occupation,password,role,photo,date_keepalive,hash_security,flag_block,flag_drop,flag_security,flag_valid_mail')->from('dtm_users');
            $this->db->where('id',$params['id_user']);
            $query                                              =   $this->db->get();
            $result_user                                        =   $query->row_array();
            $result_user['action']                              =   'UDROP';
            $result_user['user_update']                         =   1;
            $result_user['date_update']                         =   date('Y-m-d H:i:s');

            if($this->_datamax_model->insert_data($result_user,'dtm_users_hcal'))
            {
                $result['status']                                               =   TRUE;
                $result['message']                                              =   'La actualización del estado de borrado del usuario se ha realziado con éxito.';
            } else
            {
                $result['data']                                                 =   TRUE;
                $result['message']                                              =   'Hubo un problema al actualizar el estado de borrado del usuario.';
            }
        } else
        {
            $result['status']                                                   =   FALSE;
            $result['message']                                                  =   'Hubo un problema al actualizar el estado de borrado del usuario.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     int $id
     * @return    array $result
    **/
    public function trace_register($id)
    {
        $result                                                                 =   array();
        $result['html']                                                         =   '';
        $trace_global                                                           =   $this->_datamax_model->global_trace_register_new('dtm_users_hcal', 'id', $id, 'usuario');

        if ($trace_global['value']) 
        {
            $result['html']                                                     .=  $trace_global['history'];
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     void
     * @return    array $result
    **/
    public function list_enterprises()
    {
        $result                                                                 =   array();

        $this->db->select('id, name')->from('dtm_enterprises');
        $query                                                                  =   $this->db->get();

        if($query->num_rows() > 0)
        {
            $list_enterprises                                                   =   $query->result_array();
            $result['data']                                                     =   $list_enterprises;
            $result['message']                                                  =   FALSE;
        } else 
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'No se han encontrado datos relacionados con la búsqueda.';
        }
        
        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     void
     * @return    array $result
    **/
    public function list_areas()
    {
        $result                                                                 =   array();

        $this->db->select('id, name')->from('dtm_areas');
        $query                                                                  =   $this->db->get();

        if($query->num_rows() > 0)
        {
            $list_areas                                                         =   $query->result_array();
            $result['data']                                                     =   $list_areas;
            $result['message']                                                  =   FALSE;
        } else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'No se han encontrado datos relacionados con la búsqueda.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     void
     * @return    array $result
    **/
    public function list_roles()
    {
        $result                                                                 =   array();

        $this->db->select('id, name, date_insert')->from('dtm_roles');
        $query                                                                  =   $this->db->get();

        if($query->num_rows() > 0)
        {
            $list_roles                                                         =   $query->result_array();
            $result['data']                                                     =   $list_roles;
            $result['message']                                                  =   FALSE;
        } else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'No se han encontrado datos relacionados con la búsqueda.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     void
     * @return    array $result
    **/
    public function list_occupations()
    {
        $result                                                                 =   array();

        $this->db->select('id, name')->from('dtm_occupations');
        $query                                                                  =   $this->db->get();

        if($query->num_rows() > 0)
        {
            $list_occupations                                                   =   $query->result_array();
            $result['data']                                                     =   $list_occupations;
            $result['message']                                                  =   FALSE;
        } else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'No se han encontrado datos relacionados con la búsqueda.';
        }

        return $result;
        exit();
    }

    /**
     * @author    Diego Pineda
     * @copyright Conectera
     * @since     v0.0
     * @param     void
     * @return    array $result
    **/
    public function list_countries()
    {
        $result                                                                 =   array();

        $this->db->select('id, name, abreviature, indicative')->from('dtm_countries');
        $query                                                                  =   $this->db->get();

        if($query->num_rows() > 0)
        {
            $list_countries                                                     =   $query->result_array();
            $result['data']                                                     =   $list_countries;
            $result['message']                                                  =   FALSE;
        } else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'No se han encontrado datos relacionados con la búsqueda.';
        }

        return $result;
        exit();
    }

}