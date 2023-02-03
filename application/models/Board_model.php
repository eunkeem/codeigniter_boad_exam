<?php
class Board_model extends CI_Model
{
  // 개체를 통해 데이터베이스 클래스를 사용하게 함
  public function __construct()
  {
    // parent::__construct();
    $this->load->database();
  }

  public function insert_board()
  {
    $this->load->helper('date');

    $data = array(
      'title' => $this->input->post('title'),
      'contents' => $this->input->post('contents'),
      'name' => $this->input->post('name'),
    );
    $this->db->set('adddate', 'now()', FALSE);

    return $this->db->insert('board', $data);
  }

  public function getList()
  {
    $SQL = "select code, title, contents, name, adddate from board order by adddate desc ";
    $query = $this->db->query($SQL);
    return $query->result_array();
  }

}