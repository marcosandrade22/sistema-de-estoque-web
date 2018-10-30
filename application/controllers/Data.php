<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Data extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_model','customers');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('v_data');
    }
 
    public function ajax_list()
    {
        $list = $this->customers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->nome_requisicao;
           $row[] = '<a href="'.$customers->id_requisicao.'">teste</a>';
            //$row[] = $customers->phone;
            //$row[] = $customers->address;
            //$row[] = $customers->city;
            //$row[] = $customers->country;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->customers->count_all(),
                        "recordsFiltered" => $this->customers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
 
}