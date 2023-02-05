<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Board extends CI_Controller
{

        public function __construct()
        {
                parent::__construct();
                $this->load->model('board_model');
                // $this->load->database();
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
                $return_value = $this->board_model->insert_board();
                echo $return_value;
        }
        public function update()
        {
                $return_value = $this->board_model->update_board();
                echo $return_value;
        }
        public function delete()
        {
                $return_value = $this->board_model->delete_board();
                echo $return_value;
        }

        public function getList()
        {
                $HEADER_HTML = "
                <div class='row mt-5'>
                <div class='col-12'>
                  <table class='table container table table-striped'>
                    <thead>
                      <tr>
                        <th scope='col'>NO</th>
                        <th scope='col'>이름</th>
                        <th scope='col'>제목</th>
                        <th scope='col'>등록일</th>
                      </tr>
                    </thead>
                    <tbody>";
                $FOOTER_HTML = "
                        </tbody>
                        </table>
                </div>
                </div>
                ";
                $return_html = $HEADER_HTML;

                $return_value = $this->board_model->getList();
                $data['board'] = $return_value;
                // var_dump($data['board']);
                // exit();
                $idx = 0;
                foreach ($data['board'] as $items) {
                        $idx++;
                        $return_html .= "
                                <tr>
                                <th scope='row'>$idx</th>
                                <td>$items[name]</td>
                                <td><a style='cursor:pointer' onclick='viewBoard(\"$items[code]\")'><b>$items[title]<b></a></td>
                                <td><small>$items[adddate]</small></td>
                                </tr>
                       ";

                }
                $return_html .= $FOOTER_HTML;
                echo $return_html;
        }

        public function getView()
        {
                $data = $this->board_model->getView();
                // 실무에서는 xml로 할 것.(이 방식은 비추지만 테스트로 작성해보기 좋다)
                echo $data->name . "^" . $data->title . "^" . $data->contents . "^" . $data->adddate . "^" . $data->code;
        }


}