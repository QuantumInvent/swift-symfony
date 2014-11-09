<?php
/**
 * Swift Symfony
 *
 * An extra layer to the Symfony 2 framework for RAD
 *
 * NOTICE OF LICENSE
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package		QuantumSymfony
 * @author		Achraf Soltani <achraf.soltani@quantuminvent.com>
 * @copyright	Copyright (c) 2014, QuantumInvent, Inc. (http://www.quantuminvent.com/)
 * @link		http://www.quantuminvent.com/
 * @since		Version 1.0
 */


namespace QuantumInvent\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController extends Controller
{
    protected $warnings;
    protected $success;
    protected $notices;
    protected $errors;

    protected $session;
    protected $session_timeout;

    protected $request;

    protected $data;
    protected $model;

    protected function init()
    {
        $this->data = array();

        $this->warnings = array();
        $this->success = array();
        $this->notices = array();
        $this->errors = array();

        $this->session = new Session();
        $this->session->start();

        $this->request = $this->container->get('request_stack')->getCurrentRequest(); // $this->getRequest deprecated since 2.4
    }

    protected function add_data($label, $value)
    {
        $this->data[$label] = $value;
    }

    protected function get_data($label)
    {
        if($this->data[$label])
            return $this->data[$label];
    }

    protected function add_error($msg)
    {
        $this->errors[] = $msg;
    }

    protected function get_errors_count()
    {
        return count($this->errors);
    }

    protected function add_success($msg)
    {
        $this->success[] = $msg;
    }

    protected function add_warning($msg)
    {
        $this->warnings[] = $msg;
    }

    protected function add_notice($msg)
    {
        $this->notices[] = $msg;
    }

    protected function getData()
    {
        $this->add_data('warnings', $this->warnings);
        $this->add_data('success', $this->success);
        $this->add_data('notices', $this->notices);
        $this->add_data('errors', $this->errors);

        return $this->data;
    }

    protected function save_file($path, $file)
    {
        $ext = substr(strrchr($file->getClientOriginalName(),'.'),1);
        $new_name = md5(time()).'.'.$ext;
        $file->move($path, $new_name);
        return $new_name;
    }

    protected function delete_file($path, $file)
    {
        if(file_exists($path.'/'.$file))
            unlink($path.'/'.$file);
    }
} 