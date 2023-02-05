<?php
class Board_model extends CI_Model
{
  // 개체를 통해 데이터베이스 클래스를 사용하게 함
  public function __construct()
  {
    // parent::__construct();
    $this->load->database();
  }

  // INSERT : 게시물 DB에 저장
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
  // UPDATE : 게시물 DB에 update
  public function update_board()
  {
    $where = array(
      'code' => $this->input->post('code')
    );
    $data = array(
      'title' => $this->input->post('title'),
      'contents' => $this->input->post('contents')
    );

    return $this->db->update('board', $data, $where);
  }
  // DELETE : 게시물 DB에 delete
  public function delete_board()
  {
    $where = array(
      'code' => $this->input->post('code')
    );

    return $this->db->delete('board', $where);
  }
  // SELECT : DB에서 board 테이블 전부 가져오기
  public function getList()
  {
    $SQL = "select code, title, contents, name, adddate from board order by adddate desc ";
    $query = $this->db->query($SQL);
    return $query->result_array();
  }

  // SELECT ~ WHERE : 제목클릭하면 해당 게시물만 가져오기
  public function getView()
  {
    $CODE = $this->input->post('CODE');
    $SQL = "select code, title, contents, name, adddate from board where code= '$CODE'";
    $query = $this->db->query($SQL);
    return $query->row();
  }
}