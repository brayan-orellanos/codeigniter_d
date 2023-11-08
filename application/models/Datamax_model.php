<?php
/**
* @author    Innovación y Tecnología
* @copyright 2021 Fábrica de Desarrollo
* @version   v 2.0
**/

defined('BASEPATH') OR exit('No direct script access allowed');

class Datamax_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $fields, boolean $drop, string $table, string $order, string $dir 
    * @return    array
    **/
    public function select_data($fields, $drop, $table, $order, $dir)
    {
        $this->db->select($fields);

        if ($drop)
        {
            $this->db->where('flag_drop', 0);
        }

        $prefix                                                                 =   explode('_', $table);

        if ($prefix[0] == 'git')
        {
            $this->db->where('git_company != ', 'G');
        }

        $this->db->order_by($order, $dir);
        $query                                                                  =   $this->db->get($table);
        return $query->result_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $fields, boolean $drop, string $where_field, string | int $where_value, string $table
    * @return    array $query->row_array()
    **/
    public function select_single_data($fields, $drop, $where_field, $where_value, $table)
    {
        $this->db->select($fields);

        if ($drop)
        {
            $this->db->where('flag_drop', 0);
        }

        $prefix                                                                 =   explode('_', $table);

        if ($prefix[0] == 'git' && $table != 'git_sgcdocuments_types')
        {
            $this->db->where($table . '.git_company != ', 'G');
        }

        $this->db->where($where_field, $where_value);
        $this->db->limit(1);

        $query                                                                  =   $this->db->get($table);
        $result = $query->row_array();

        return $result;
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     array $params, string $table
    * @return    boolean | int
    **/
    public function insert_data($params, $table)
    {
        $result                                                                 =   $this->db->insert($table, $params);

        if ($result)
        {
            if ($this->db->insert_id() == 0)
            {
                return true;
            }
            else
            {
                return $this->db->insert_id();
            }
        }

        return false;
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     array $params, string $name_id, string $table
    * @return    boolean
    **/
    public function update_data($params, $name_id, $table)
    {
        $id                                                                     =   $params['id'];
        unset($params['id']); 
        $this->db->where($name_id, $id);
        return $this->db->update($table, $params);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $name_id, int $value_id, string $table
    * @return    boolean 
    **/
    public function udrop_data($name_id, $value_id, $table, $params)
    {
        $data                                                                   =   array();

        if (is_array($params))
        {
            $data                                                               =   $params;
        }
        else
        {
            $data                                                               =   array(
                'flag_drop'                                                             =>  1,
                'user_update'                                                           =>  $this->session->userdata['id_user'],
                'date_update'                                                           =>  date('Y-m-d H:i:s')
                                                                                    );
        }

        $this->db->where($name_id, $value_id);

        return $this->db->update($table, $data);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     int $role, varchar $submodule
    * @return    $array
    **/
    public function drop_data($data, $table)
    {
        return $this->db->delete($table, $data);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $text
    * @return    string
    **/
    public function accents($text)
    {
        $clean_txt                                                              =   mb_ereg_replace('[^A-Za-z0-9áéíóúÁÉÍÓÚ\ \.\,\;\:\-\/\ñ\Ñ\#]', '', $text);
        return trim($clean_txt);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $text
    * @return    string
    **/
    public function no_accents($text_accents)
    {
        $no_allowed                                                             =   array ( 'á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','À','Ã','Ì','Ò','Ù',
                                                                                            'Ã™','Ã ','Ã¨','Ã¬','Ã²','Ã¹','ç','Ç','Ã¢','ê','Ã®','Ã´','Ã','Ã‚',
                                                                                            'ÃŠ','ÃŽ','Ã”','Ã›','ü','Ã¶','Ã–','Ã¯','Ã¤','Ò','Ã','Ã„',
                                                                                            'Ã‹','Ñ','à','è','ì','ò','ù');

        $allowed                                                                =   array ( 'a','e','i','o','u','A','E','I','O','U','n','N','A','E','I','O',
                                                                                            'U','a','e','i','o','u','c','C','a','e','i','o','u','A','E','I',
                                                                                            'O','U','u','o','O','i','a','e','U','I','A','E','N','a','e','i',
                                                                                            'o','u');

        $text                                                                   =   str_replace($no_allowed, $allowed ,$text_accents);

        return trim($text);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $text
    * @return    string
    **/
    public function clean_text($text)
    {
        $search                                                                 =   array('ñ', 'Ñ');
        $replace                                                                =   array('n', 'N');
        $new_text                                                               =   str_replace($search, $replace, $text);
        $clean_txt                                                              =   mb_ereg_replace('[^A-Za-z0-9\ \.]', '', $new_text);
        return trim($clean_txt);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $text
    * @return    string
    **/
    public function serial_clean($text_accents)
    {
        $no_allowed                                                             =   array ( 'á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','À','Ã','Ì','Ò','Ù',
                                                                                            'Ã™','Ã ','Ã¨','Ã¬','Ã²','Ã¹','ç','Ç','Ã¢','ê','Ã®','Ã´','Ã','Ã‚',
                                                                                            'ÃŠ','ÃŽ','Ã”','Ã›','ü','Ã¶','Ã–','Ã¯','Ã¤','Ò','Ã','Ã„',
                                                                                            'Ã‹','Ñ','à','è','ì','ò','ù');

        $allowed                                                                =   array ( 'a','e','i','o','u','A','E','I','O','U','n','N','A','E','I','O',
                                                                                            'U','a','e','i','o','u','c','C','a','e','i','o','u','A','E','I',
                                                                                            'O','U','u','o','O','i','a','e','U','I','A','E','N','a','e','i',
                                                                                            'o','u');

        $text                                                                   =   str_replace($no_allowed, $allowed, $text_accents);
        $clean_txt                                                              =   mb_ereg_replace('[^A-Za-z0-9\ \-]', '', $text);

        return mb_strtoupper(trim($text), 'UTF-8');
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $param
    * @return    string
    **/
    public function uc_first($param)
    {
        if ($param != 'y' && $param != 'en' && $param != 'de' && $param != 'la' && $param != 'el' && $param != 'del')
        {
            return ucfirst($param);
        }
        else
        {
            return $param;
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $text
    * @return    string
    **/
    public function to_camel($text)
    {
        $text_lower                                                             =   mb_strtolower($text);
        $text_array                                                             =   explode(' ', $text_lower);
        $array_map                                                              =   array_map(array($this, 'uc_first'), $text_array);
        $result                                                                 =   implode(' ', $array_map);

        return trim($result);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function trace_insert_register($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                    CONCAT(DATE_FORMAT(A.date_insert, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_insert, "%h:%i:%s %p"))) AS date_insert,
                                                                                    (SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv) AS name_affiliate FROM fet_affiliates B LEFT JOIN fet_cv C ON B.id_cv = C.id_cv  WHERE B.id_affiliate = A.affiliate_insert) AS user_insert
                                                                                    FROM ' . $table . ' A 
                                                                                    WHERE A.' . $id_table . ' = ' . $id;

        $query                                                                  =   $this->db->query($sql);

        return $query->row_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function trace_register($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                    IFNULL(DATE_FORMAT(A.date_insert, "%d-%m-%Y"), \'NO APLICA\') AS date_insert,
                                                                                    IFNULL(LOWER(DATE_FORMAT(A.date_insert, "%h:%i %p")), \'NO APLICA\') AS hour_insert,
                                                                                    IFNULL(DATE_FORMAT(A.date_update, "%d-%m-%Y"), \'NO APLICA\') AS date_update,
                                                                                    IFNULL(LOWER(DATE_FORMAT(A.date_update, "%h:%i %p")), \'NO APLICA\') AS hour_update,
                                                                                    IFNULL((SELECT CONCAT(B.name_user, " ", B.lastname_user) FROM git_users B WHERE B.id_user = A.user_insert), \'NO APLICA\') AS user_insert, 
                                                                                    IFNULL((SELECT CONCAT(C.name_user, " ", C.lastname_user) FROM git_users C WHERE C.id_user = A.user_update), \'NO APLICA\') AS user_update,
                                                                                    IFNULL((SELECT D.name_area  FROM git_areas D JOIN git_users E ON E.id_area = D.id_area WHERE E.id_user = A.user_insert), \'NO APLICA\') AS area_insert,
                                                                                    IFNULL((SELECT F.name_area  FROM git_areas F JOIN git_users G ON G.id_area = F.id_area WHERE G.id_user = A.user_update), \'NO APLICA\') AS area_update
                                                                                    FROM ' . $table . ' A 
                                                                                    WHERE A.' . $id_table . ' = ' . $id;

        $prefix                                                                 =   explode('_', $table);

        $query                                                                  =   $this->db->query($sql);

        return $query->row_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function global_trace_register($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                    IFNULL(DATE_FORMAT(A.date_update, "%d-%m-%Y"), \'NO APLICA\') AS date_update,
                                                                                    IFNULL(LOWER(DATE_FORMAT(A.date_update, "%h:%i %p")), \'NO APLICA\') AS hour_update,
                                                                                    IFNULL((SELECT CONCAT(C.name_user, " ", C.lastname_user) FROM git_users C WHERE C.id_user = A.user_update), \'NO APLICA\') AS user_update,
                                                                                    IFNULL((SELECT F.name_area  FROM git_areas F JOIN git_users G ON G.id_area = F.id_area WHERE G.id_user = A.user_update), \'NO APLICA\') AS area_update
                                                                                    FROM ' . $table . ' A 
                                                                                    WHERE A.' . $id_table . ' = ' . $id . ' 
                                                                                    ORDER BY date_update DESC';

        $query                                                                  =   $this->db->query($sql);

        return $query->result_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function trace_register_external($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                    IFNULL(CONCAT(DATE_FORMAT(A.date_insert, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_insert, "%h:%i:%s %p"))), \'NO APLICA\') AS date_insert,
                                                                                    IFNULL(CONCAT(DATE_FORMAT(A.date_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_update, "%h:%i:%s %p"))), \'NO APLICA\') AS date_update,
                                                                                    IFNULL((SELECT CONCAT(C.name_user, " ", C.lastname_user) FROM git_users C WHERE C.id_user = A.user_update), \'NO APLICA\') AS user_update 
                                                                                    FROM ' . $table . ' A 
                                                                                    WHERE A.' . $id_table . ' = ' . $id;

        $prefix                                                                 =   explode('_', $table);

        if ($prefix[0] == 'git')
        {
            $sql                                                                .=  ' AND A.git_company != "G"';
        }

        $query                                                                  =   $this->db->query($sql);

        return $query->row_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function global_trace_register_external($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                    IFNULL(CONCAT(DATE_FORMAT(A.date_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_update, "%h:%i:%s %p"))), \'NO APLICA\') AS date_update,
                                                                                    IFNULL((SELECT CONCAT(C.name_user, " ", C.lastname_user) FROM git_users C WHERE C.id_user = A.user_update), \'NO APLICA\') AS user_update,
                                                                                    FROM ' . $table . ' A 
                                                                                    WHERE A.' . $id_table . ' = ' . $id . ' 
                                                                                    ORDER BY date_update DESC';

        $query                                                                  =   $this->db->query($sql);

        return $query->result_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function trace_register_shiftchange($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                     IF(CONCAT(DATE_FORMAT(A.date_worker_insert, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_worker_insert, "%h:%i:%s %p"))) IS NULL,
                                                                                     CONCAT(DATE_FORMAT(A.date_insert, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_insert, "%h:%i:%s %p"))),
                                                                                     CONCAT(DATE_FORMAT(A.date_worker_insert, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_worker_insert, "%h:%i:%s %p")))) AS date_insert,
                                                                                     IF(CONCAT(DATE_FORMAT(A.date_worker_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_worker_update, "%h:%i:%s %p"))) IS NULL,
                                                                                     CONCAT(DATE_FORMAT(A.date_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_update, "%h:%i:%s %p"))),
                                                                                     CONCAT(DATE_FORMAT(A.date_worker_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_worker_update, "%h:%i:%s %p")))) AS date_update,
                                                                                     IF((SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv) AS name_worker FROM fet_workers B LEFT JOIN fet_cv C ON C.id_cv = B.id_cv WHERE B.id_worker = A.worker_insert) IS NULL, 
                                                                                     UPPER((SELECT CONCAT(D.name_user, " ", D.lastname_user, "<br>USUARIO") FROM git_users D WHERE D.id_user = A.user_insert)), 
                                                                                     UPPER((SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv, "<br>TRABAJADOR") FROM fet_workers B LEFT JOIN fet_cv C ON C.id_cv = B.id_cv WHERE B.id_worker = A.worker_insert))) AS user_insert,
                                                                                     IF((SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv) AS name_affiliate FROM fet_workers B LEFT JOIN fet_cv C ON C.id_cv = B.id_cv WHERE B.id_worker = A.worker_update) IS NULL, 
                                                                                     UPPER((SELECT CONCAT(C.name_user, " ", C.lastname_user, "<br>USUARIO") FROM git_users C WHERE C.id_user = A.user_update)), 
                                                                                     UPPER((SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv, "<br>TRABAJADOR") FROM fet_workers B LEFT JOIN fet_cv C ON C.id_cv = B.id_cv WHERE B.id_worker = A.worker_update))) AS user_update
                                                                                     FROM ' . $table . ' A 
                                                                                     WHERE A.' . $id_table . ' = ' . $id;

        $prefix                                                                 =   explode('_', $table);

        $query                                                                  =   $this->db->query($sql);

        return $query->row_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function global_trace_register_sh($table, $id_table, $id)
    {
        $sql                                                                    =   'SELECT
                                                                                     IF(CONCAT(DATE_FORMAT(A.date_worker_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_worker_update, "%h:%i:%s %p"))) IS NULL,
                                                                                     CONCAT(DATE_FORMAT(A.date_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_update, "%h:%i:%s %p"))),
                                                                                     CONCAT(DATE_FORMAT(A.date_worker_update, "%d-%m-%Y"), " ", LOWER(DATE_FORMAT(A.date_worker_update, "%h:%i:%s %p")))) AS date_update,
                                                                                     IF((SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv) AS name_affiliate FROM fet_workers B LEFT JOIN fet_cv C ON C.id_cv = B.id_cv WHERE B.id_worker = A.worker_update) IS NULL, 
                                                                                     UPPER((SELECT CONCAT(C.name_user, " ", C.lastname_user, "<br>USUARIO") FROM git_users C WHERE C.id_user = A.user_update)), 
                                                                                     UPPER((SELECT CONCAT(C.name_cv, " ", C.first_lcv, " ", C.second_lcv, "<br>TRABAJADOR") FROM fet_workers B LEFT JOIN fet_cv C ON C.id_cv = B.id_cv WHERE B.id_affiliate = A.worker_update))) AS user_update 
                                                                                     FROM ' . $table . ' A 
                                                                                     WHERE A.' . $id_table . ' = ' . $id;

        $query                                                                  =   $this->db->query($sql);

        return $query->result_array();
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $text
    * @return    string
    **/
    public function user_name($text)
    {
        $clean_txt                                                              =   mb_ereg_replace('[^A-Za-z0-9\ \.\_\-\@]', '', $text);
        return trim($clean_txt);
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $address, string $subject, string $message, string $origin
    * @return    array
    **/
    public function send_mail($address, $subject, $content)
    {
        // CODIGO COMENTADO
        // $config                                                                 =   array(
        //                                                                                 'protocol'      =>  'sendmail',
        //                                                                                 'smtp_host'     =>  'smtp.gmail.com',
        //                                                                                 'smtp_port'     =>  587,
        //                                                                                 'smtp_user'     =>  'datamax@gmail.com',
        //                                                                                 'smtp_pass'     =>  'YVsR)uTXFVmi',
        //                                                                                 'smtp_crypto'   =>  'ssl',
        //                                                                                 'mailtype'      =>  'html',
        //                                                                                 'charset'       =>  'utf-8',
        //                                                                                 'wordwrap'      =>  TRUE
        //                                                                             );

        $config                                                                 =   array(
                                                                                        'protocol'      =>  'sendmail',
                                                                                        'smtp_host'     =>  'mail.datamax.co',
                                                                                        'smtp_port'     =>  587,
                                                                                        'smtp_user'     =>  'gestion@datamax.co',
                                                                                        'smtp_pass'     =>  'F2T@2021/jjml',
                                                                                        'smtp_crypto'   =>  'ssl',
                                                                                        'mailtype'      =>  'html',
                                                                                        'charset'       =>  'utf-8',
                                                                                        'wordwrap'      =>  TRUE
                                                                                    );

        $this->load->library('email', $config);

        // $this->email->from('datamax@gmail.com', $content['of']);
        $this->email->from('gestion@datamax.co', $content['of']);
        $this->email->to($address);
        $this->email->subject($subject);

        $body                                                                   =   '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">'
                                                                                .   '<head>'
                                                                                .   '<meta charset="UTF-8">'
                                                                                .   '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                                                                .   '<meta name="viewport" content="width=device-width, initial-scale=1">'
                                                                                .   '<style type="text/css">'
                                                                                .   'p{margin:10px 0;padding:0;}table{border-collapse:collapse;}h1,h2,h3,h4,h5,h6{display:block;margin:0;padding:0;}img,a img{border:0;height:auto;outline:none;text-decoration:none;}body,#bodyTable,#bodyCell{height:100%;margin:0;padding:0;width:100%;}.mcnPreviewText{display:none !important;}#outlook a{padding:0;}img{-ms-interpolation-mode:bicubic;}table{mso-table-lspace:0pt;mso-table-rspace:0pt;}.ReadMsgBody{width:100%;}.ExternalClass{width:100%;}p,a,li,td,blockquote{mso-line-height-rule:exactly;}a[href^=tel],a[href^=sms]{color:inherit;cursor:default;text-decoration:none;}p,a,li,td,body,table,blockquote{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{line-height:100%;}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important;}.templateContainer{max-width:600px !important;}a.mcnButton{display:block;}.mcnImage,.mcnRetinaImage{vertical-align:bottom;}.mcnTextContent{word-break:break-word;}.mcnTextContent img{height:auto !important;}.mcnDividerBlock{table-layout:fixed !important;}h1{color:#2b60b0;font-family:Helvetica;font-size:40px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:center;}h2{color:#222222;font-family:Helvetica;font-size:34px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:left;}h3{color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:left;}h4{color:#949494;font-family:Georgia;font-size:20px;font-style:italic;font-weight:normal;line-height:125%;letter-spacing:normal;text-align:left;}#templateHeader{background-color:#F7F7F7;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:20px;padding-bottom:20px;}.headerContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;}.headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{color:#007C89;font-weight:normal;text-decoration:underline;}#templateBody{background-color:#FFFFFF;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:20px;padding-bottom:20px;}.bodyContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;}.bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{color:#007C89;font-weight:normal;text-decoration:underline;}#templateFooter{background-color:#2b60b0;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:45px;padding-bottom:63px;}.footerContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{color:#FFFFFF;font-family:Helvetica;font-size:12px;line-height:150%;text-align:center;}.footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{color:#FFFFFF;font-weight:normal;text-decoration:underline;}@media only screen and (min-width:768px){.templateContainer{width:600px !important;}}@media only screen and (max-width:480px){body,table,td,p,a,li,blockquote{-webkit-text-size-adjust:none !important;}}@media only screen and (max-width:480px){body{width:100% !important;min-width:100% !important;}}@media only screen and (max-width:480px){.mcnRetinaImage{max-width:100% !important;}}@media only screen and (max-width:480px){.mcnImage{width:100% !important;}}@media only screen and (max-width:480px){.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{max-width:100% !important;width:100% !important;}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer{min-width:100% !important;}}@media only screen and (max-width:480px){.mcnImageGroupContent{padding:9px !important;}}@media only screen and (max-width:480px){.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{padding-top:9px !important;}}@media only screen and (max-width:480px){.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{padding-top:18px !important;}}@media only screen and (max-width:480px){.mcnImageCardBottomImageContent{padding-bottom:9px !important;}}@media only screen and (max-width:480px){.mcnImageGroupBlockInner{padding-top:0 !important;padding-bottom:0 !important;}}@media only screen and (max-width:480px){.mcnImageGroupBlockOuter{padding-top:9px !important;padding-bottom:9px !important;}}@media only screen and (max-width:480px){.mcnTextContent,.mcnBoxedTextContentColumn{padding-right:18px !important;padding-left:18px !important;}}@media only screen and (max-width:480px){.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{padding-right:18px !important;padding-bottom:0 !important;padding-left:18px !important;}}@media only screen and (max-width:480px){.mcpreview-image-uploader{display:none !important;width:100% !important;}}@media only screen and (max-width:480px){h1{font-size:30px !important;line-height:125% !important;}}@media only screen and (max-width:480px){h2{font-size:26px !important;line-height:125% !important;}}@media only screen and (max-width:480px){h3{font-size:20px !important;line-height:150% !important;}}@media only screen and (max-width:480px){h4{font-size:18px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{font-size:14px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{font-size:16px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{font-size:16px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{font-size:14px !important;line-height:150% !important;}}'
                                                                                .   '</style>'
                                                                                .   '</head>'
                                                                                .   '<body>'
                                                                                .   '<center>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="bodyCell">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%">'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateHeader" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="headerContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnImageBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" style="padding:9px" class="mcnImageBlockInner">'
                                                                                .   '<table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;"> <img align="center" alt="" src="' . RESOURCES . '/img/logo.png" width="250" style="max-width:250px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage"> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">'
                                                                                .   '<h1>' . $content['title'] . '</h1>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateBody" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="bodyContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">'
                                                                                .   '<br>'
                                                                                .   $content['body']
                                                                                .   '<br>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>';

        if ($content['login'] == '1')
        {
            $body                                                               .=  '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnButtonBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #e0922f;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;"> <a class="mcnButton " title="Ingresar" href="' . $content['url'] . '" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFF;">Ingresar</a> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>';
        }

        $body                                                                   .=  '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateFooter" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="footerContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnDividerBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">'
                                                                                .   '<table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #FFF;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td> <span></span> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;"> Copyright &copy; ' . date('Y') . ' - FET <br> Todos los Derechos Reservados <br> datamax <br> PLATAFORMA DE APOYO A LOS PROCESOS MISIONALES<br><br><strong>Para mayor información comunicate con nosotros al correo </strong><br>gestion@datamax.co<br></td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</center>'
                                                                                .   '</body>'
                                                                                .   '</html>';


        $this->email->message($body);

        $this->email->set_newline("\r\n");

        if (!$this->email->send())
        {
            return show_error($this->email->print_debugger());
        }
        else
        {
            return TRUE;
        }
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $address, string $subject, string $message, string $origin
    * @return    array
    **/
    public function send_phpmail($address, $subject, $content)
    {
        $mail = $this->phpmail->load();

        $mail->isSMTP();
        
        $mail->SMTPAuth     = true;
        $mail->SMTPSecure   = 'ssl';
        $mail->Host         = 'mail.datamax.co';
        $mail->Port         = 465;
        $mail->Username     = 'gestion@datamax.co';
        $mail->Password     = 'F2T@2021/jjml';

        $mail->setFrom('gestion@datamax.co', $content['of']);
        $mail->addReplyTo('gestion@datamax.co', $content['of']);

        // CODIGO COMENTADO
        // $mail->SMTPAuth     = true;
        // $mail->SMTPSecure   = 'tls';
        // $mail->Host         = 'smtp.gmail.com';
        // $mail->Port         = 587;
        // $mail->Username     = 'datamax@gmail.com';
        // $mail->Password     = 'wkkduoqbihcqoajt';

        // $mail->setFrom('datamax@gmail.com', $content['of']);
        // $mail->addReplyTo('datamax@gmail.com', $content['of']);


        // CODIGO COMENTADO
        // $mail->SMTPAuth     = true;
        // $mail->SMTPSecure   = 'tls';
        // $mail->Host         = 'smtp-mail.outlook.com';
        // $mail->Port         = 587;
        // $mail->Username     = 'datamax@outlook.com';
        // $mail->Password     = 'Wkkduoqbihcqoajt';

        // $mail->setFrom('datamax@outlook.com', $content['of']);
        // $mail->addReplyTo('datamax@outlook.com', $content['of']);


        $mail->addAddress($address);
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $body                                                                   =   '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">'
                                                                                .   '<head>'
                                                                                .   '<meta charset="UTF-8">'
                                                                                .   '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                                                                .   '<meta name="viewport" content="width=device-width, initial-scale=1">'
                                                                                .   '<style type="text/css">'
                                                                                .   'p{margin:10px 0;padding:0;}table{border-collapse:collapse;}h1,h2,h3,h4,h5,h6{display:block;margin:0;padding:0;}img,a img{border:0;height:auto;outline:none;text-decoration:none;}body,#bodyTable,#bodyCell{height:100%;margin:0;padding:0;width:100%;}.mcnPreviewText{display:none !important;}#outlook a{padding:0;}img{-ms-interpolation-mode:bicubic;}table{mso-table-lspace:0pt;mso-table-rspace:0pt;}.ReadMsgBody{width:100%;}.ExternalClass{width:100%;}p,a,li,td,blockquote{mso-line-height-rule:exactly;}a[href^=tel],a[href^=sms]{color:inherit;cursor:default;text-decoration:none;}p,a,li,td,body,table,blockquote{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{line-height:100%;}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important;}.templateContainer{max-width:600px !important;}a.mcnButton{display:block;}.mcnImage,.mcnRetinaImage{vertical-align:bottom;}.mcnTextContent{word-break:break-word;}.mcnTextContent img{height:auto !important;}.mcnDividerBlock{table-layout:fixed !important;}h1{color:#2b60b0;font-family:Helvetica;font-size:40px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:center;}h2{color:#222222;font-family:Helvetica;font-size:34px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:left;}h3{color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:left;}h4{color:#949494;font-family:Georgia;font-size:20px;font-style:italic;font-weight:normal;line-height:125%;letter-spacing:normal;text-align:left;}#templateHeader{background-color:#F7F7F7;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:20px;padding-bottom:20px;}.headerContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;}.headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{color:#007C89;font-weight:normal;text-decoration:underline;}#templateBody{background-color:#FFFFFF;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:20px;padding-bottom:20px;}.bodyContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;}.bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{color:#007C89;font-weight:normal;text-decoration:underline;}#templateFooter{background-color:#2b60b0;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:45px;padding-bottom:63px;}.footerContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{color:#FFFFFF;font-family:Helvetica;font-size:12px;line-height:150%;text-align:center;}.footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{color:#FFFFFF;font-weight:normal;text-decoration:underline;}@media only screen and (min-width:768px){.templateContainer{width:600px !important;}}@media only screen and (max-width:480px){body,table,td,p,a,li,blockquote{-webkit-text-size-adjust:none !important;}}@media only screen and (max-width:480px){body{width:100% !important;min-width:100% !important;}}@media only screen and (max-width:480px){.mcnRetinaImage{max-width:100% !important;}}@media only screen and (max-width:480px){.mcnImage{width:100% !important;}}@media only screen and (max-width:480px){.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{max-width:100% !important;width:100% !important;}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer{min-width:100% !important;}}@media only screen and (max-width:480px){.mcnImageGroupContent{padding:9px !important;}}@media only screen and (max-width:480px){.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{padding-top:9px !important;}}@media only screen and (max-width:480px){.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{padding-top:18px !important;}}@media only screen and (max-width:480px){.mcnImageCardBottomImageContent{padding-bottom:9px !important;}}@media only screen and (max-width:480px){.mcnImageGroupBlockInner{padding-top:0 !important;padding-bottom:0 !important;}}@media only screen and (max-width:480px){.mcnImageGroupBlockOuter{padding-top:9px !important;padding-bottom:9px !important;}}@media only screen and (max-width:480px){.mcnTextContent,.mcnBoxedTextContentColumn{padding-right:18px !important;padding-left:18px !important;}}@media only screen and (max-width:480px){.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{padding-right:18px !important;padding-bottom:0 !important;padding-left:18px !important;}}@media only screen and (max-width:480px){.mcpreview-image-uploader{display:none !important;width:100% !important;}}@media only screen and (max-width:480px){h1{font-size:30px !important;line-height:125% !important;}}@media only screen and (max-width:480px){h2{font-size:26px !important;line-height:125% !important;}}@media only screen and (max-width:480px){h3{font-size:20px !important;line-height:150% !important;}}@media only screen and (max-width:480px){h4{font-size:18px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{font-size:14px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{font-size:16px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{font-size:16px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{font-size:14px !important;line-height:150% !important;}}'
                                                                                .   '</style>'
                                                                                .   '</head>'
                                                                                .   '<body>'
                                                                                .   '<center>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="bodyCell">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%">'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateHeader" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="headerContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnImageBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" style="padding:9px" class="mcnImageBlockInner">'
                                                                                .   '<table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;"> <img align="center" alt="" src="' . RESOURCES . '/img/logo.png" width="250" style="max-width:250px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage"> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">'
                                                                                .   '<h1>' . $content['title'] . '</h1>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateBody" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="bodyContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">'
                                                                                .   '<br>'
                                                                                .   $content['body']
                                                                                .   '<br>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>';

        if ($content['button'] == '1')
        {
            $body                                                               .=  '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnButtonBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #e0922f;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;"> <a class="mcnButton " title="Ingresar" href="' . $content['url'] . '" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFF;">' . $content['button_title'] . '</a> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>';
        }

        $body                                                                   .=  '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateFooter" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="footerContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnDividerBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">'
                                                                                .   '<table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #FFF;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td> <span></span> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;"> Copyright &copy; ' . date('Y') . ' - FET <br> Todos los Derechos Reservados <br> DATAMAX <br> PLATAFORMA DE APOYO A LOS PROCESOS MISIONALES<br><br><strong>Para mayor información comunicate con nosotros al correo </strong><br>datamax@gmail.com<br></td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</center>'
                                                                                .   '</body>'
                                                                                .   '</html>';

        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';

        try
        {
            $mail->send();

            return TRUE;
        } 
        catch (Exception $e)
        {
            $message =  'Excepción de envío: '.  $e->getMessage();

            return FALSE;
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2022 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $address, string $subject, string $message, string $origin
    * @return    array
    **/
    public function send_phpmail_new($address, $subject, $content)
    {
        $mail = $this->phpmail->load();

        $mail->isSMTP();
        
        $mail->SMTPAuth     = true;
        $mail->SMTPSecure   = 'ssl';
        $mail->Host         = 'mail.datamax.co';
        $mail->Port         = 465;
        $mail->Username     = 'gestion@datamax.co';
        $mail->Password     = 'F2T@2021/jjml';

        $mail->setFrom('gestion@datamax.co', $content['of']);
        $mail->addReplyTo('gestion@datamax.co', $content['of']);

        $mail->addAddress($address);
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $body                                                                   =   '<!doctype html>
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                    <!-- NAME: 1 COLUMN -->
                    <!--[if gte mso 15]>
                    <xml>
                        <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                    </xml>
                    <![endif]-->
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>datamax</title>
                    <style type="text/css">
                        @font-face{font-family:ubuntubold;src:url(' . RESOURCES . '/fonts/UbuntuNew/ubuntu-bold-webfont.woff2) format(\'woff2\'),url(' . RESOURCES . '/fonts/UbuntuNew/ubuntu-bold-webfont.woff) format(\'woff\');font-weight:400;font-style:normal}@font-face{font-family:ubuntu;src:url(' . RESOURCES . '/fonts/UbuntuNew/ubuntu-regular-webfont.woff2) format(\'woff2\'),url(' . RESOURCES . '/fonts/UbuntuNew/ubuntu-regular-webfont.woff) format(\'woff\');font-weight:400;font-style:normal}
                        p{margin:10px 0;padding:0}table{border-collapse:collapse}h1,h2,h3,h4,h5,h6{display:block;margin:0;padding:0}a img,img{border:0;height:auto;outline:0;text-decoration:none}#bodyCell,#bodyTable,body{height:100%;margin:0;padding:0;width:100%}.mcnPreviewText{display:none!important}.tx-greetings{padding: 18px;color: #707070;font-family: ubuntu;font-size: 14px;font-weight: normal;text-align: center;margin-top:10px}.name_email{color: #003985;font-family: ubuntu;font-size: 16px;font-weight: bold;text-align: center;margin: 20px auto;}.tx-content-mail{padding: 18px;color: #707070;font-family: ubuntu;font-size: 12px;font-weight: normal;text-align: center;}#outlook a{padding:0}img{-ms-interpolation-mode:bicubic}table{mso-table-lspace:0pt;mso-table-rspace:0pt}.ReadMsgBody{width:100%}.ExternalClass{width:100%}a,blockquote,li,p,td{mso-line-height-rule:exactly}a[href^=sms],a[href^=tel]{color:inherit;cursor:default;text-decoration:none}a,blockquote,body,li,p,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}#bodyCell{padding:10px}.templateContainer{max-width:600px!important;background-color:#eee}a.mcnButton{display:block}.mcnImage,.mcnRetinaImage{vertical-align:bottom}.mcnTextContent{word-break:break-word}.mcnTextContent img{height:auto!important}.mcnDividerBlock{table-layout:fixed!important}#bodyTable,body{background-color:#fafafa}#bodyCell{border-top:0}.templateContainer{border:0}h1{color:#202020;font-family:ubuntu;font-size:26px;font-style:normal;font-weight:700;line-height:125%;letter-spacing:normal;text-align:left}h2{color:#202020;font-family:ubuntu;font-size:22px;font-style:normal;font-weight:700;line-height:125%;letter-spacing:normal;text-align:left}h3{color:#202020;font-family:ubuntu;font-size:20px;font-style:normal;font-weight:700;line-height:125%;letter-spacing:normal;text-align:left}h4{color:#202020;font-family:ubuntu;font-size:18px;font-style:normal;font-weight:700;line-height:125%;letter-spacing:normal;text-align:left}#templatePreheader{background-color:#fafafa;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:9px}#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{color:#656565;font-family:ubuntu;font-size:12px;line-height:150%;text-align:left}#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{color:#656565;font-weight:400;text-decoration:underline}#templateHeader{background-color:#eee;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:0}#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{color:#202020;font-family:ubuntu;font-size:16px;line-height:150%;text-align:left}#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{color:#007c89;font-weight:400;text-decoration:underline}#templateBody{background-color:#eee;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:2px solid #eaeaea;padding-top:0;padding-bottom:9px}#templateBody .mcnTextContent,#templateBody .mcnTextContent p{color:#202020;font-family:ubuntu;font-size:16px;line-height:150%;text-align:left}#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{color:#007c89;font-weight:400;text-decoration:underline}#templateFooter{background-color:#fafafa;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:9px}#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{color:#656565;font-family:ubuntu;font-size:12px;line-height:150%;text-align:center}#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{color:#656565;font-weight:400;text-decoration:underline}@media only screen and (min-width:768px){.templateContainer{width:600px!important}}@media only screen and (max-width:480px){a,blockquote,body,li,p,table,td{-webkit-text-size-adjust:none!important}}@media only screen and (max-width:480px){body{width:100%!important;min-width:100%!important}}@media only screen and (max-width:480px){.mcnRetinaImage{max-width:100%!important}}@media only screen and (max-width:480px){.mcnImage{width:100%!important}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer,.mcnCaptionBottomContent,.mcnCaptionLeftImageContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightImageContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionTopContent,.mcnCartContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightImageContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageGroupContentContainer,.mcnRecContentContainer,.mcnTextContentContainer{max-width:100%!important;width:100%!important}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer{min-width:100%!important}}@media only screen and (max-width:480px){.mcnImageGroupContent{padding:9px!important}}@media only screen and (max-width:480px){.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{padding-top:9px!important}}@media only screen and (max-width:480px){.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnImageCardTopImageContent{padding-top:18px!important}}@media only screen and (max-width:480px){.mcnImageCardBottomImageContent{padding-bottom:9px!important}}@media only screen and (max-width:480px){.mcnImageGroupBlockInner{padding-top:0!important;padding-bottom:0!important}}@media only screen and (max-width:480px){.mcnImageGroupBlockOuter{padding-top:9px!important;padding-bottom:9px!important}}@media only screen and (max-width:480px){.mcnBoxedTextContentColumn,.mcnTextContent{padding-right:18px!important;padding-left:18px!important}}@media only screen and (max-width:480px){.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{padding-right:18px!important;padding-bottom:0!important;padding-left:18px!important}}@media only screen and (max-width:480px){.mcpreview-image-uploader{display:none!important;width:100%!important}}@media only screen and (max-width:480px){h1{font-size:22px!important;line-height:125%!important}}@media only screen and (max-width:480px){h2{font-size:20px!important;line-height:125%!important}}@media only screen and (max-width:480px){h3{font-size:18px!important;line-height:125%!important}}@media only screen and (max-width:480px){h4{font-size:16px!important;line-height:150%!important}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{font-size:14px!important;line-height:150%!important}}@media only screen and (max-width:480px){#templatePreheader{display:block!important}}@media only screen and (max-width:480px){#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{font-size:14px!important;line-height:150%!important}}@media only screen and (max-width:480px){#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{font-size:16px!important;line-height:150%!important}}@media only screen and (max-width:480px){#templateBody .mcnTextContent,#templateBody .mcnTextContent p{font-size:16px!important;line-height:150%!important}}@media only screen and (max-width:480px){#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{font-size:14px!important;line-height:150%!important}}
                    </style>
                </head>
                <body>
                    <center>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                            <tr>
                                <td align="center" valign="top" id="bodyCell">
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="background-color: #EEEEEE;">
                                        <tr>
                                            <td valign="top" id="templateHeader">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                                                    <tbody class="mcnImageBlockOuter">
                                                        <tr>
                                                            <td valign="top" style="padding:0px" class="mcnImageBlockInner">
                                                                <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="mcnImageContent" valign="top" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                                                                <img align="center" alt="" src="' . $content['img_head'] . '" width="600" style="max-width: 1293px; padding-bottom: 0px; vertical-align: bottom; display: inline !important; border-radius: 0%;" class="mcnImage">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
                                                <!--[if gte mso 9]>
                                                <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <![endif]-->
                                                    <tbody class="mcnBoxedTextBlockOuter">
                                                        <tr>
                                                            <td valign="top" class="mcnBoxedTextBlockInner">
                            
                                                                <!--[if gte mso 9]>
                                                                <td align="center" valign="top" ">
                                                                <![endif]-->
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="padding-top:9px; padding-left:10%; padding-bottom:40px; padding-right:10%;">
                                                                                <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #FFFFFF;margin-top: -30px">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td valign="top" class="mcnTextContent" style="padding: 10px 20px">
                                                                                                <h3 class="tx-greetings">Hola ¿Cómo estas?</h3>';

                                                                                                if ($content['name'])
                                                                                                {
                                                                                                    $body   .=   '<h2 class="name_email">' . $content['name'] . '</h2>';
                                                                                                }

                                                                                                $body   .= $content['body'] . '
                                                                                            </td>
                                                                                        </tr>';

                                                                                        if($content['button'] == 1)
                                                                                        {
                                                                                            $body   .=   '<tr>
                                                                                                <td valign="top" class="mcnTextContent" style="text-align: center;">
                                                                                                    <a href="' . $content['url'] . '"><img align="center" alt="" src="' . $content['button_src'] . '" width="100%" style="max-width: 1293px; padding-bottom: 0px; vertical-align: bottom; display: inline !important; border-radius: 0%;" class="mcnImage"></a>
                                                                                                </td>
                                                                                            </tr>';
                                                                                        }

                                                                                        $body   .= '<tr>
                                                                                            <td valign="top" class="mcnTextContent" style="text-align: right; padding: 20px">
                                                                                                <a href="' . APPLICATION . '" style="color: #003A85;text-decoration: none;font-size: 12px;">www.datamax.co</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--[if gte mso 9]>
                                                                </td>
                                                                <![endif]-->
                                                                
                                                                <!--[if gte mso 9]>
                                                                </tr>
                                                                </table>
                                                                <![endif]-->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </table>
                    </center>
                </body>
            </html>';

        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';

        try
        {
            $mail->send();

            return TRUE;
        } 
        catch (Exception $e)
        {
            $message =  'Excepción de envío: '.  $e->getMessage();

            return FALSE;
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $address, string $subject, string $message, string $origin
    * @return    array
    **/
    public function send_mail_asambleas($address, $subject, $content, $color_hex, $logo_company)
    {
        $config                                                                 =   array(
                                                                                        'protocol'      =>  'sendmail',
                                                                                        'smtp_host'     =>  'mail.datamax.co',
                                                                                        'smtp_port'     =>  587,
                                                                                        'smtp_user'     =>  'gestion@datamax.co',
                                                                                        'smtp_pass'     =>  'YVsR)uTXFVmi',
                                                                                        'smtp_crypto'   =>  'ssl',
                                                                                        'mailtype'      =>  'html',
                                                                                        'charset'       =>  'utf-8',
                                                                                        'wordwrap'      =>  TRUE
                                                                                    );

        $this->load->library('email', $config);

        $this->email->from('gestion@datamax.co', $content['of']);
        $this->email->to($address);
        $this->email->subject($subject);

        $body                                                                   =   '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">'
                                                                                .   '<head>'
                                                                                .   '<meta charset="UTF-8">'
                                                                                .   '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                                                                .   '<meta name="viewport" content="width=device-width, initial-scale=1">'
                                                                                .   '<style type="text/css">'
                                                                                .   'p{margin:10px 0;padding:0;}table{border-collapse:collapse;}h1,h2,h3,h4,h5,h6{display:block;margin:0;padding:0;}img,a img{border:0;height:auto;outline:none;text-decoration:none;}body,#bodyTable,#bodyCell{height:100%;margin:0;padding:0;width:100%;}.mcnPreviewText{display:none !important;}#outlook a{padding:0;}img{-ms-interpolation-mode:bicubic;}table{mso-table-lspace:0pt;mso-table-rspace:0pt;}.ReadMsgBody{width:100%;}.ExternalClass{width:100%;}p,a,li,td,blockquote{mso-line-height-rule:exactly;}a[href^=tel],a[href^=sms]{color:inherit;cursor:default;text-decoration:none;}p,a,li,td,body,table,blockquote{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{line-height:100%;}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important;}.templateContainer{max-width:600px !important;}a.mcnButton{display:block;}.mcnImage,.mcnRetinaImage{vertical-align:bottom;}.mcnTextContent{word-break:break-word;}.mcnTextContent img{height:auto !important;}.mcnDividerBlock{table-layout:fixed !important;}h1{color:' . $color_hex . ';font-family:Helvetica;font-size:40px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:center;}h2{color:#222222;font-family:Helvetica;font-size:34px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:left;}h3{color:#444444;font-family:Helvetica;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal;text-align:left;}h4{color:#949494;font-family:Georgia;font-size:20px;font-style:italic;font-weight:normal;line-height:125%;letter-spacing:normal;text-align:left;}#templateHeader{background-color:#F7F7F7;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:20px;padding-bottom:20px;}.headerContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;}.headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{color:#007C89;font-weight:normal;text-decoration:underline;}#templateBody{background-color:#FFFFFF;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:20px;padding-bottom:20px;}.bodyContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left;}.bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{color:#007C89;font-weight:normal;text-decoration:underline;}#templateFooter{background-color:' . $color_hex . ';background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:45px;padding-bottom:63px;}.footerContainer{background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0;}.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{color:#FFFFFF;font-family:Helvetica;font-size:12px;line-height:150%;text-align:center;}.footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{color:#FFFFFF;font-weight:normal;text-decoration:underline;}@media only screen and (min-width:768px){.templateContainer{width:600px !important;}}@media only screen and (max-width:480px){body,table,td,p,a,li,blockquote{-webkit-text-size-adjust:none !important;}}@media only screen and (max-width:480px){body{width:100% !important;min-width:100% !important;}}@media only screen and (max-width:480px){.mcnRetinaImage{max-width:100% !important;}}@media only screen and (max-width:480px){.mcnImage{width:100% !important;}}@media only screen and (max-width:480px){.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{max-width:100% !important;width:100% !important;}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer{min-width:100% !important;}}@media only screen and (max-width:480px){.mcnImageGroupContent{padding:9px !important;}}@media only screen and (max-width:480px){.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{padding-top:9px !important;}}@media only screen and (max-width:480px){.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{padding-top:18px !important;}}@media only screen and (max-width:480px){.mcnImageCardBottomImageContent{padding-bottom:9px !important;}}@media only screen and (max-width:480px){.mcnImageGroupBlockInner{padding-top:0 !important;padding-bottom:0 !important;}}@media only screen and (max-width:480px){.mcnImageGroupBlockOuter{padding-top:9px !important;padding-bottom:9px !important;}}@media only screen and (max-width:480px){.mcnTextContent,.mcnBoxedTextContentColumn{padding-right:18px !important;padding-left:18px !important;}}@media only screen and (max-width:480px){.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{padding-right:18px !important;padding-bottom:0 !important;padding-left:18px !important;}}@media only screen and (max-width:480px){.mcpreview-image-uploader{display:none !important;width:100% !important;}}@media only screen and (max-width:480px){h1{font-size:30px !important;line-height:125% !important;}}@media only screen and (max-width:480px){h2{font-size:26px !important;line-height:125% !important;}}@media only screen and (max-width:480px){h3{font-size:20px !important;line-height:150% !important;}}@media only screen and (max-width:480px){h4{font-size:18px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{font-size:14px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{font-size:16px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{font-size:16px !important;line-height:150% !important;}}@media only screen and (max-width:480px){.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{font-size:14px !important;line-height:150% !important;}}'
                                                                                .   '</style>'
                                                                                .   '</head>'
                                                                                .   '<body>'
                                                                                .   '<center>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="bodyCell">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%">'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateHeader" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="headerContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnImageBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" style="padding:9px" class="mcnImageBlockInner">'
                                                                                .   '<table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;"> <img align="center" alt="" src="' . $logo_company . '" width="250" style="max-width:250px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage"> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">'
                                                                                .   '<h1>' . $content['title'] . '</h1>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateBody" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="bodyContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">'
                                                                                .   '<br>'
                                                                                .   $content['body']
                                                                                .   '<br>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>';

        if ($content['login'] == '1')
        {
            $body                                                               .=  '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnButtonBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #e0922f;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;"> <a class="mcnButton " title="Ingresar" href="' . $content['url'] . '" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFF;">Ingresar</a> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>';
        }

        $body                                                                   .=  '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '<tr>'
                                                                                .   '<td align="center" valign="top" id="templateFooter" data-template-container>'
                                                                                .   '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="footerContainer">'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnDividerBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">'
                                                                                .   '<table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #FFF;">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td> <span></span> </td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">'
                                                                                .   '<tbody class="mcnTextBlockOuter">'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">'
                                                                                .   '<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">'
                                                                                .   '<tbody>'
                                                                                .   '<tr>'
                                                                                .   '<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;"> Copyright &copy; ' . date('Y') . ' - FET <br> Todos los Derechos Reservados <br> datamax <br> PLATAFORMA DE APOYO A LOS PROCESOS MISIONALES<br><br><strong>Para mayor información comunicate con nosotros al correo </strong><br>gestion@datamax.co<br></td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</tbody>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</td>'
                                                                                .   '</tr>'
                                                                                .   '</table>'
                                                                                .   '</center>'
                                                                                .   '</body>'
                                                                                .   '</html>';

        $this->email->message($body);

        $this->email->set_newline("\r\n");

        if (!$this->email->send())
        {
            return show_error($this->email->print_debugger());
        }
        else
        {
            return TRUE;
        }
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     int $role, varchar $submodule
    * @return    $array
    **/
    public function actions_by_role($role, $submodule)
    {
        $roles_user                                                             =   array($role);

        if (isset($this->session->userdata['id']))
        {
            $this->db->select('role');
            $this->db->where('id', $this->session->userdata['id']);

            $query_roles                                                        =   $this->db->get('dtm_users_hcal');

            if (count($query_roles->result_array()) > 0)
            {
                foreach ($query_roles->result_array() as $row)
                {
                    $roles_user[]                                               =   $row['role'];
                }
            }
        }

        $this->db->select('name_action');
        $this->db->where_in('role', $roles_user);
        $this->db->where('name_submodule', $submodule);
        // $this->db->where('git_company != ', 'G');

        $query                                                                  =   $this->db->get('dtm_permissions');

        $result                                                                 =   array();

        if (count($query->result_array()) > 0)
        {
            foreach ($query->result_array() as $row)
            {
                array_push($result, $row['name_action']);
            }
        }

        return $result;

        exit();
    }


    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     FILE $error_image, FILE $name_image, varchar $dir, FILE $size_image, FILE $tmp_name_image
    * @return    $array
    **/
    public function upload_image($error_image, $name_image, $dir, $size_image, $tmp_name_image, $w_image, $h_image, $resize, $photo, $name_image_end)
    {
        $name_image_old                                                         =   $name_image;        

        if ($error_image === UPLOAD_ERR_OK)
        {
            $upload_folder                                                      =   ($name_image <> '') ? $dir : '';
            $fragments                                                          =   explode('.', $name_image);
            $extension                                                          =   end($fragments);
            $extension                                                          =   mb_strtolower($extension);

            if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg')
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'La extensión de la imagen ' . $name_image_old . ' debe ser jpg, png o jpeg.';
                return $result;
                exit();
            }

            if($size_image > 20000000)
            {
                if (!$resize) 
                {
                    $result['data']                                             =   FALSE;
                    $result['message']                                          =   'El tamaño de la imagen ' . $name_image_old . ' no debe exceder los 20 Mb.';
                    return $result;
                    exit();
                }
            }

            $today                                                              =   strtotime("".date("Y-m-d H:i:s")."");

            if ($name_image_end)
            {
                $name_image                                                     =   $name_image_end . '.' . $extension;
            }
            else
            {
                $name_image                                                     =   $today . '.' . $extension;
            }

            $store                                                              =   $upload_folder . '/' . $name_image;
            $image                                                              =   FALSE;

            $data                                                               =   getimagesize($tmp_name_image);

            $width                                                              =   $data[0];
            $height                                                             =   $data[1];

            if ($photo)
            {
                if($width > "1200" || $height > "1200")
                {
                    $result['data']                                             =   FALSE;
                    $result['message']                                          =   'El tamaño de la imagen ' . $name_image_old . ' no debe exceder los 1200px de ancho x 1200px de alto.';
                    return $result;
                    exit();
                }
            }

            if ($resize) 
            {
                if($width < $w_image)
                {
                    if (move_uploaded_file($tmp_name_image, $store))
                    {
                        $result['data']                                         =   TRUE;
                        $result['name_image']                                   =   $name_image;
                        return $result;
                        exit();
                    }
                    else
                    {
                        $result['data']                                         =   FALSE;
                        $result['message']                                      =   'Error subiendo la imagen ' . $name_image_old . ', inténta de nuevo.222';
                        return $result;
                        exit();
                    }
                }
                else
                {
                    switch ($extension)
                    {
                        case 'jpg':
                        case 'jpeg':
                            $temp_image                                         =   imagecreatefromjpeg($tmp_name_image);
                            break;
                        case 'png':
                            $temp_image                                         =   imagecreatefrompng($tmp_name_image);
                            break;
                    }


                    $x_ratio                                                    =   $w_image / $width;
                    $y_ratio                                                    =   $h_image / $height;

                    switch (true) 
                    {
                        case (($width <= $w_image) && ($height <= $h_image)):
                            $w_final                                            =   $width; 
                            $h_final                                            =   $height;
                            break;
                        case (($x_ratio * $height) < $w_image):
                            $w_final                                            =   $w_image; 
                            $h_final                                            =   ceil($x_ratio * $height);
                            break;
                        default:
                            $w_final                                            =   ceil($y_ratio * $width);
                            $h_final                                            =   $h_image;
                            break;
                    }

                    $canvas                                                     =   imagecreatetruecolor($w_final, $h_final);

                    imagecopyresampled($canvas, $temp_image, 0, 0, 0, 0, $w_final, $h_final, $width, $height);
                    imagedestroy($temp_image);

                    switch ($extension)
                    {
                        case 'jpg':
                        case 'jpeg':
                            $image                                              =   imagejpeg($canvas, $store);
                            break;
                        case 'png':
                            $image                                              =   imagepng($canvas, $store);
                            break;
                    }

                    if ($image)
                    {
                        $result['data']                                         =   TRUE;
                        $result['name_image']                                   =   $name_image;
                        return $result;
                        exit();
                    }
                    else
                    {
                        $result['data']                                         =   FALSE;
                        $result['message']                                      =   'Error subiendo la imagen ' . $name_image_old . ', inténta de nuevo.333';
                        return $result;
                        exit();
                    }                    
                }
            }
            else
            {
                $w_scale                                                        =   round((($w_image * 100) / $width), 1, PHP_ROUND_HALF_DOWN);
                $h_scale                                                        =   round((($h_image * 100) / $height), 1, PHP_ROUND_HALF_DOWN);

                $w_check                                                        =   floor($width * ($h_scale / 100));
                $h_check                                                        =   floor($height * ($w_scale / 100));

                if (($width > 600) && ($height > 600))
                {
                    switch (TRUE)
                    {
                        case (($w_check <= $w_image) && ($h_check <= $h_image)):
                            $scale                                              =   max(array($w_scale, $h_scale));
                            $p_scale                                            =   $scale / 100;
                            $n_height                                           =   $height * $p_scale;
                            $n_width                                            =   $width * $p_scale;
                            break;

                        case ($w_check <= $w_image):
                            $p_scale                                            =   $h_scale / 100;
                            $n_height                                           =   $height * $p_scale;
                            $n_width                                            =   $width * $p_scale;
                            break;

                        case ($h_check <= $h_image):
                            $p_scale                                            =   $w_scale / 100;
                            $n_height                                           =   $height * $p_scale;
                            $n_width                                            =   $width * $p_scale;
                            break;

                        default:
                            $n_height                                           =   $h_image;
                            $n_width                                            =   $w_image;
                    }

                    switch ($extension)
                    {
                        case 'jpg':
                        case 'jpeg':
                            $temp_image                                         =   imagecreatefromjpeg($tmp_name_image);
                            $temp_image                                         =   imagescale($temp_image, $n_width, $n_height);
                            $image                                              =   imagejpeg($temp_image, $store);

                            break;

                        case 'png':
                            $temp_image                                         =   imagecreatefrompng($tmp_name_image);
                            $temp_image                                         =   imagescale($temp_image, $n_width, $n_height);
                            $image                                              =   imagepng($temp_image, $store);

                            break;
                    }

                    if ($image)
                    {
                        $result['data']                                         =   TRUE;
                        $result['name_image']                                   =   $name_image;
                        return $result;
                        exit();
                    }
                    else
                    {
                        $result['data']                                         =   FALSE;
                        $result['message']                                      =   'Error subiendo la imagen ' . $name_image_old . ', inténta de nuevo.444';
                        return $result;
                        exit();
                    }
                }
                else
                {
                    if (move_uploaded_file($tmp_name_image, $store))
                    {
                        $result['data']                                         =   TRUE;
                        $result['name_image']                                   =   $name_image;
                        return $result;
                        exit();
                    }
                    else
                    {
                        $result['data']                                         =   FALSE;
                        $result['message']                                      =   'Error subiendo la imagen ' . $name_image_old . ', inténta de nuevo.55';
                        return $result;
                        exit();
                    }
                }
            }
        }
        else
        {
            
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Error subiendo la imagen ' . $name_image_old . ', inténta de nuevo.66';
            return $result; 
            exit();
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     FILE $error_file, FILE $name_file, varchar $dir, FILE $size_file, FILE $tmp_name_file
    * @return    $array
    **/
    public function upload_file($error_file, $name_file, $dir, $size_file, $tmp_name_file)
    {
        if ($error_file === UPLOAD_ERR_OK)
        {
            $upload_folder                                                      =   ($name_file <> '') ? $dir : '';
            $fragments                                                          =   explode('.', $name_file);
            $extension                                                          =   end($fragments);
            $extension                                                          =   mb_strtolower($extension);

            if ($extension != 'pdf')
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'La extensión del archivo ' . $name_file . ' debe ser pdf.';
                return $result;
                exit();
            }

            if($size_file > 20000000)
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'El tamaño del archivo ' . $name_file . ' no debe exceder los 20 Mb.';
                return $result;
                exit();
            }

            $today                                                              =   strtotime("".date("Y-m-d H:i:s")."");
            $name_file_store                                                    =   $today . '.' . $extension;
            $store                                                              =   $upload_folder . '/' . $name_file_store;

            if (move_uploaded_file($tmp_name_file, $store))
            {
                $result['data']                                                 =   TRUE;
                $result['name_file']                                            =   $name_file_store;
                return $result;
                exit();
            }
            else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
                return $result;
                exit();
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
            return $result;
            exit();
        }
    }


    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     FILE $error_file, FILE $name_file, varchar $dir, FILE $size_file, FILE $tmp_name_file, varchar $nickname, varchar $extensions
    * @return    $array
    **/
    public function upload_file_extensions($error_file, $name_file, $dir, $size_file, $tmp_name_file, $nickname, $extensions)
    {
        if ($error_file === UPLOAD_ERR_OK)
        {
            $upload_folder                                                      =   ($name_file <> '') ? $dir : '';
            $fragments                                                          =   explode('.', $name_file);
            $extension                                                          =   end($fragments);
            $extension                                                          =   mb_strtolower($extension);

            $permit_extension                                                   =   explode('|', $extensions);

            $cont                                                               =   0;

            foreach ($permit_extension as $value)
            {
                if ($extension != $value)
                {
                    $cont++;
                }
            }

            if (count($permit_extension) == $cont)
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'La extensión del archivo ' . $name_file . ' debe ser (' . $extensions . ').';

                return $result;
                exit();
            }

            if($size_file > 20000000)
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'El tamaño del archivo ' . $name_file . ' no debe exceder las 20 Mb.';

                return $result;
                exit();
            }

            if ($nickname != false)
            {
                $today                                                          =   $nickname . '_' . strtotime("".date("Y-m-d H:i:s")."");
            }
            else
            {
                $today                                                          =   strtotime("".date("Y-m-d H:i:s")."");
            }

            $name_file_store                                                    =   $today . '.' . $extension;
            $store                                                              =   $upload_folder . '/' . $name_file_store;

            if (move_uploaded_file($tmp_name_file, $store))
            {
                $result['data']                                                 =   TRUE;
                $result['name_file']                                            =   $name_file_store;

                return $result;
                exit();
            }
            else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
                return $result;
                exit();
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
            return $result;
            exit();
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     FILE $error_file, FILE $name_file, varchar $dir, FILE $size_file, FILE $tmp_name_file
    * @return    $array
    **/
    public function upload_file_name($error_file, $name_file, $dir, $size_file, $tmp_name_file, $new_name_file)
    {
        if ($error_file === UPLOAD_ERR_OK)
        {
            $upload_folder                                                      =   ($name_file <> '') ? $dir : '';
            $fragments                                                          =   explode('.', $name_file);
            $extension                                                          =   end($fragments);
            $extension                                                          =   mb_strtolower($extension);

            if ($extension != 'pdf')
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'La extensión del archivo ' . $name_file . ' debe ser pdf.';
                return $result;
                exit();
            }

            if($size_file > 20000000)
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'El tamaño del archivo ' . $name_file . ' no debe exceder los 20 Mb.';
                return $result;
                exit();
            }

            $name_file_store                                                    =   $new_name_file . '.' . $extension;
            $store                                                              =   $upload_folder . '/' . $name_file_store;

            if (move_uploaded_file($tmp_name_file, $store))
            {
                $result['data']                                                 =   TRUE;
                $result['name_file']                                            =   $name_file_store;

                return $result;
                exit();
            }
            else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
                return $result;
                exit();
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
            return $result;
            exit();
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     FILE $error_file, FILE $name_file, varchar $dir, FILE $size_file, FILE $tmp_name_file
    * @return    $array
    **/
    public function upload_file_name_size($error_file, $name_file, $dir, $size_file, $tmp_name_file, $new_name_file, $extensions, $max_size)
    {
        if ($error_file === UPLOAD_ERR_OK)
        {
            $upload_folder                                                      =   ($name_file <> '') ? $dir : '';
            $fragments                                                          =   explode('.', $name_file);
            $extension                                                          =   end($fragments);
            $extension                                                          =   mb_strtolower($extension);

            $permit_extension                                                   =   explode('|', $extensions);

            $cont                                                               =   0;

            foreach ($permit_extension as $value)
            {
                if ($extension != $value)
                {
                    $cont++;
                }
            }

            if (count($permit_extension) == $cont)
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'La extensión del archivo ' . $name_file . ' debe ser (' . $extensions . ').';

                return $result;
                exit();
            }

            if($size_file > $max_size)
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'El tamaño del archivo ' . $name_file . ' no debe exceder los 20 Mb.';
                return $result;
                exit();
            }

            $name_file_store                                                    =   $new_name_file . '.' . $extension;
            $store                                                              =   $upload_folder . '/' . $name_file_store;

            if (move_uploaded_file($tmp_name_file, $store))
            {
                $result['data']                                                 =   TRUE;
                $result['name_file']                                            =   $name_file_store;

                return $result;
                exit();
            }
            else
            {
                $result['data']                                                 =   FALSE;
                $result['message']                                              =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
                return $result;
                exit();
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
            $result['message']                                                  =   'Error subiendo el archivo ' . $name_file . ', inténta de nuevo.';
            return $result;
            exit();
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $submodule
    * @return    array | boolean
    **/
    public function get_breadcrumb($submodule)
    {
        $this->db->select('dtm_modules.name_es, dtm_modules.name, dtm_submodules.name_es, dtm_submodules.url');
        $this->db->join('dtm_modules', 'dtm_modules.id = dtm_submodules.module');
        $this->db->where('dtm_submodules.name', $submodule);

        $query                                                                  =   $this->db->get('dtm_submodules');

        if (count($query->result_array()) > 0)
        {
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $email
    * @return    array | boolean
    **/
    public function is_valid_email($email)
    {
        $result                                                                 =   (false !== filter_var($email, FILTER_VALIDATE_EMAIL));

        if ($result)
        {
            list($user, $domain)                                                =   explode('@', $email);

            $result                                                             =   checkdnsrr($domain, 'MX');
        }

        return $result;
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $key, $data
    * @return    string
    **/
    public function encrypt($key, $data)
    {
        $key                                                                    =   'FseRbDU54tX17ueRbDU' . $key;
        $encryptionKey                                                          =   base64_decode($key);
        $iv                                                                     =   openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-gcm'));
        $encrypted                                                              =   openssl_encrypt($data, 'aes-256-gcm', $encryptionKey, 0, $iv, $tag);

        return $encrypted . ':' . base64_encode($iv) . ':' . base64_encode($tag);
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $key, $data
    * @return    string
    **/
    public function decrypt($key, $data)
    {
        $key                                                                    =   'FseRbDU54tX17ueRbDU' . $key;
        $encryptionKey                                                          =   base64_decode($key);
        list($encryptedData, $iv, $tag)                                         =   explode(':', $data, 3);

        return openssl_decrypt($encryptedData, 'aes-256-gcm', $encryptionKey, 0, base64_decode($iv), base64_decode($tag));
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     array $params
    * @return    array $result
    **/
    public function companies_select($params)
    {
        $result                                                                 =   array();

        $page                                                                   =   $params['page'];
        $range                                                                  =   10;

        $start                                                                  =   ($page - 1) * $range;
        $limit                                                                  =   $start + $range;

        $this->db->select('gc.id_company AS id, gc.code_company AS text');
        $this->db->join('git_projects gp', 'gp.id_company = gc.id_company');
        $this->db->join('git_users_projects gu', 'gu.id_project = gp.id_project');
        $this->db->where('gc.git_company != ', 'G');
        $this->db->where('gc.flag_association_active', 1);
        $this->db->where('gc.flag_internal', 1);
        $this->db->where('gc.flag_drop', 0);
        $this->db->where('gu.id_user', $this->session->userdata['id_user']);

        if (isset($params['q']) && $params['q'] != '')
        {
            $this->db->like('gc.code_company', $params['q']);
        }

        $this->db->group_by('gc.id_company, gc.code_company');
        $this->db->order_by('gc.code_company', 'asc');
        $this->db->limit($limit, $start);

        $query                                                                  =   $this->db->get('git_companies gc');

        $result['total_count']                                                  =   $query->num_rows();

        if ($result['total_count'] > 0)
        {
            $result['items']                                                    =   $query->result_array();
        }
        else
        {
            $result['items']                                                    =   array();
        }

        return $result;
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     array $params
    * @return    array $result
    **/
    public function projects_select($params)
    {
        $result                                                                 =   array(
            'items'                                                                     =>  array()
                                                                                    );
        if (isset($params['id']) && $params['id'] != '')
        {
            $page                                                               =   $params['page'];
            $range                                                              =   10;

            $start                                                              =   ($page - 1) * $range;
            $limit                                                              =   $start + $range;

            $this->db->select('gp.id_project AS id, CONCAT(gp.name_project, " - ", gp.neighborhood_project) AS text');
            $this->db->join('git_users_projects gu', 'gu.id_project = gp.id_project');
            $this->db->where('gp.git_company != ', 'G');
            $this->db->where('gp.id_company', $params['id']);
            $this->db->where('gp.flag_drop', 0);
            $this->db->where('gu.id_user', $this->session->userdata['id_user']);

            if (isset($params['q']) && $params['q'] != '')
            {
                $this->db->group_start();
                $this->db->like('gp.name_project', $params['q']);
                $this->db->or_like('gp.neighborhood_project', $params['q']);
                $this->db->group_end();
            }

            $this->db->group_by('id, text');
            $this->db->order_by('gp.name_project', 'asc');
            $this->db->limit($limit, $start);

            $query                                                              =   $this->db->get('git_projects gp');

            $result['total_count']                                              =   $query->num_rows();

            if ($result['total_count'] > 0)
            {
                $result['items']                                                =   $query->result_array();
            }
        }

        return $result;
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     array $param
    * @return    array $result
    **/
    public function get_company($id)
    {
        $result                                                                 =   array();
        
        if ($id != '')
        {
            $this->db->select('gc.id_company, gc.code_company, CONCAT(gp.name_project, " - ", gp.neighborhood_project) AS project');
            $this->db->join('git_companies gc', 'gc.id_company = gp.id_company');
            $this->db->where('gp.id_project', $id);

            $query                                                              =   $this->db->get('git_projects gp');

            $row                                                                =   $query->row_array();

            if (isset($row))
            {
                $result['data']                                                 =   $row;
            }
            else
            {
                $result['data']                                                 =   FALSE;
            }
        }
        else
        {
            $result['data']                                                     =   FALSE;
        }
        return $result;
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2022 Fabrica de Desarrollo
    * @since     v2.0.1
    * @param     int $id
    * @return    $fp
    **/
    public function logo_company_search($id)
    {
        if ($id) 
        {
            $this->db->select('img_logo_company');
            $this->db->where('id_company', $id);

            $query                                                              =   $this->db->get('git_companies');
            $image                                                              =   $query->row_array();

            if (isset($image['img_logo_company']) && $image['img_logo_company'] != '')
            {
                $file                                                           =   'application/files/companies/logos/' . $image['img_logo_company'];

                if (file_exists($file))
                {
                    $fp                                                         =   fopen($file, 'rb');

                    header("Content-Type: image/jpeg");
                    header("Content-Length: " . filesize($file));

                    fpassthru($fp);
                    exit();
                }
                else
                {
                    $file                                                       =   'resources/img/logo_company_default' . random_int(1, 3) . '.png';

                    if (file_exists($file)) 
                    {
                        $fp                                                     =   fopen($file, 'rb');

                        header("Content-Type: image/jpeg");
                        header("Content-Length: " . filesize($file));

                        fpassthru($fp);
                        exit();
                    }
                }
            }
            else
            {
                $file                                                       =   'resources/img/logo_company_default' . random_int(1, 3) . '.png';

                if (file_exists($file)) 
                {
                    $fp                                                     =   fopen($file, 'rb');

                    header("Content-Type: image/jpeg");
                    header("Content-Length: " . filesize($file));

                    fpassthru($fp);
                    exit();
                }
            }
        }
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function trace_register_new($table, $id_table, $id)
    {
        $this->db->select('IFNULL(AI.name_area, "NO APLICA") AS area_insert');
        $this->db->select('IFNULL(CONCAT(I.name_user, " ", I.lastname_user), "NO APLICA") AS user_insert');
        $this->db->select('IFNULL(DATE_FORMAT(A.date_insert, "%d-%m-%Y"), "NO APLICA") AS date_insert');
        $this->db->select('IFNULL(DATE_FORMAT(A.date_insert, "%h:%i %p"), "NO APLICA") AS hour_insert');

        $this->db->select('AU.name_area AS area_update');
        $this->db->select('CONCAT(U.name_user, " ", U.lastname_user) AS user_update');
        $this->db->select('DATE_FORMAT(A.date_update, "%d-%m-%Y") AS date_update');
        $this->db->select('DATE_FORMAT(A.date_update, "%h:%i %p") AS hour_update');

        $this->db->join('git_users I', 'I.id_user = A.user_insert', 'left');
        $this->db->join('git_areas AI', 'AI.id_area = I.id_area', 'left');

        $this->db->join('git_users U', 'U.id_user = A.user_update', 'left');
        $this->db->join('git_areas AU', 'AU.id_area = U.id_area', 'left');

        $this->db->where('A.' . $id_table . ' =', $id);

        $query                                                                  =   $this->db->get($table . ' A');

        if (count($query->result_array()) > 0)
        {
            $users                                                              =   $query->row_array();

            if (boolval($this->session->userdata['mobile'])) 
            {
                $result['first']                                                =   '<div class="tl-item">
                                                                                        <div class="tl-dot"></div>
                                                                                        <div class="tl-content">
                                                                                            <div class="tl-subcontent media align-items-center wd-100p-force mg-y-10-force">
                                                                                                <div class="profile_letter_mobile">' . mb_strtoupper(substr($users['user_insert'], 0, 1)) . '</div> 
                                                                                                <div class="media-body">
                                                                                                    <p class="tx-inverse tx-medium mg-b-0 tx-12">' . $users['user_insert'] . '</p>
                                                                                                    <p class="tx-10 mg-b-0">
                                                                                                        <span>' . $users['area_insert'] . '</span><br>
                                                                                                        <span class="mr-1"><b>Fecha: </b>' . $users['date_insert'] . '</span>
                                                                                                        <span><b>Hora: </b>' . $users['hour_insert'] . '</span><br>
                                                                                                        <span><b>Acción:</b> Crear</span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>';

                if (boolval($users['user_update'])) 
                {
                    $result['last']                                             =   '<div class="tl-item">
                                                                                        <div class="tl-dot"></div>
                                                                                        <div class="tl-content">
                                                                                            <div class="tl-subcontent media align-items-center wd-100p-force mg-y-10-force" style="magin-top: 20px;">
                                                                                                <div class="profile_letter_mobile">' . mb_strtoupper(substr($users['user_update'], 0, 1)) . '</div> 
                                                                                                <div class="media-body">
                                                                                                    <p class="tx-inverse tx-medium mg-b-0 tx-12">' . $users['user_update'] . '</p>
                                                                                                    <p class="tx-10 mg-b-0">
                                                                                                        <span>' . $users['area_update'] . '</span><br>
                                                                                                        <span class="mr-1"><b>Fecha: </b>' . $users['date_update'] . '</span>
                                                                                                        <span><b>Hora: </b>' . $users['hour_update'] . '</span><br>
                                                                                                        <span><b>Acción:</b> Editar</span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="pd-x-20 pd-y-5 lasted-trace">
                                                                                                <p class="tx-12 tx-spacing-1 mg-0 pd-0">
                                                                                                    <span class="tx-12 tx-roboto">Última edición</span>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>';
                }
                else
                {
                    $result['last']                                             =   '';
                }

                $result['value']                                                =   TRUE;
            }
            else
            {
                $result['first']                                                =   '<div class="tl-item">
                                                                                        <div class="tl-dot"></div>
                                                                                        <div class="tl-content">
                                                                                            <div class="d-flex justify-content-between align-items-center pd-x-60 pd-y-10">
                                                                                                <div class="tl-subcontent media align-items-center" style="border-right: 1px solid #CFCFCF;">
                                                                                                    <div class="profile_letter">' . mb_strtoupper(substr($users['user_insert'], 0, 1)) . '</div> 
                                                                                                    <div class="media-body mg-l-10">
                                                                                                        <p class="tx-inverse tx-medium mg-b-0 tx-16">' . $users['user_insert'] . '</p>
                                                                                                        <p class="tx-14 mg-b-0">
                                                                                                            <span>' . $users['area_insert'] . '</span>
                                                                                                        </p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tl-subcontent text-muted tx-16-force mt-1 mg-l-50">
                                                                                                    <span class="mr-3"><b>Fecha: </b>' . $users['date_insert'] . '</span>
                                                                                                    <span><b>Hora: </b>' . $users['hour_insert'] . '</span>
                                                                                                </div>
                                                                                                <div class="tl-subcontent text-muted tx-16-force mt-1 pd-l-50" style="border-left: 1px solid #CFCFCF;">
                                                                                                    <span><b>Acción:</b></span> <br>
                                                                                                    <i class="fas fa-plus mt-1 mr-1"></i> Crear
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>';

                if (boolval($users['user_update'])) 
                {
                    $result['last']                                             =   '<div class="tl-item">
                                                                                        <div class="tl-dot"></div>
                                                                                        <div class="tl-content">
                                                                                            <div class="d-flex justify-content-between align-items-center pd-x-60 pd-y-10">
                                                                                                <div class="tl-subcontent media align-items-center" style="border-right: 1px solid #CFCFCF;">
                                                                                                    <div class="profile_letter">' . mb_strtoupper(substr($users['user_update'], 0, 1)) . '</div> 
                                                                                                    <div class="media-body mg-l-10">
                                                                                                        <p class="tx-inverse tx-medium mg-b-0 tx-16">' . $users['user_update'] . '</p>
                                                                                                        <p class="tx-14 mg-b-0">
                                                                                                            <span>' . $users['area_update'] . '</span>
                                                                                                        </p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tl-subcontent text-muted tx-16-force mt-1">
                                                                                                    <span class="mr-3"><b>Fecha: </b>' . $users['date_update'] . '</span>
                                                                                                    <span><b>Hora: </b>' . $users['hour_update'] . '</span>
                                                                                                </div>
                                                                                                <div class="tl-subcontent text-muted tx-16-force mt-1 pd-l-50" style="border-left: 1px solid #CFCFCF;">
                                                                                                    <span><b>Acción:</b></span> <br>
                                                                                                    <i class="fas fa-pencil-alt mt-1 mr-1"></i> Editar
                                                                                                </div>
                                                                                                <div class="pd-x-20 pd-y-5 lasted-trace">
                                                                                                    <p class="tx-12 tx-spacing-1 mg-0 pd-0">
                                                                                                        <span class="tx-12 tx-roboto">Última edición</span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>';
                }
                else
                {
                    $result['last']                                             =   '';
                }

                $result['value']                                                =   TRUE;
            }
        }
        else
        {
            $result['value']                                                    =   FALSE;
            $result['message']                                                  =   'Lo sentimos, no encontramos ningun histórico de este módulo.';

            $result['last']                                                     =   '';
            $result['first']                                                    =   '';
        }

        return $result;
        exit();
    }

    /**
    * @author    Innovación y Tecnología
    * @copyright 2021 Fábrica de Desarrollo
    * @since     v2.0.1
    * @param     string $table, string $id_table, int $id
    * @return    array
    **/
    public function global_trace_register_new($table, $id_table, $id, $module)
    {
        $sql                                                                    =   'SELECT IFNULL(A.action, \'NO APLICA\') AS module_action,
                                                                                    IFNULL(DATE_FORMAT(A.date_update, "%d-%m-%Y"), \'NO APLICA\') AS date_update,
                                                                                    IFNULL(LOWER(DATE_FORMAT(A.date_update, "%h:%i %p")), \'NO APLICA\') AS hour_update,
                                                                                    IFNULL((SELECT CONCAT(C.name, " ", C.lastname) FROM dtm_users C WHERE C.id = A.user_update), \'NO APLICA\') AS user_update,
                                                                                    IFNULL((SELECT C.document_number FROM dtm_users C WHERE C.id = A.user_update), \'NO APLICA\') AS document_number,
                                                                                    IFNULL((SELECT R.name FROM dtm_occupations R JOIN dtm_users C WHERE R.id = C.role limit 1), \'NO APLICA\') AS user_ocupation
                                                                                    FROM ' . $table . ' A 
                                                                                    WHERE A.' . $id_table . ' = ' . $id . ' 
                                                                                    ORDER BY UNIX_TIMESTAMP(date_update) DESC';

        $query                                                                  =   $this->db->query($sql);
        $result                                                                 =   array();
        $result['history']                                                      =   '';
        $class                                                                  =   '';

        if(count($query->result_array()) == 1) $class = 'unico';

        if (count($query->result_array()) > 0)
        {
                foreach ($query->result_array() as $key => $data)
                {
                    $result['history']                                          .= '<div class="tl-item">
                                                                                        <div class="tl-dut '. $class .'"></div>
                                                                                        <div class="tl-content">
                                                                                            <div class="row mg-0 pd-x-30 pd-y-10 wd-100p">
                                                                                                <div class="row mg-0 col-lg-5 col-md-8 col-12 pd-0">
                                                                                                    <div class="profile"><i class="fa-solid fa-user"></i></div> 
                                                                                                    <div class="media-body mg-l-20 mg-l-xs-0">
                                                                                                        <p class="text-res">Responsable</p>
                                                                                                        <p class="text-name">' . mb_strtoupper($data['user_update']) . '</p>
                                                                                                        <p class="text-doc">C.C ' . $data['document_number'] . '</p>
                                                                                                        <p class="text-cargo">' . ucfirst(mb_strtolower($this->_datamax_model->accents($data['user_ocupation']))) . '</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tl-subcontent text-muted tx-16-force mt-4 col-lg-3 col-md-4 col-12 pd-0">
                                                                                                    <span class="text-tl">Acción</span>';

                                                                                                    switch ($data['module_action']) 
                                                                                                    {
                                                                                                        case 'ADD':
                                                                                                            $result['history'] .= '<p class="text-sub">Crear '. $module . '</p>';
                                                                                                            break;
                                                                                                        case 'EDIT':
                                                                                                            $result['history'] .= '<p class="text-sub">Editar ' . $module . '</p>';
                                                                                                            break;
                                                                                                        case 'UDROP':
                                                                                                            $result['history'] .= '<p class="text-sub">Eliminar ' . $module . '</p>';
                                                                                                            break;                                                                                                            
                                                                                                        default:
                                                                                                            $result['history'] .= '<p class="text-sub">No aplica</p>';
                                                                                                            break;
                                                                                                    }

                                                                                                $result['history'] .= '</div>
                                                                                                <div class="tl-subcontent text-muted tx-16-force mt-4 col-lg-2 col-md-6 col-12 pd-0">
                                                                                                    <p class="text-tl">Fecha</p>
                                                                                                    <p class="text-sub">'. date('d/m/Y', strtotime($data['date_update'])) . '</p>
                                                                                                </div>
                                                                                                <div class="col-lg-2 col-md-6 col-12 mt-4 pd-0">
                                                                                                    <p class="text-tl">Hora</p>
                                                                                                    <p class="text-sub">' . date('H:i:s', strtotime($data['hour_update'])) . '</p>
                                                                                                </div>';

                    $result['history']                                          .=          '</div>
                                                                                        </div>
                                                                                    </div>';
                }

                $result['value']                                                =   TRUE;
        }
        else
        {
            $result['value']                                                    =   FALSE;
            $result['message']                                                  =   'Lo sentimos, no encontramos ningun histórico de este módulo.';

            $result['history']                                                  =   '';
        }

        return $result;
        exit();
    }

}