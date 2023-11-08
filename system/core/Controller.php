<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package CodeIgniter
 * @author  EllisLab Dev Team
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright   Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://codeigniter.com
 * @since   Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

    /**
     * Reference to the CI singleton
     *
     * @var object
    */
    private static $instance;
    protected $_view;

    /**
     * Class constructor
     *
     * @return  void
    */
    public function __construct()
    {
        self::$instance =& $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class)
        {
            $this->$var =& load_class($class);
        }

        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();

        log_message('info', 'Controller Class Initialized');

        $this->load->model('datamax_model', '_datamax_model');

        $this->_view                                                            =   $this->smartie;

        $this->_view->assign('RESOURCES',                                       RESOURCES);
        $this->_view->assign('COPYRIGHT',                                       'Copyright &copy; ' . date('Y') . ' CONECTERA  - Todos los Derechos Reservados.');

        $globals_routes                                                         =   $this->globals_routes();

        $this->_view->assign('css_style',                                       '');

        $this->_view->assign('affiliate',                                       FALSE);

        $user                                                                   =   array();

        $user                                                                   =   array(
                                                                                        "id_user"=> "1",
                                                                                        "user"=> "Juan Sebastian Ropero Amado",
                                                                                        "alias"=> "admin",
                                                                                        "id_role"=> "1",
                                                                                        "id_area"=>  "14",
                                                                                        "name_role"=>  "ADMIN",
                                                                                        "flag_leader_area"=> "0",
                                                                                        "flag_security"=>  "0",
                                                                                        "hash_security"=>  NULL,
                                                                                        "email_user"=>  "sandra.amaya@conectera.co",
                                                                                        "flag_valid_mail"=>  "1",
                                                                                        "mobile"=>0
                                                                                    );
        
        $this->session->set_userdata($user);

        $user_flags                                                             =   array();

        if (count($user_flags) > 0)
        {
            foreach ($user_flags as $user_flag)
            {
                $user['flags'][$user_flag['name_flag']]                         =   TRUE;
            }
        }
        else
        {
            unset($this->session->userdata['flags']);
        }

        $this->_view->assign('mobile',                                          $this->session->userdata['mobile']);
        $this->_view->assign('name_role',                                       $this->session->userdata['name_role']);
        $this->_view->assign('name_user',                                       $this->_datamax_model->to_camel('Diego Fernando Pineda Rojas'));

        $this->_view->assign('menu_left',                                       $this->menu_left());
        $this->_view->assign('menu_right',                                      $this->menu_right());
        $this->_view->assign('path_user_edit',                                  site_url('useredit'));
        $this->_view->assign('path_search_companies',                           site_url('searchcompanies'));
        $this->_view->assign('path_search_projects',                            site_url('searchprojects'));
        $this->_view->assign('select_company_project',                          site_url('selectcompanyproject'));
        $this->_view->assign('path_logocompanysearch',                          site_url('logocompanysearch'));
        $this->_view->assign('path_cleargeneralsearch',                         site_url('cleargeneralsearch'));

        $this->_view->assign('session_company_gral',                            '');
        $this->_view->assign('session_company_text_gral',                       '');

        $this->_view->assign('session_project_gral',                            '');
        $this->_view->assign('session_project_text_gral',                       '');

        $this->session->userdata['initial_site']                                =   site_url('users');

        if(!$globals_routes)
            die();
    }

    // --------------------------------------------------------------------

    /**
     * Get the CI singleton
     *
     * @static
     * @return  object
    */
    public static function &get_instance()
    {
        return self::$instance;
    }


    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     routes
    * @return    true 
    **/
    protected function globals_routes()
    {
        try
        {
            $path_login                                                         =   site_url('login');
            
            $this->_view->assign('path_login',                                  $path_login);

            if (strrpos($_SERVER['HTTP_HOST'], 'www.') !== FALSE)
            {
                $path_new                                                       =   str_replace('www.', '', $_SERVER['HTTP_HOST']);

                header("Location: https://" . $path_new);
            }

            return TRUE;
        }
        catch (Exception $e)
        {
            echo "Ha ocurrido un ERROR, Por favor intenta mas tarde. " . $e;
            return FALSE;
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     $role
    * @return    $html 
    **/
    private function menu_left()
    {
        try
        {
            $modules                                                            =   '';
        
            if (isset($this->session->userdata['id_role'])) 
            {
                $modules                                                        =   array();
            }

            return $modules;
        }
        catch(Exception $e)
        {
            echo "Ha ocurrido un ERROR, Por favor intenta mas tarde. " . $e;
            return FALSE;
        }
    }
    
    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     $role
    * @return    $html 
    **/
    private function menu_right()
    {
        try
        {
            $modules                                                            =   '';
        
            if (isset($this->session->userdata['id_role'])) 
            {
                $modules                                                        =   array();
            }

            return $modules;
        }
        catch(Exception $e)
        {
            echo "Ha ocurrido un ERROR, Por favor intenta mas tarde. " . $e;
            return FALSE;
        }
    }
}