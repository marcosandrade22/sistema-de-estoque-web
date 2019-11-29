<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_relatorios extends MY_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
                $this->load->model('M_admin');   
                $this->load->model('M_relatorio');   
		
	}
        
        public function index()
	{
             $this->load->model('Controleacesso');
            $controller="adm_menus";
             if($this->Controleacesso->acesso($controller) == true){
       $this->load->view('admin/v_header_adm');
       $this->load->view('admin/v_menu');
       $data['eventos'] = $this->M_admin->eventos();
       $this->load->view('admin/v_adm_rel_eventos', $data);
       $this->load->view('admin/v_footer_adm');
                        
	}
        }
        
         public function relatorio($id, $offset=0)
	{
        $limite = 15;
               
               
       $data['eventos'] = $this->M_admin->boletos_por_data($id,$limite, $offset);
       $this->load->view('admin/v_header_adm');
       $this->load->view('admin/v_menu');
       
       $this->load->library('pagination');
        $config['base_url'] = base_url()."adm_relatorios/relatorio/".$id."/";
        $config['per_page'] = $limite;
       $config['total_rows'] = $this->M_admin->boletos_por_data_num($id);
        //$config['total_rows'] = $this->db->get('inscricoes')->num_rows();
        $config['uri_segment'] = 4;
        $config['first_link'] = "Primeiro";
        $config['last_link'] = "Último";
        $config['num_links'] = 5;        
        $this->pagination->initialize($config);
      
        $data['paginacao'] = $this->pagination->create_links();
       
       $this->load->view('admin/v_adm_relatorios', $data);
       $this->load->view('admin/v_footer_adm');   
        }
        
        public function pdf($id){
            $id_evento =  $this->uri->segment(3);
            $id_dia =  $this->uri->segment(4);
           
          $this->load->helper('mpdf');
             // $html = "<html>";
           // $html .= "<head></head>";
          //  $html .= "<body>Meu arquivo de teste</body>";
          //  $html .= "</html>";
 
            // Opcional: Também é possivel carregar uma view inteira...
          
            $data['eventos'] = $this->M_admin->boletos_por_dia($id, $id_dia);
            $data['detalhe']  = $this->M_admin->evento($id);
          // $html = $this->load->view('admin/v_adm_relatorios', null, true, $data);
             $html = $this->load->view('admin/v_head_pdf',$data, true);
            $html .= $this->load->view('admin/v_adm_pdf',$data, true);
            pdf($html);
         
        }
        
         public function pdf_selec(){
            $id =  $this->input->post('evento');
           $data1 =  $this->input->post('data1');
            $data2 =  $this->input->post('data2');
            
          $this->load->helper('mpdf');
        // foreach($_POST['check_list'] as $check) {
          //  echo $check; 
         //   $dias['data_baixa'] = $check;
            
          //   }
          
          
          $data['eventos'] = $this->M_admin->boletos_por_datas($id, $data1, $data2);
          $data['detalhe']  = $this->M_admin->evento($id);
          $html = $this->load->view('admin/v_adm_relatorios', null, true, $data);
          $html = $this->load->view('admin/v_head_pdf',$data, true);
         $html .= $this->load->view('admin/v_adm_pdf',$data, true);
         pdf($html);
         //$this->load->view('admin/v_adm_relatorios', $data);
          //$this->load->view('admin/v_head_pdf',$data);
         //$this->load->view('admin/v_adm_pdf',$data);
        }
        
        public function pdf_relatorio(){
        $tipo =  $this->input->post('filtro_pagantes');
        $ordem =  $this->input->post('ordem_pagantes');
        $evento =  $this->input->post('evento');
           
        $this->load->helper('mpdf');
        $data['detalhe']  = $this->M_admin->evento($evento);
        //$data2['sem_pagamento'] = $this->M_relatorio->sem_pagamento($evento);
        $html = $this->load->view('admin/v_head_pdf',$data, true);
         
        if($tipo == 1){
            $data['tipo_rel'] = "gerais";
            $data['eventos'] = $this->M_relatorio->todos_usuarios($evento,$ordem);
            $html .= $this->load->view('admin/v_adm_relevento',$data, true);
            }
        if($tipo == 2){
            $data['tipo_rel'] = "Que pagaram ao menos uma parcela";    
            $data['eventos'] = $this->M_relatorio->usuarios_1parc($evento,$ordem);
            $html .= $this->load->view('admin/v_adm_relevento',$data, true);
            }
        if($tipo == 3){
            $data['tipo_rel'] = "que não pagou nenhuma parcela";
            $data['eventos'] = $this->M_relatorio->sem_pagamento($evento,$ordem);
            $html .= $this->load->view('admin/v_adm_relsemparc',$data, true);
            }
        if($tipo == 4){
            $data['tipo_rel'] = "com pagamento total";
            $data['eventos'] = $this->M_relatorio->pagamento_100($evento,$ordem);
            $html .= $this->load->view('admin/v_adm_rel100',$data, true);
            }
        
        pdf($html);
        //$this->load->view('admin/v_adm_relevento', $data);
        //$this->load->view('admin/v_head_pdf',$data);
        //$this->load->view('admin/v_adm_pdf',$data);
        }
}