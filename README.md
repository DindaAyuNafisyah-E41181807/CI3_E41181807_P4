# DOKUMENTASI PRAKTIKUM 4 CODEIGNITER SERVER

## PERSYARATAN
Berikut adalah persyaratan untuk dapat menjalankan codeigniter server, yaitu :
1. Mmenggunakan PHP 7.2.28 atau lebih tinggi
2. XAMPP 7.2.28 atau lebih tinggi
3. Code Igniter 3.1.11
4. Visual Studio Code atau text editor lainnya
5. Aplikasi Postman

## INSIALASI YANG DILAKUKAN 
1.Codeigniter dan library REST server yang diperlukan dapat diunduh di https://github.com/chriskacerguis/codeigniter-restserver      atau di https://github.com/ardisaurus/ci-restserver.
2. Lakukan download Code Igniter CodeIgniter.
3. Kemudian ekstrak Code Igniter kedalam folder yang telah dibuat.
4. Buka folder yang berisi Code Igniter dengan Text Editor anda.

## PENGGUNAAN
Pastikan semua yang dibutuhkan telah disiapkan, kemudian extract Codeigniter dan library REST server yang telah didownload dan pindah ke htdocs pada direktori xampp lalu rename folder Codeigniter dan library REST server menjadi rest_ci atau sesuai keingina anda.

### 1. Melakukan Konfigurasi Database

Silakan mebuat database baru dengan nama "kontak". Kemudian di dalam database kontak buat tabel baru dengan nama "telepon" dengan field id (int 11 AUTO_INCREMENT), nama (varchar 30), nomor (varchar 11):

``` bash
CREATE DATABASE kontak;
```
``` bash
USE kontak;
CREATE TABLE IF NOT EXISTS `telepon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `nomor` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
```
Isikan tabel tersebut dengan data misal :

``` bash
USE kontak;
INSERT INTO `telepon` (`id`, `nama`, `nomor`) VALUES
(1, 'Orion', '08576666762'),
(2, 'Mars', '08576666770'),
(7, 'Alpha', '08576666765');
```
Selanjutnya, lakukan pengaturan database di application/database.php di folder codeigniter anda, sebagai berikut :

``` bash
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'kontak',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

### 2. Membuat Controller
Buat file php baru di di rest_ci/application/controller dengan nama kontak.php, sebagai berikut :
```bash
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $kontak = $this->db->get('telepon')->result();
        } else {
            $this->db->where('id', $id);
            $kontak = $this->db->get('telepon')->result();
        }
        $this->response($kontak, 200);
    }

    function index_post() {
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

    function index_put() {
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

    function index_delete() {
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
```
### 3. Mencoba Get Post,Put,Delete menggunakan bantuan aplikasi Postman
 
 1. GET 
    Metode GET menyediakan akses baca pada sumber daya yang disediakan oleh REST API. Sebagai contohnya digunakan untuk membaca data dari tabel telepon pada database kontak. Untuk membaca data dari database dapat dilakukan dengan active record yang telah disediakan Codeigniter. Sebelum membaca data dari database, fungsi GET yang akan dibuat terlebih dahulu memeriksa apakah terdapat property id pada address bar sehingga data yang ditampilkan dapat di seleksi berdasarkan id atau ditampilkan semua.
    Untuk menguji kode yang telah dibuat buka Postman, **Pilih metode GET, masukan http://127.0.0.1/rest_ci/index.php/kontak pada address bar lalu klik "Send"**.
    
 2. POST
    Metode POST digunakan untuk mengirimkan data baru dari client ke server REST API. Sebagai contohnya digunakan untuk menambahkan   kontak baru yang terdiri dari id, nama, dan nomor.
 Untuk mengujinya buka Postman, **pilih metode POST, masukan http://127.0.0.1/rest_ci/index.php/kontak pada address bar, klik "Body" pada menu dibawah address bar, pilih x-www-form-urlencoded, masukan key dan value yang diperlukan (id, nama, nomor), lalu klik "Send"**.

3. PUT
    Metode PUT digunakan untuk memperbarui data yang telah ada di server REST API. Sebagai contohnya digunakan untuk memperbarui data dengan id 88 pada tabel telepon database kontak.Untuk mengujinya buka Postman,**pilih metode PUT, masukan http://127.0.0.1/rest_ci/index.php/kontak pada address bar, klik "Body" pada menu dibawah address bar, pilih x-www-form-urlencoded, masukan key id dan value id yang akan diubah (88) diikuti key dan value selanjutnya, lalu klik "Send"**.
    
4. DELETE
    Metode DELETE digunakan untuk menghapus data yang telah ada di server REST API. Sebagai contohnya digunakan untuk menghapus data dengan id 88 pada tabel telepon database kontak.Untuk mengujinya buka Postman, **pilih metode DELETE, masukan http://127.0.0.1/rest_ci/index.php/kontak pada address bar, klik "Body" pada menu dibawah address bar, pilih x-www-form-urlencoded, masukan key id dan value id yang akan dihapus (88), lalu klik "Send"**.


  
    
    










