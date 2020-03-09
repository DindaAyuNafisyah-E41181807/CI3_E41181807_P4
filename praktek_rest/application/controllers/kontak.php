<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';//mendapatkan library REST_Controller
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();// mengambil database
    }

    function index_get() {//function untuk melakukan GET
        //Metode GET menyediakan akses baca pada sumber daya yang disediakan oleh REST API. 
        //Sebagai contohnya digunakan untuk membaca data dari tabel telepon pada database kontak. 
        //Untuk membaca data dari database dapat dilakukan dengan active record yang telah disediakan Codeigniter. 
        //Sebelum membaca data dari database, fungsi GET yang akan dibuat terlebih dahulu memeriksa apakah terdapat property id pada address bar 
        //sehingga data yang ditampilkan dapat di seleksi berdasarkan id atau ditampilkan semua.
        $id = $this->get('id');
        if ($id == '') {
            $kontak = $this->db->get('telepon')->result();
        } else {
            $this->db->where('id', $id);
            $kontak = $this->db->get('telepon')->result();
        }
        $this->response($kontak, 200);
    }

    function index_post() {// function untuk bisa melakukan post 
        //Metode POST digunakan untuk mengirimkan data baru dari client ke server REST API. 
        //Sebagai contohnya digunakan untuk menambahkan kontak baru yang terdiri dari id, nama, dan nomor.
        $data = array(
                    'id'           => $this->post('id'),
                    'nama'          => $this->post('nama'),
                    'nomor'    => $this->post('nomor'));
        $insert = $this->db->insert('telepon', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put() {// function untuk bisa melakukan put
        //Metode PUT digunakan untuk memperbarui data yang telah ada di server REST API. 
        //Sebagai contohnya digunakan untuk memperbarui data dengan id 88 pada tabel telepon database kontak.
        $id = $this->put('id');
        $data = array(
                    'id'       => $this->put('id'),
                    'nama'          => $this->put('nama'),
                    'nomor'    => $this->put('nomor'));
        $this->db->where('id', $id);
        $update = $this->db->update('telepon', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() { //function untuk bisa melakukan delete
        //Metode DELETE digunakan untuk menghapus data yang telah ada di server REST API. 
        //Sebagai contohnya digunakan untuk menghapus data dengan id 88 pada tabel telepon database kontak.
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('telepon');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}
?>