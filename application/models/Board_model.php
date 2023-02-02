<?php
class Board_model extends CI_Model
{
  // 개체를 통해 데이터베이스 클래스를 사용하게 함
  public function __construct()
  {
    $this->load->database();
  }

  public function insert_board()
  {
    $this->load->helper('date');

    $data = array(
      'contents' => $this->input->post('contents'),
      'exec_date' => $this->input->post('exec_date')
    );
    $this->db->set('create_date', 'now()', FALSE);
    return $this->db->insert('', $data);
  }


}