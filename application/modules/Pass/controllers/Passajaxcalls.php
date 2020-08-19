<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passajaxcalls extends MX_Controller {

	function __construct(){

     $this->load->model('Pass/Pass_model');

   }

     // delete multiple categories
     public function delMultipleCategories(){
      
      $catlist = $this->input->post('catlist');

      $items = $this->input->post('items');
      foreach($items as $item){
        $this->Pass_model->delete_cat($item);
      }


    }

      // delete multiple posts
     public function delMultiplePosts(){

      $items = $this->input->post('items');
      foreach($items as $item){
      $this->Pass_model->delete_post($item);
      }
        


    }

    public function delPass(){
      $id = $this->input->post('id');
      echo $id;die;
    }

}
