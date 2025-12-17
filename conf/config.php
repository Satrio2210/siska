<?php
// configuration
$dbtype		= "sqlite";
$dbhost 	= "localhost";
$dbname		= "siskadb";
$dbuser		= "siskadb";
$dbpass		= "P@ssw0rd!_";
//$dbpass   = "y3m1m4";

// database connection

try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass); 
    }
    catch (PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
    }

//database2
//$dbtype2  = "sqlite"
//$dbhost2  = "localhost"
//$dbname2  = "antrian"
//$dbuser2  = "antrian"
//$dbpass   = "P@ssw0rd!_"

//dbconnection
// try {
//     $db2 = new PDO("mysql:host=$dbhost2;dbname=$dbname2",$dbuser2,$dbpass2); 
//     }
//     catch (PDOException $e){
//     echo 'Connection db2 failed: ' . $e->getMessage();
//     }

//folder icon
//folder Logo
$judul = "Sistem Informasi Klinik Pratama";
$subjudul = "SISKA";
   
$path_logo = "img/";
$file_logo = "logo.png";
$width_logo = "50";
$height_logo = "50";


// Data Pajak
$pph22 = 1.5;

// data Fee Admin
$fee_admin = 5000;
$fee_kasir = 1000;
$fee_daftar = 1000;


// Data Fee Farmasi
$fee_resep = 10000;
$fee_racikan = 5000;
$fee_jasa_resep = 1000;
$fee_jasa_racikan = 2500;


// prosentase profit obat
$profit = 1.45;

// Data Company
$company="Klinik Pratama Yemima Medika";
$building="Ruko Town House Cagar Alam No.10";
$street = "Jl. Cagar Alam, Pancoran Mas, Depok 16436";
$city = "Depok";
$phone = "021-77814916";
$npwp = "03.234.767.1-111.022";

// Data kode Ruangan

$code_lab_room = 'LB';
$code_keb_room = 'KB';

// Data Akun Auto Jurnal Pembelian Barang Farmasi
$code_inventory = '1.3.1';
$name_inventory = 'Persediaan Barang Farmasi';

$code_vat_in = '1.4.11';
$name_vat_in = 'PPN Masukan';

$code_account_payable = '2.1.1';
$name_account_payable = 'Hutang Usaha';

$code_cash = '1.1.1';
$name_cash = 'Kas ditangan';

// Data Akun Auto Jurnal Pembayaran BHP Pasien
$code_inventory_bhp = '1.3.13';
$name_inventory_bhp = 'Persediaan BHP';

$code_vat_out = '2.2.11';
$name_vat_out = 'PPN Keluaran';

$code_account_receivable = '1.2.1';
$name_account_receivable = 'Piutang Perawatan dan Pengobatan';

$code_sale_bhp = '4.1.32';
$name_sale_bhp = 'Penjualan BHP';

$code_usage_cost = '5.1.2';
$name_usage_cost = 'Biaya Pemakaian Bahan';

$code_bni = '1.1.2';
$name_bni = 'BNI 46 1666 4455 50';

$code_bca = '1.1.3';
$name_bca = 'BCA 8691 9698 43';

$code_mandiri = '1.1.4';
$name_mandiri = 'Mandiri 157 000 734 067 3';

// Data Akun Auto Jurnal Pembayaran Resep Pasien
$code_inventory_drugs = '1.3.11';
$name_inventory_drugs = 'Persediaan Obat Medis Farmasi';

$code_sale_drugs = '4.1.31';
$name_sale_drugs = 'Penjualan Obat';

// Data Akun Auto Jurnal Jasa dan Tindakan Dokter
$code_tret_doct = '4.1.21';
$name_tret_doct = 'Jasa Tindakan Dokter';

$code_tret_nurs = '4.1.22';
$name_tret_nurs = 'Jasa Tindakan Bidan';

$code_tret_labs = '4.1.4';
$name_tret_labs = 'Jasa Laboratorium';

$code_cost_doct = '5.1.33';
$name_cost_doct = 'Biaya Tindakan Dokter';

$code_fee_admin = '4.1.11';
$name_fee_admin = 'Jasa Admin';

$code_cost_admin = '5.1.31';
$name_cost_admin = 'Biaya Jasa Admin'; 

$code_fee_resep = '4.1.12';
$name_fee_resep = 'Jasa Lain Lain';

$code_cost_resep = '5.1.35';
$name_cost_resep = 'Biaya Jasa Farmasi'; 

// Data Lokasi pengambilan Obat Resep
$gudang_farmasi = 'BOX1'; 

// Error Code
//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 'On');

// Date Now
date_default_timezone_set('Asia/Jakarta');

  $datenow = date("Y-m-d");
  $xdatenow = strtotime($datenow);
  $yearnow = date('Y',$xdatenow);
  $monthnow = date('m',$xdatenow);
  $daynow = date('d',$xdatenow);


//DATA LOGIN KE ADMIN AREA
$idadmin="ADMIN";
$passadmin=md5("wirosableng");
?>
