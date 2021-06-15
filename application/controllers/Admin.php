<?php
class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('session');

        if (!$this->session->has_userdata('hasLogin')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['totalResponden'] = $this->Model->ambilTotalData('tbl_responden');
        $data['totalUnsur'] = $this->Model->ambilTotalData('tbl_unsur');
        $data['totalRespondenTriwulan'] = $this->Model->query("SELECT COUNT(id) total FROM tbl_survei GROUP BY QUARTER(ditambahkan_pada)");
        $data['karakteristik'] = [
            'Umur' => ['17-23 Tahun', '24-29 Tahun', '30-40 Tahun', 'Diatas 40 Tahun'],
            'Jenis Kelamin' => ['Laki-laki', 'Perempuan'],
            'Pendidikan' => ['SD', 'SMP', 'SMA/SMK', 'Diploma', 'S1', 'S2 keatas'],
            'Pekerjaan' => ['PNS/TNI/POLRI', 'Pegawai Swasta', 'Wiraswasta/Usahawan', 'Petani/Buruh', 'Pelajar/Mahasiswa', 'Lainnya'],
            'Desa' => array_map(function ($v) {
                return $v['desa'];
            }, $this->Model->ambilData('tbl_desa', 'desa'))
        ];
        $data['warna'] = ['info', 'warning', 'success', 'primary'];

        $this->load->view('admin/index', $data);
    }

    public function responden()
    {
        $data['TBL_URL'] = base_url('api/getDataResponden');
        $this->load->view('admin/responden', $data);
    }

    public function unsur()
    {
        $data['TBL_URL'] = base_url('api/getData?') . http_build_query(['tabel' => 'unsur']);
        $this->load->view('admin/unsur', $data);
    }

    public function pertanyaan()
    {
        $data['TBL_URL'] = base_url('api/getDataPertanyaan');
        $data['dataUnsur'] = $this->Model->ambilData('tbl_unsur');
        $this->load->view('admin/pertanyaan', $data);
    }

    public function bidang()
    {
        $data['TBL_URL'] = base_url('api/getData?') . http_build_query(['tabel' => 'bidang']);
        $this->load->view('admin/bidang', $data);
    }

    public function desa()
    {
        $data['TBL_URL'] = base_url('api/getData?') . http_build_query(['tabel' => 'desa']);
        $this->load->view('admin/desa', $data);
    }
}
