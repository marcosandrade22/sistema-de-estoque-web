<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Etiquetas extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
       
        $this->load->model('M_produto');
        $this->load->library('table');
        $this->load->model('Getuser');
        $this->load->model('Controleacesso');
        $this->load->model('M_nota', '', TRUE);
    }
    
     public function index(){
        // controle de acesso
        
        $controller="etiquetas";
        if($this->Controleacesso->acesso($controller) == true){
            
        $data['pagina'] = "Etiquetas";
        $data['title'] = "Etiquetas - ".title_global;
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
       $data['lista'] = $this->M_produto->lista_produto();
       // $data['departamento'] = $this->M_nota->listDep();
        $this->load->view('v_etiquetas', $data);
        
       
        }
                  else{
                  $this->load->view('v_header',$data);  
                  $this->load->view('sem_acesso');
               }
    }
    
    
    public function gera_pdf(){
      $mista = $this->input->post('mista');
     $this->load->helper('mpdf');
      $data['mista'] = $mista;
      if($mista == 1){
      $produto = $this->input->post('produto');  
      $quantidade =  $this->input->post('quantidade');  
      $data['quantidade'] = $quantidade;
      $data['produto'] = $this->M_produto->lista_produto_id($produto);
      $html =  $this->load->view('v_impre_etiquetas',$data, true); 
      }
      else{
      $data['produto1'] = $this->input->post('produtos1');  
      $quantidade1 =  $this->input->post('quantidade1');  
      $data['quantidade1'] = $quantidade1;
     
      
        $data['produto2'] = $this->input->post('produtos2');  
      $quantidade2 =  $this->input->post('quantidade2');  
      $data['quantidade2'] = $quantidade2;
      
      
        $data['produto3'] = $this->input->post('produtos3');  
      $quantidade3 =  $this->input->post('quantidade3');  
      $data['quantidade3'] = $quantidade3;
      
         $data['produto4'] = $this->input->post('produtos4');  
      $quantidade4 =  $this->input->post('quantidade4');  
      $data['quantidade4'] = $quantidade4;
      
         $data['produto5'] = $this->input->post('produtos5');  
      $quantidade5 =  $this->input->post('quantidade5');  
      $data['quantidade5'] = $quantidade5;
      
        $data['produto6'] = $this->input->post('produtos6');  
      $quantidade6 =  $this->input->post('quantidade6');  
      $data['quantidade6'] = $quantidade6;
      
      //$data['produto'] = $this->M_produto->lista_produto_array($produto);
      $html =  $this->load->view('v_impre_etiquetas_multi',$data, true); 
     
      }
    
   
   // $this->load->view('v_impre_etiquetas',$data);
     //$html =  $this->load->view('v_impre_etiquetas',$data, true); 
      
     $filename = 'Etiquetas'.$data_in.' - '.$data_fim;
      pdf($html, $filename);
      
    }
}