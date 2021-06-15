<?php
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view('login/index');
    }

    public function cekLogin()
    {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $cek = $this->db->get_where('tbl_admin', array('username' => $user, 'password' => $pass))->result_array();

        $res = count($cek) >= 1;

        if ($res) {
            $set = array("hasLogin" => true);
            $this->session->set_userdata($set);
        }

        echo json_encode($res);
    }
}
