<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Board extends CI_Controller
{

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
        }

        public function index()
        {
                $this->load->view('board/index');
        }

        public function board_list()
        {
                $this->load->view('board/index');
                $this->load->view('board/board_list');
        }
        public function write_ok()
        {
                $this->board_model->insert_board();
        }

/*       public function board_create()
{
$this->load->view('board/index');
$this->load->view('board/board_create');
} */


}