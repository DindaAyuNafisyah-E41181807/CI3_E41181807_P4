<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// memasukkan REST_server library kita kedalam controller 
//CodeIgniter merupakan aplikasi sumber terbuka yang berupa framework PHP dengan model MVC (Model, View, Controller) untuk membangun website dinamis dengan menggunakan PHP. Dalam penerapan REST pada Codeigniter diperlukan beberapa library tambahan yang tidak disediakan secara default pada Codeigniter, 
class Rest_server extends CI_Controller {

    public function index()
    {
        $this->load->helper('url');//menggunakan helper url

        $this->load->view('rest_server');// index akan menampilkan  rest server apabila libary rest server kita sudah terpasang
    }
}
