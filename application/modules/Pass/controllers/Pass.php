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

        if($this->validlang){

                    $slug = $this->uri->segment(3);

                }else{

                    $slug = $this->uri->segment(2);
                }
        if (!empty ($slug)) {
            $this->Pass_lib->set_passid($slug);
            $this->data['details'] = $this->Pass_lib->post_details();
            $this->data['title'] = $this->Pass_lib->title;
            $this->data['desc'] = $this->Pass_lib->desc;
            $this->data['thumbnail'] = $this->Pass_lib->thumbnail;
            $this->data['date'] = $this->Pass_lib->date;
            $hits = $this->Pass_lib->hits + 1;
            $this->Pass_model->update_visits($this->data['details'][0]->post_id, $hits);
            $relatedstatus = $settings[0]->testing_mode;
            if ($relatedstatus == "1") {
                $this->data['related_posts'] = $this->Pass_model->get_related_posts($this->data['details'][0]->post_related, $settings[0]->front_related);
            }
            else {
                $this->data['related_posts'] = "";
            }
            $res = $this->Settings_model->get_contact_page_details();

            $this->data['phone'] = $res[0]->contact_phone;

            $this->data['langurl'] = base_url()."pass/{langid}/".$this->Pass_lib->slug;

            $this->setMetaData($this->Pass_lib->title,$this->data['details'][0]->post_meta_desc,$this->data['details'][0]->post_meta_keywords);

            $this->theme->view('pass/pass', $this->data, $this);
        }
        else {
            $this->listing();
        }
    }

    function listing($offset = null) {
        // $settings = $this->Settings_model->get_front_settings('pass');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        $allposts = $this->Pass_lib->show_pass($offset);
        echo '<pre>';
        print_r($allposts);
        echo '</pre>';die;
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['langurl'] = base_url()."pass/{langid}/";
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('pass/index', $this->data, $this);
    }

    function search($offset = null) {
        $this->data['ptype'] = "search";
        $this->data['categoryname'] = "";
        $settings = $this->Settings_model->get_front_settings('pass');
        $allposts = $this->Pass_lib->search_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['langurl'] = base_url()."pass/{langid}/";
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('pass/index', $this->data, $this);
    }

    function category($offset = null) {
        $settings = $this->Settings_model->get_front_settings('pass');
        $id = $this->input->get('cat');
        $this->data['ptype'] = "category";
        $this->data['categoryname'] = pt_pass_category_name($id);
        $allposts = $this->Pass_lib->category_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
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
        $this->data['order'] = $this->Pass_model->get_order_detail($id)[0];
        $settings = $this->Settings_model->get_front_settings('pass');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        
        $this->theme->view('pass/invoice', $this->data, $this);
    }

}
