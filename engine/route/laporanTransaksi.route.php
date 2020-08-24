<?php

class laporanTransaksi extends Route{

    private $sn = 'laporanTransaksiData';
    private $su = 'utilityData';

    public function index()
    {
        $data['tahunAwal'] = $this -> state($this -> su) -> getSettingResto('awal_pembukuan');
        $this -> bind('dasbor/laporanTransaksi/laporanTransaksiAwal', $data);
    }

    public function laporanTransaksiTahun($tahun)
    {
        $data['tahun'] = $tahun;
        $this -> bind('dasbor/laporanTransaksi/laporanTransaksiTahun', $data);
    }

    public function laporanTransaksiBulan($tahun, $bulan){
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['tHari'] = $this -> ambilHari($bulan);
        $this -> bind('dasbor/laporanTransaksi/laporanTransaksiBulan', $data);
    }

    public function laporanTransaksiTanggal($tahun, $bulan, $tanggal)
    {
       $data['tahun'] = $tahun;
       $data['bulan'] = $bulan;
       $data['tanggal'] = $tanggal;
       $tanggalFix = $tahun."-".$bulan."-".$tanggal;
       $start = $tanggalFix." 00:00:00";
       $finish = $tanggalFix." 23:59:59";
       $data['arusKas'] = $this -> state($this -> sn) -> getTransaksiTanggal($start, $finish);
       $this -> bind('dasbor/laporanTransaksi/laporanTransaksiTanggal', $data);
    }

}