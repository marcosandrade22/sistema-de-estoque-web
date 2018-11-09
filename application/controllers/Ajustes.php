<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        //$this->load->model('M_produto', 'cadastro');
        $this->load->library('table');
        $this->load->model('Getuser');
        $this->load->model('Controleacesso');
        $this->load->model('M_ajuste', '', TRUE);
            $this->load->helper('url');
    }
    public function index(){

      $data['title'] = "Página Inicial - Controle de Estoque ";
      $data['headline'] = "Ajustes";

      $this->load->view('v_header');
      $this->load->view('v_menu', $data);
      $this->load->view('configuracoes/v_dash_configuracoes', $data);
      $this->load->view('v_footer', $data);
    }

    public function lista_ajustes()
    {  // controle de acesso
        $controller="ajustes/lista_ajustes";
        if($this->Controleacesso->acesso($controller) == true){
        $data['headline'] = "Ajustes";
        $data['pagina'] = "Ajustes";
        $data['title'] = "Produtos - Estoque";
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $data['lista'] = $this->M_ajuste->lista_ajuste();
        $data['tipo_ajustes'] = $this->M_ajuste->listTipo();
        $this->load->view('ajustes/v_lista_ajustes',$data);
        $this->load->view('v_footer');

          }
        else{
        $this->load->view('v_header',$data);
        $this->load->view('sem_acesso');
        }
    }

    public function tipo_ajuste()
    {  // controle de acesso
        $controller="ajustes/lista_ajustes";
        if($this->Controleacesso->acesso($controller) == true){
        $data['headline'] = "Ajustes";
        $data['pagina'] = "Tipos de Ajuste";
        $data['title'] = "Ajustes - Estoque";
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $data['lista'] = $this->M_ajuste->lista_tipo_ajuste();
        $this->load->view('ajustes/v_tipo_ajuste',$data);
        $this->load->view('v_footer');

          }
        else{
        $this->load->view('v_header',$data);
        $this->load->view('sem_acesso');
        }
    }

    public function tipo_ajuste_add()
    {
        $this->tipo_ajuste_validate();
        $data = array(
          'nome_tipo_ajuste' => $this->input->post('nome_tipo_ajuste'),
          'movimento_tipo_ajuste' => $this->input->post('movimento_tipo_ajuste')
            );
        $insert = $this->M_ajuste->save_tipo($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajuste_add()
    {
        $this->ajuste_validate();
        $data = array(
          'nome_ajuste' => $this->input->post('nome_ajuste'),
          'tipo_ajuste' => $this->input->post('tipo_ajuste'),
          'usuario_ajuste' => $this->session->userdata('ID'),
          'data_ajuste' => date('Y-m-d')
            );
        $insert = $this->M_ajuste->save_ajuste($data);
        echo json_encode(array("status" => TRUE));
    }

    public function tipo_ajuste_update()
    {
        //$this->tipo_ajuste_validate();

        $data = array(
                'nome_tipo_ajuste' => $this->input->post('nome_tipo_ajuste'),
                'movimento_tipo_ajuste' => $this->input->post('movimento_tipo_ajuste')
            );
        $this->M_ajuste->update_tipo(array('id_tipo_ajuste' => $this->input->post('id_tipo_ajuste')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function tipo_ajuste_edit($id)
    {
      $data = $this->M_ajuste->get_tipo_by_id($id);
       echo json_encode($data);
    }
    private function tipo_ajuste_validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nome_tipo_ajuste') == '')
        {
            $data['inputerror'][] = 'nome_tipo_ajuste';
            $data['error_string'][] = 'Nome e necessário';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function ajuste_validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nome_ajuste') == '')
        {
            $data['inputerror'][] = 'nome_ajuste';
            $data['error_string'][] = 'Nome e necessário';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

  }
