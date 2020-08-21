<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Pass extends MX_Controller {

    private $validlang;

    function __construct() {
        
        parent :: __construct();
        $this->frontData();

        $this->load->library("Pass_lib");
        $this->load->model("Pass/Pass_model");
        $this->load->helper("pass_front");
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['usersession'] = $this->session->userdata('pt_logged_customer');
        $this->data['passlib'] = $this->Pass_lib;
        $chk = modules :: run('Home/is_main_module_enabled', 'pass');
        $this->load->library('currconverter');
        $this->data['curr'] = $this->currconverter;
        if (!$chk) {
            Error_404($this);
        }



        $settings = $this->Settings_model->get_front_settings('pass');

        $languageid = $this->uri->segment(2);
                $this->validlang = pt_isValid_language($languageid);

                if($this->validlang){
                  $this->data['lang_set'] =  $languageid;
                }else{
                  $this->data['lang_set'] = $this->session->userdata('set_lang');
                }

        $defaultlang = pt_get_default_language();
        if (empty ($this->data['lang_set'])){
            $this->data['lang_set'] = $defaultlang;
        }



        $this->lang->load("front", $this->data['lang_set']);
        $this->Pass_lib->set_lang($this->data['lang_set']);
        // $this->data['popular_posts'] = $this->Pass_model->get_popular_posts($settings[0]->front_popular);
        $this->data['categories'] = $this->Pass_lib->getCategories();
    }

    public function index() {
        $settings = $this->Settings_model->get_front_settings('pass');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        $this->listing();
    }

    public function detail($id){
        $this->load->library('currconverter');
        $this->data['module'] = $this->Pass_model->get_pass_detail($id)[0];
        $settings = $this->Settings_model->get_front_settings('pass');
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('modules/pass/details', $this->data, $this);
    }

    function listing($offset = null) {
        $settings = $this->Settings_model->get_front_settings('pass');
        $this->data['categoryname'] = "";
        $allpass = $this->Pass_lib->show_pass($offset);
        $this->data['module'] = $allpass['all_pass'];
        $this->data['info'] = $allpass['paginationinfo'];
        $this->data['langurl'] = base_url()."pass/{langid}/";
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('modules/pass/listing', $this->data, $this);
    }

    function search($offset = null) {
        $id = $this->input->get('id_pass');
        if($id){
            $this->load->library('currconverter');
            $this->data['module'] = $this->Pass_model->get_pass_detail($id)[0];
            $settings = $this->Settings_model->get_front_settings('pass');
            $this->setMetaData( $settings[0]->header_title);
            $this->theme->view('modules/pass/details', $this->data, $this);
        }else{
        $this->data['ptype'] = "search";
        $this->data['categoryname'] = "";
        $settings = $this->Settings_model->get_front_settings('pass');
            
        $allpass = $this->Pass_model->search_pass_front($offset);
        $this->data['moduleTypes']=  $this->Pass_lib->passTypes();
        $this->data['module'] = $allpass['all'];
        $this->data['info'] = $allpass['paginationinfo'];
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('modules/pass/listing', $this->data, $this);
    }
        
    }

    function category($offset = null) {
        $settings = $this->Settings_model->get_front_settings('pass');
        $id = $this->input->get('cat');
        $this->data['ptype'] = "category";
        $this->data['categoryname'] = pt_pass_category_name($id);
        $allpass = $this->Pass_lib->category_posts($offset);
        $this->data['allpass'] = $allpass['all_posts'];
        $this->data['info'] = $allpass['paginationinfo'];
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('pass/index', $this->data, $this);
    }

    function _remap($method, $params=array()){
		$funcs = get_class_methods($this);

		if(in_array($method, $funcs)){

		return call_user_func_array(array($this, $method), $params);

		}else{
            $this->index();
		}

    }

    function invoice(){
        $this->load->library('currconverter');
        $this->data['curr']   = $this->currconverter;
        $id     = $this->input->get('id');
        $this->data['pass_order'] = $this->Pass_model->get_order_detail($id)[0];
        $settings = $this->Settings_model->get_front_settings('pass');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        
        $this->theme->view('modules/pass/invoice', $this->data, $this);
    }

    function order(){
        $id = $this->input->get('id');
        $this->data['module'] = $this->Pass_model->get_pass_detail($id)[0];
        $this->data['appModule'] = 'pass';
        $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);

        $this->theme->view('booking', $this->data, $this);
    }
    function booking(){
        if($this->session->userdata['pt_logged_customer']){
            $user_id = $this->session->userdata['pt_logged_customer'];
            $this->load->model('Admin/Accounts_model');
            $this->data['profile'] = $this->Accounts_model->get_profile_details($user_id);
        }
        $id = $this->input->post('id');
        $pass = $this->Pass_model->get_pass_detail($id)[0];
        $this->load->library('currconverter');
        $this->data['curr']   = $this->currconverter;
        $this->data['params'] = $this->input->post();
        $this->data['module'] = $this->Pass_model->get_pass_detail($id)[0];
        $this->data['appModule'] = 'pass';
        $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);

        $this->theme->view('booking', $this->data, $this);
    }

}