<?php
class Grn_model extends CI_Model{
    public $jsonfile;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     // update front settings
       function update_front_settings(){
        $fdata = new stdClass();
        $fdata->showHeaderFooter = $this->input->post('showheaderfooter');

        $fdata->aid = $this->input->post('aid');
        $fdata->brandID = $this->input->post('brandid');
        $fdata->searchBoxID = $this->input->post('searchid');
        $fdata->headerTitle = $this->input->post('headertitle');

        app()->service("ModuleService")->update('Hotelscombined', 'settings', $fdata);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

      function get_front_settings(){
        $fileData = app()->service("ModuleService")->get('Hotelscombined')->settings;
        return $fileData;
      }
      function get_grn_cities($city){
        $results = $this->db->like('name',$city,'both')
            ->get('grn_cities')->result();
        return $results;
      }
      function getHotels($city){
        $this->db->where("city_code","C!".$city);
        return $this->db->get('grn_hotels')->result();
      }
      function save_invoice($data,$accounts){
        $data["created_at"] = date('Y-m-d');
        $this->db->insert('grn_bookings',$data);
        $id = $this->db->insert_id();

        foreach ($accounts as $account){
            $account["booking_id"] = $id;
            $this->db->insert('grn_booking_accounts',$account);
        }
        return $id;

      }
      function get_invoice($id){

        $this->db->where('id',$id);
        $booking = $this->db->get('grn_bookings')->row();
        $this->db->where("booking_id",$id);
        $booking->accounts = $this->db->get('grn_booking_accounts')->result();
        return $booking;
      }
      function bind_cities($result){
        $this->db->delete('grn_cities');
          $this->db->insert_batch('grn_cities', $result->cities);
      }
      function bind_hotels($result){
        foreach ($result as $item){
            $this->db->insert('grn_hotels',$item);
        }
//          $this->db->insert_batch('grn_hotels', $result);
//          dd($result);
      }
      function getCountries(){
        return $this->db->get('pt_flights_countries')->result();
      }

}
