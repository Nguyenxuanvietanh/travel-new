<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

class Passback extends MX_Controller {
	public $accType = "";
	public $langdef;
	public  $editpermission = true;
	public  $deletepermission = true;
	public $role;

	function __construct() {
		$seturl = $this->uri->segment(3);
		if ($seturl != "settings") {
			$chk = modules :: run('Home/is_main_module_enabled', 'pass');
			if (!$chk) {
				redirect("admin");
			}
		}
		$checkingadmin = $this->session->userdata('pt_logged_admin');
		$this->accType = $this->session->userdata('pt_accountType');
		$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    	$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');

		$this->role = $this->session->userdata('pt_role');
		$this->data['role'] = $this->role;

		if (!empty ($checkingadmin)) {
			$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
		}
		else {
			$this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
		}
		if (empty ($this->data['userloggedin'])) {
			redirect("admin");
		}
		if (!empty ($checkingadmin)) {
			$this->data['adminsegment'] = "admin";
		}
		else {
			$this->data['adminsegment'] = "supplier";
		}
		if (empty($this->data['isSuperAdmin'])) {

				redirect('admin');
		}


		$this->data['c_model'] = $this->countries_model;
		$this->data['addpermission'] = true;
		if($this->accType == "supplier"){
			$this->editpermission = pt_permissions("editpass", $this->data['userloggedin']);
			$this->deletepermission = pt_permissions("deletepass", $this->data['userloggedin']);
			$this->data['addpermission'] = pt_permissions("addpass", $this->data['userloggedin']);
		}
		$this->load->helper('settings');
		$this->load->helper('Pass/pass_front');
		$this->load->model('Pass/Pass_model');
		$this->load->library('Ckeditor');
		$this->data['ckconfig'] = array();
		$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
		$this->data['ckconfig']['language'] = 'en';
		$this->data['ckconfig']['height'] = '350px';
		$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
		$this->langdef = DEFLANG;
		$this->data['languages'] = pt_get_languages();
	}

	function index() {

		$this->load->helper('xcrud');
		$xcrud = xcrud_get_instance();
		$xcrud->table('pt_pass');
		$xcrud->label('name', 'Name')
				->label('sales_date', 'Sales date')
				->label('type', 'Type')
				->label('category_id', 'Category')
				->label('note', 'Notes')
				->label('html_note', 'HTML Notes');
		$xcrud->column_callback('sales_date', 'fmtDateTime');

		if ($this->editpermission) {
			$xcrud->button(base_url() . $this->data['adminsegment'] . '/pass/manage/{id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
			$xcrud->column_pattern('name', '<a href="' . base_url() . $this->data['adminsegment'] . '/pass/manage/{id}' . '">{value}</a>');
		}
		if($this->deletepermission){
			$delurl = base_url().'admin/ajaxcalls/delPass';
			$xcrud->button("javascript: delfunc('{id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self'));
		}
		$xcrud->limit(50);
		$xcrud->unset_add();
		$xcrud->unset_edit();
		$xcrud->unset_remove();
		$xcrud->unset_view();

		$this->data['add_link'] = base_url().'admin/pass/add';
		$this->data['content'] = $xcrud->render();
		$this->data['page_title'] = 'Pass Management';
		$this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_pass';
        $this->data['main_key'] = 'id';
		$this->data['header_title'] = 'Pass Management';
		$this->load->view('template', $this->data);

	}

	function add() {

		$action = $this->input->post('action');

		if ($action == "add") {
			// $this->form_validation->set_rules('title', 'Post Title', 'trim|required');
			// $this->form_validation->set_rules('pageslug', 'Post Slug', 'trim');
			// $this->form_validation->set_rules('keywords', 'Meta Keywords', 'trim');
			// $this->form_validation->set_rules('metadesc', 'Meta Description', 'trim');
			// $this->form_validation->set_rules('desc', 'Post Content', 'trim|required');
			// if ($this->form_validation->run() == FALSE) {
			// }
			// else {
				
			// }
			$passid = $this->Pass_model->add_pass();

			$this->session->set_flashdata('flashmsgs', 'Pass added Successfully');
			redirect('admin/pass');
		}
		$this->data['action'] = "add";
		$this->data['categories'] = $this->Pass_model->get_enabled_categories();
		$this->data['main_content'] = 'Pass/manage';
		$this->data['page_title'] = 'Add Pass';
		$this->load->view('Admin/template', $this->data);
	}

	function settings() {
		$this->load->model('admin/settings_model');
		$updatesett = $this->input->post('updatesettings');
		if (!empty ($updatesett)) {
			$this->Pass_model->update_front_settings();
			redirect('admin/pass/settings');
		}
		$this->data['settings'] = $this->Settings_model->get_front_settings("pass");
		$this->data['main_content'] = 'Pass/settings';
		$this->data['page_title'] = 'Pass Settings';
		$this->load->view('Admin/template', $this->data);
	}

	function manage($id) {
		if (empty ($id)) {
			redirect('admin/pass');
		}
		$updatepost = $this->input->post('action');
		
		$this->data['action'] = "update";
		if ($updatepost == "update" ) {
			$this->Pass_model->update_pass($id);
			$this->session->set_flashdata('flashmsgs', 'Post Updated Successfully');
			redirect('admin/pass');
		}
		else {
			$this->data['pass_data'] = $this->Pass_model->get_pass_data($id);
			if (empty ($this->data['pass_data'])) {
				redirect('admin/pass');
			}

			$this->data['related_selected'] = explode(",", $this->data['pdata'][0]->post_related);
			// $this->data['all_posts'] = $this->Pass_model->select_related_posts($this->data['pdata'][0]->id);
			$this->data['categories'] = $this->Pass_model->get_enabled_categories();
			$this->data['main_content'] = 'Pass/manage';
			$this->data['page_title'] = 'Manage Post';
			$this->load->view('Admin/template', $this->data);
		}
	}

	function category() {
		$this->load->helper('xcrud');
		$updatecat = $this->input->post('updatecat');
		if(!empty($updatecat)){
			$this->Pass_model->updatecategory();
			redirect('admin/pass/category');
		}

		$addcat = $this->input->post('addcat');

		if(!empty($addcat)){
			$this->Pass_model->addcategory();
			redirect('admin/pass/category');
		}
		$xcrud = xcrud_get_instance();

		$xcrud->table('pt_pass_categories');
		$xcrud->order_by('id','desc');
		$xcrud->columns('name,status');
		$xcrud->label('name','Name')->label('status','Status');
		$xcrud->button('#cat{id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
		$delurl = base_url().'admin/ajaxcalls/delPassCat';
        $xcrud->button("javascript: delfunc('{id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self'));


		$xcrud->unset_add();
		$xcrud->unset_edit();
		$xcrud->unset_remove();
		$xcrud->unset_view();
		$this->data['categories'] = $this->Pass_model->get_all_categories_back();

		$this->data['content'] = $xcrud->render();
		$this->data['page_title'] = 'Pass Categories';
		$this->data['main_content'] = 'blog_categories_view';
		$this->data['header_title'] = 'Pass Categories';
        $this->data['table_name'] = 'pt_pass_categories';
        $this->data['main_key'] = 'id';
		$this->load->view('template', $this->data);
	}

	function translate($passslug, $lang = null) {
		$this->load->library('Pass/Pass_lib');
		$this->Pass_lib->set_passid($passslug);
		$add = $this->input->post('add');
		$update = $this->input->post('update');
		if (empty ($lang)) {
			$lang = $this->langdef;
		}
		else {
			$lang = $lang;
		}
		if (empty ($passslug)) {
			redirect('admin/pass/');
		}
		if (!empty ($add)) {
			$language = $this->input->post('langname');
			$postid = $this->input->post('postid');
			$this->Pass_model->add_translation($language, $postid);
			redirect("admin/pass/translate/" . $passslug . "/" . $language);
		}
		if (!empty ($update)) {
			$slug = $this->Pass_model->update_translation($lang, $passslug);
			redirect("admin/pass/translate/" . $slug . "/" . $lang);
		}
		$cdata = $this->Pass_lib->post_details();
		if ($lang == $this->langdef) {
			$passdata = $this->Pass_lib->post_short_details();
			$this->data['passdata'] = $passdata;
			$this->data['transdesc'] = $passdata[0]->post_desc;
			$this->data['transtitle'] = $passdata[0]->post_title;
		}
		else {
			$passdata = $this->Pass_lib->translated_data($lang);
			$this->data['passdata'] = $passdata;
			$this->data['transid'] = $passdata[0]->trans_id;
			$this->data['transdesc'] = $passdata[0]->trans_desc;
			$this->data['transtitle'] = $passdata[0]->trans_title;
		}
		$this->data['postid'] = $this->Pass_lib->get_id();
		$this->data['lang'] = $lang;
		$this->data['slug'] = $passslug;
		$this->data['language_list'] = pt_get_languages();
		$this->data['main_content'] = 'Pass/translate';
		$this->data['page_title'] = 'Translate Post';
		$this->load->view('Admin/template', $this->data);
	}

	function orders(){
		$this->load->helper('xcrud');
		$xcrud = xcrud_get_instance();
		$xcrud->table('pt_pass_booking');
		$xcrud->join('pass_id', 'pt_pass', 'id');
		$xcrud->order_by('id', 'asc');
		$xcrud->columns('fullname,email,phone,pt_pass.name,pt_pass.ammount');
		$xcrud->label('fullname', 'Full Name')->label('email', 'Email')->label('phone', 'Phone')->label('pt_pass.name', 'Pass')->label('pt_pass.ammount', 'Price');
		$xcrud->button(base_url() . 'pass/invoice/?id={id}', 'View Invoice', 'fa fa-search-plus', 'btn btn-primary', array('target' => '_blank'));
		$xcrud->label('fullname', 'Name')->label('email', 'Email')->label('phone', 'Phone');
		$xcrud->unset_add();
		$xcrud->unset_edit();
		$xcrud->unset_remove();
		$xcrud->unset_view();

		$this->data['content'] = $xcrud->render();
		$this->data['page_title'] = 'Pass Booking Management';
		$this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_pass_booking';
        $this->data['main_key'] = 'id';
		$this->data['header_title'] = 'Pass Booking Management';
		$this->load->view('template', $this->data);
	}

}
