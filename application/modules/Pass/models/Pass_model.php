<?php

class Pass_model extends CI_Model {
		public $langdef;

		function __construct() {
// Call the Model constructor
				parent :: __construct();
				$this->langdef = DEFLANG;
		}

// pass category name
		function category_name($id) {
				$this->db->where('slug', $id);
				$res = $this->db->get('pt_pass_categories')->result();
				return $res[0]->name;
		}


// Search posts from home page
		function search_pass_front($perpage = null, $offset = null, $orderby = null, $cities = null) {
				$data = array();
				$search_params = [
				    'name'        => $this->input->get('name'),
				    'type'        => $this->input->get('type'),
				    'category_id' => $this->input->get('category'),
				    'ammount'     => $this->input->get('price')
				  ];
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_pass.*,pt_pass_categories.name as category_name');
				if ($orderby == "za") {
						$this->db->order_by('pt_pass.name', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_pass.name', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_pass.id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_pass.id', 'desc');
				}
				foreach ($search_params as $key => $value) {
					if($value && $value != ''){
						$this->db->where('pt_pass.' . $key, $value);
					}
				}
				$this->db->group_by('pt_pass.id');
				$this->db->join('pt_pass_categories', 'pt_pass.category_id = pt_pass_categories.id', 'left');
				$this->db->where('pt_pass.status', 'Yes');
				$query = $this->db->get('pt_pass', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// get count of posts per category
		function category_posts_count($id) {
				$this->db->where('post_category', $id);
				$this->db->where('post_status', 'Yes');
				return $this->db->get('pt_pass')->num_rows();
		}

//update pass visits count
		function update_visits($id, $hits) {
				$data = array('post_visits' => $hits);
				$this->db->where('post_id', $id);
				$this->db->update('pt_pass', $data);
		}


// get default image of post
		function post_thumbnail($id) {
				$this->db->where('post_id', $id);
				$res = $this->db->get('pt_pass')->result();
				if (!empty ($res)) {
						return $res[0]->post_img;
				}
				else {
						return '';
				}
		}


// update front settings
		function update_front_settings() {
				$ufor = $this->input->post('updatefor');
				$data = array('front_icon' => $this->input->post('page_icon'), 'front_popular' => $this->input->post('popular'), 'front_homepage' => $this->input->post('home'), 'front_homepage_order' => $this->input->post('order'), 'front_latest' => $this->input->post('latest'),
				'front_listings' => $this->input->post('listings'), 'front_listings_order' => $this->input->post('listingsorder'), 'front_search' => $this->input->post('searchresult'), 'front_search_order' => $this->input->post('searchorder'), 'front_related' => $this->input->post('related'),
				'testing_mode' => $this->input->post('relatedstatus'), 'linktarget' => $this->input->post('target'), 'header_title' => $this->input->post('headertitle'), 'front_homepage_hero' => $this->input->post('showonhomepage'));
				$this->db->where('front_for', $ufor);
				$this->db->update('pt_front_settings', $data);
				$this->session->set_flashdata('flashmsgs', "Updated Successfully");
		}

// add Post data
		function add_post($filename_db = null) {
				if (empty ($filename_db)) {
						$filename_db = "";
				}
				$this->db->select("post_id");
				$this->db->order_by("post_id", "desc");
				$query = $this->db->get('pt_pass');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$postlastid = 1;
				}
				else {
						$postlastid = $lastid[0]->post_id + 1;
				}

              $postslug = $this->input->post('slug');
              if(empty($postslug)){
              $postslug = $this->makeSlug($this->input->post('title'),$postlastid);
              }else{
              $postslug = $this->makeSlug($postslug,$postlastid);
              }


				$postcount = $query->num_rows();
				$postorder = $postcount + 1;

				$relatedposts = @ implode(",", $this->input->post('relatedposts'));
				$data = array('post_title' => $this->input->post('title'),
                'post_slug' => $postslug,
                'post_desc' => $this->input->post('desc'),
                'post_category' => $this->input->post('category'),
                'post_meta_keywords' => $this->input->post('keywords'),
                'post_meta_desc' => $this->input->post('metadesc'),
                'post_status' => $this->input->post('status'),
                'post_related' => $relatedposts,
                'post_order' => $postorder,
                'post_img' => $filename_db,
                'post_created_at' => time(),
                'post_updated_at' => time());
				$this->db->insert('pt_pass', $data);
                $postid = $this->db->insert_id();
                $this->add_translation($this->input->post('translated'),$postid);
		}

		function add_pass(){
			$data = array(
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status'),
				'type' => $this->input->post('type'),
				'category_id' => $this->input->post('category_id'),
				'sales_date' => convert_to_unix($this->input->post('sales_date')),
				'ammount' => $this->input->post('ammount'),
				'note' => $this->input->post('note'),
				'html_note' => $this->input->post('html_note'),
			);

			$this->db->insert('pt_pass', $data);

			$passid = $this->db->insert_id();
			$this->add_translation($this->input->post('translated'),$passid);
			return $passid;
		}

// update Post data
		function update_pass($id, $filename_db = null) {
			$data = array(
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status'),
				'type' => $this->input->post('type'),
				'category_id' => $this->input->post('category_id'),
				'sales_date' => convert_to_unix($this->input->post('sales_date')),
				'ammount' => $this->input->post('ammount'),
				'note' => $this->input->post('note'),
				'html_note' => $this->input->post('html_note'),
			);

			$this->db->where('id', $id);
			$this->db->update('pt_pass', $data);
			$this->update_translation($this->input->post('translated'),$id);
		}

// get all categories back all count records
		function get_all_categories_back() {
				$this->db->order_by('id', 'desc');
				$query = $this->db->get('pt_pass_categories');
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all categories back limit
		function get_all_categories_back_limit($perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->order_by('id', 'desc');
				$query = $this->db->get('pt_pass_categories', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all categories info  by advance search
		function adv_search_all_categories_back_limit($data, $perpage = null, $offset = null, $orderby = null) {
				$status = $data["status"];
				$cattitle = $data["cattitle"];
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if (!empty ($cattitle)) {
						$this->db->like('name', $cattitle);
				}
				$this->db->where('status', $status);
				$this->db->order_by('id', 'desc');
				$query = $this->db->get('pt_pass_categories', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// Get all enalbed categores only
		function get_enabled_categories() {
				$this->db->where('status', 'Yes');
				return $this->db->get('pt_pass_categories')->result();
		}

// add category
		function addcategory() {
				$this->db->select("id");
				$this->db->order_by("id", "desc");
				$query = $this->db->get('pt_pass_categories');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$catlastid = 1;
				}
				else {
						$catlastid = $lastid[0]->id + 1;
				}
				$this->db->select("id");
				$this->db->where("name", $this->input->post('name'));
				$queryc = $this->db->get('pt_pass_categories')->num_rows();
				if ($queryc > 0) {
						$slug = create_url_slug($this->input->post('name')) . "-" . $catlastid;
				}
				else {
						$slug = create_url_slug($this->input->post('name'));
				}
				$data = array('name' => $this->input->post('name'), 'status' => $this->input->post('status'));
				$this->db->insert('pt_pass_categories', $data);
                $catid = $this->db->insert_id();
                $this->updatePassCategoryTranslation($this->input->post('translated'),$catid);
		}

		function updatecategory() {
				$id = $this->input->post('categoryid');
				$this->db->select("id");
				$this->db->order_by("id", "desc");
				$query = $this->db->get('pt_pass_categories');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$catlastid = 1;
				}
				else {
						$catlastid = $lastid[0]->id + 1;
				}
				$this->db->select("id");
				$data = array('name' => $this->input->post('name'), 'status' => $this->input->post('status'));
				$this->db->where('id', $id);
				$this->db->update('pt_pass_categories', $data);
                $this->updatePassCategoryTranslation($this->input->post('translated'),$id);
		}

// Delete category
		function delete_cat($catid) {
				$this->db->where('id', $catid);
				$this->db->delete('pt_pass_categories');

				$this->db->where('category_id', $catid);
				$this->db->delete('pt_pass');

                $this->db->where('category_id', $catid);
				$this->db->delete('pt_pass_categories_translation');
		}
// Disable category

		public function disable_cat($id) {
				$data = array('status' => '0');
				$this->db->where('id', $id);
				$this->db->update('pt_pass_categories', $data);
		}
// Disable post

		public function disable_post($id) {
				$data = array('post_status' => 'No');
				$this->db->where('post_id', $id);
				$this->db->update('pt_pass', $data);
		}
// Enable category

		public function enable_cat($id) {
				$data = array('status' => '1');
				$this->db->where('id', $id);
				$this->db->update('pt_pass_categories', $data);
		}
// Enable post

		public function enable_post($id) {
				$data = array('post_status' => 'Yes');
				$this->db->where('post_id', $id);
				$this->db->update('pt_pass', $data);
		}

// get all posts for related selection for backend
		function select_related_posts($id = null) {
				$this->db->select('post_title,post_id');
				if (!empty ($id)) {
						$this->db->where('post_id !=', $id);
				}
				return $this->db->get('pt_pass')->result();
		}

		function pass_photo($id = null) {

        $tempFile = $_FILES['defaultphoto']['tmp_name'];
						$fileName = $_FILES['defaultphoto']['name'];
						$fileName = str_replace(" ", "-", $_FILES['defaultphoto']['name']);
						$fig = rand(1, 999999);

						if (strpos($fileName,'php') !== false) {

						}else{

						$saveFile = $fig . '_' . $fileName;

						$targetPath = PT_pass_IMAGES_UPLOAD;

						$targetFile = $targetPath . $saveFile;
						move_uploaded_file($tempFile, $targetFile);
							if (!empty ($id)) {
										$this->update_post($id, $saveFile);
										$oldimg = $this->input->post('defimg');
										if (!empty ($oldimg)) {
												@ unlink(PT_pass_IMAGES_UPLOAD . $oldimg);
										}

								}
								else {
										$this->add_post($saveFile);

								}

							}


		}

// get file extension
		function __getExtension($str) {
				$i = strrpos($str, ".");
				if (!$i) {
						return "";
				}
				$l = strlen($str) - $i;
				$ext = substr($str, $i + 1, $l);
				return $ext;
		}

// update post order
		function update_post_order($id, $order) {
				$data = array('post_order' => $order);
				$this->db->where('post_id', $id);
				$this->db->update('pt_pass', $data);
		}

// get all data of single post by slug
		function get_pass_data($id) {
				$this->db->where('id', $id);
				return $this->db->get('pt_pass')->result();
		}

		function delete_pass($id) {
				$this->db->where('id', $id);
				$this->db->delete('pt_pass');

                // $this->db->where('item_id', $id);
				// $this->db->delete('pt_pass_translation');
		}

// Delete Post Images
		function delete_image($id) {
				$this->db->where('post_id', $id);
				$res = $this->db->get('pt_pass')->result();
				$img = $res[0]->post_img;
				if (!empty ($img)) {
						@ unlink(PT_pass_IMAGES_UPLOAD . $img);
				}
		}

// update translated data os some fields in english
		function update_english($id) {
				$cslug = create_url_slug($this->input->post('title'));
				$this->db->where('post_slug', $cslug);
				$this->db->where('post_id !=', $id);
				$nums = $this->db->get('pt_pass')->num_rows();
				if ($nums > 0) {
						$cslug = $cslug . "-" . $id;
				}
				else {
						$cslug = $cslug;
				}
				$data = array('post_title' => $this->input->post('title'), 'post_slug' => $cslug, 'post_desc' => $this->input->post('desc'));
				$this->db->where('post_id', $id);
				$this->db->update('pt_pass', $data);
				return $cslug;
		}


      // Adds translation of some fields data
		function add_translation($postdata,$id) {
		  foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
				$desc = $val['desc'];
				$keywords = $val['keywords'];
				$metadesc = $val['metadesc'];

				$data = array(
					'trans_title' => $title,
					'trans_desc' => $desc,
					'metakeywords' => $keywords,
					'metadesc' => $metadesc,
					'item_id' => $id,
					'trans_lang' => $lang
                );
				$this->db->insert('pt_pass_translation', $data);
                }
			}
		}

        // Update translation of some fields data
		function update_translation($postdata,$id){

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];
				$metadesc = $val['metadesc'];
				$kewords = $val['keywords'];
                $transAvailable = $this->getBackPassTranslation($lang,$id);

                if(empty($transAvailable)){
                 $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_meta_desc' => $metadesc,
                'trans_keywords' => $kewords,
                'item_id' => $id,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_pass_translation', $data);

                }else{
                 $data = array(
                'content_page_title' => $title,
                'content_body' => $desc,
                'content_meta_desc' => $metadesc,
                'content_meta_keywords' => $kewords,
                );
				$this->db->where('content_page_id', $id);
				$this->db->where('content_lang_id', $lang);
			    $this->db->update('pt_cms_content', $data);

                 $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_meta_desc' => $metadesc,
                'trans_keywords' => $kewords,
                       );
				$this->db->where('item_id', $id);
				$this->db->where('trans_lang', $lang);
				$this->db->update('pt_pass_translation', $data);

                }


              }

                }
		}

    function getBackPassTranslation($lang, $id) {
				$this->db->where('trans_lang', $lang);
				$this->db->where('item_id', $id);
				return $this->db->get('pt_pass_translation')->result();
		}

    function makeSlug($title,$postlastid = null){
                        $slug = create_url_slug($title);
                        $this->db->select("post_id");
						$this->db->where("post_slug", $slug);
                        if(!empty($postlastid)){
                         $this->db->where('post_id !=',$postlastid);
                        }
						$queryc = $this->db->get('pt_pass')->num_rows();
						if ($queryc > 0) {
								$slug = $slug."-".$postlastid;
						}
                        return $slug;
    }


     function updatePassCategoryTranslation($postdata,$id) {

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $name = $val['name'];

                $transAvailable = $this->getPassCatsTranslation($lang,$id);

                if(empty($transAvailable)){
                 $data = array(
					'trans_name' => $name,
					'category_id' => $id,
					'trans_lang' => $lang
                );
				$this->db->insert('pt_pass_categories_translation', $data);

                }else{

                 $data = array(
                	'trans_name' => $name
                );
				$this->db->where('category_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_pass_categories_translation', $data);

              }


              }

                }
		}


         function getPassCatsTranslation($lang,$id){
            $this->db->where('trans_lang',$lang);
            $this->db->where('category_id',$id);
            return $this->db->get('pt_pass_categories_translation')->result();

		}

		function get_pass_detail($id){
			$this->db->select('pt_pass.*,pt_pass_categories.name as category_name');
			$this->db->join('pt_pass_categories', 'pt_pass.category_id = pt_pass_categories.id', 'left');
			$this->db->where('pt_pass.id', $id);
			$this->db->where('pt_pass.status', 'Yes');
			$query = $this->db->get('pt_pass');

			return $query->result();
		}
		
		function get_order_detail($id){
			$this->db->select('pt_pass_booking.*, pt_pass.ammount, pt_pass.name as pass_name, pt_pass.type as type, pt_pass_categories.name as category_name');
			$this->db->where('pt_pass_booking.id', $id);
			$this->db->join('pt_pass', 'pt_pass.id = pt_pass_booking.pass_id', 'left');
			$this->db->join('pt_pass_categories', 'pt_pass.category_id = pt_pass_categories.id', 'left');
            return $this->db->get('pt_pass_booking')->result();
		}

		function list_pass_front($perpage = null, $offset = null, $orderby = null) {
			$data = array();
			if ($offset != null) {
					$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
			}
			$this->db->select('pt_pass.*,pt_pass_categories.name as category_name');
			if ($orderby == "za") {
					$this->db->order_by('pt_pass.name', 'desc');
			}
			elseif ($orderby == "az") {
					$this->db->order_by('pt_pass.name', 'asc');
			}
			elseif ($orderby == "oldf") {
					$this->db->order_by('pt_pass.id', 'asc');
			}
			elseif ($orderby == "newf") {
					$this->db->order_by('pt_pass.id', 'desc');
			}

			$this->db->join('pt_pass_categories', 'pt_pass.category_id = pt_pass_categories.id', 'left');
			$this->db->where('pt_pass.status', 'Yes');
			$query = $this->db->get('pt_pass', $perpage, $offset);
			$data['all'] = $query->result();
			$data['rows'] = $query->num_rows();
			return $data;
	}

	function doGuestBooking(){
		
		$response = null;
		$data = [
			'pass_id' => $this->input->post('itemid'),
			'quantity' => $this->input->post('quantity'),
			'total'		=> $this->input->post('quantity') * $this->input->post('price'),
			'fullname' => $this->input->post('firstname') . ' ' . $this->input->post('lastname'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'country' => $this->input->post('country'),
			'notes' => $this->input->post('additionalnotes')
		];

		$this->db->insert('pt_pass_booking', $data);

		$response = $this->db->insert_id();

		return $response;
	}

}
