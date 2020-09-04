<?php
// DASBOR ROUTE 
class dasbor extends Route{
    // INISIALISASI STATE 
    private $sn = 'dasborData';
    private $su = 'utilityData';

    public function __construct()
    {
        $this -> st = new state;
    }

    public function index()
    {     
        $this -> bind('dasbor/index');   
    }

    public function beranda()
    {
        $this -> bind('dasbor/beranda');   
    }

    public function getDataBar()
    {
        $this -> state($this -> su) -> csrfCek();
        $data['pengunjung']         = $this -> state($this -> su) -> getJlhPengunjung();
        $data['pelanggan']          = $this -> state($this -> su) -> getJlhPelanggan();
        $data['rasioProfit']        = 0;
        $data['transaksiHarian']    = 0;
        $this -> toJson($data);
    }

    public function getMenuTerlaris()
    {
        $this -> state($this -> su) -> csrfCek();
        $data['menuTerlaris'] = $this -> state('utilityData') -> getMenuTerlaris();
        $this -> toJson($data);
    }

    public function getTransaksiTerakhir()
    {
        $this -> state($this -> su) -> csrfCek();
        $gtt = $this -> state('utilityData') -> getTransaksiTerakhir();
        foreach($gtt as $gt){
            $kdPesanan = $gt['kd_pesanan'];
            // AMBIL DATA CUSTOMER 
            $kdPelanggan = $this -> state('utilityData') -> getPelangganFromPesanan($kdPesanan);
            $namaPelanggan = $this -> state('utilityData') -> getNamaPelanggan($kdPelanggan);
            $arrTemp['namaPelanggan'] = $namaPelanggan;
            $arrTemp['total'] = $gt['total_final'];
            $arrTemp['waktu'] = $gt['waktu'];
            $arrTemp['kdPesanan'] = $kdPesanan;
            $data['lt'][] = $arrTemp;
        }
        $this -> toJson($data);
    }

    public function logOut()
    {
        $this -> destses();
        $this -> goto('login');
    }

}