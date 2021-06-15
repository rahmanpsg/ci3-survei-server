<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
    }

    public function generateData()
    {
        $data = $this->Model->ambilData('nama');

        $jk = ['Laki-laki', 'Perempuan'];
        $pt = ['SD', 'SMP', 'SMA/SMK', 'Diploma', 'S1', 'S2 keatas'];
        $pekerjaan = ['PNS/TNI/POLRI', 'Pegawai Swasta', 'Wiraswasta/Usahawan', 'Petani/Buruh', 'Pelajar/Mahasiswa', 'Lainnya'];

        foreach ($data as $value) {
            $value['id'] = $this->Model->cekRow('tbl_responden', 'RSP', 6);
            $value['umur'] = rand(17, 59);
            $value['jenis_kelamin'] = $jk[array_rand($jk)];
            $value['pendidikan_terakhir'] = $value['umur'] > 25 ? $pt[array_rand($pt)] : $pt[rand(0, 2)];
            $value['pekerjaan'] = $pekerjaan[array_rand($pekerjaan)];
            $value['desa'] = 'DESA-' . str_pad(rand(1, 16), 2, '0', STR_PAD_LEFT);
            print_r($value);
            $this->Model->setTambah('tbl_responden', $value);

            // 
            for ($i = 1; $i < 15; $i++) {
                $jawaban[$i] = rand(1, 100) > 30 ? rand(3, 4) : rand(1, 2);
            }
            $survei['id'] = $this->Model->cekRow('tbl_survei', 'SRV', 6);
            $survei['id_responden'] = $value['id'];
            $survei['jawaban'] = json_encode($jawaban);
            $survei['ditambahkan_pada'] = '2020-' . date('m-d', mt_rand(1, time()));
            print_r($survei);
            $this->Model->setTambah('tbl_survei', $survei);
        }
    }

    public function getDataSKM()
    {
        $tahun = $this->input->get('tahun');

        $data = $this->Model->query("SELECT jawaban, QUARTER(ditambahkan_pada) triwulan FROM tbl_survei WHERE YEAR(ditambahkan_pada) = '$tahun'");

        foreach ($data as $value) {

            $jawaban = json_decode($value['jawaban']);

            foreach ($jawaban as $k => $v) {
                $dataSurvei[$value['triwulan']][$k][] = $v;
            }
        }

        $dataUnsur = $this->Model->ambilData('tbl_unsur');

        echo json_encode(['dataSurvei' => $dataSurvei, 'dataUnsur' => $dataUnsur]);
    }

    public function getDataKarakteristik()
    {
        $jenis = $this->input->get('jenis');
        $select = "COUNT(tbl_responden.id) as total";
        $join = '';
        $group = 'jenis';
        switch ($jenis) {
            case 'Umur':
                $select .= ", case
                            when umur between 17 and 23 then '17-23 Tahun'
                            when umur between 24 and 29 then '24-29 Tahun'
                            when umur between 30 and 40 then '30-40 Tahun'
                            when umur between 40 and 100 then 'Diatas 40 Tahun'
                            end as jenis";
                break;
            case 'Jenis Kelamin':
                $select .= ", jenis_kelamin as jenis";
                break;
            case 'Pendidikan':
                $select .= ", pendidikan_terakhir as jenis";
                break;
            case 'Pekerjaan':
                $select .= ", pekerjaan as jenis";
                break;
            case 'Desa':
                $select .= ", tbl_desa.desa as jenis";
                $join = "LEFT JOIN tbl_desa ON tbl_responden.desa = tbl_desa.id";
                break;
        }

        $data = $this->Model->query("SELECT $select FROM tbl_responden $join GROUP BY $group");

        echo json_encode($data);
    }

    public function getDataPertanyaan()
    {
        $data = $this->Model->query("SELECT a.*, b.unsur FROM tbl_pertanyaan a LEFT JOIN tbl_unsur b ON a.id_unsur = b.id");

        echo json_encode($data);
    }

    public function getData()
    {
        $tbl = $this->input->get('tabel');

        $data = $this->Model->ambilData("tbl_$tbl");

        echo json_encode($data);
    }

    public function hapusData()
    {
        $tbl = $this->input->post('tabel');
        $where = $this->input->post('where');

        $hapus = $this->Model->setHapus("tbl_$tbl", $where);

        echo json_encode($hapus);
    }

    public function generateID()
    {
        $tbl = $this->input->post('tabel');
        $kode = $this->input->post('kode');
        $panjang = $this->input->post('panjang');

        echo $this->Model->cekRow($tbl, $kode, $panjang);
    }

    public function getDataResponden()
    {
        $data = $this->Model->query("SELECT a.*, b.desa, c.jawaban, c.ditambahkan_pada tanggal FROM tbl_responden a LEFT JOIN tbl_desa b ON a.desa = b.id LEFT JOIN tbl_survei c ON a.id = c.id_responden ORDER BY c.ditambahkan_pada");

        echo json_encode($data);
    }

    public function simpanSurvei()
    {
        $dataResponden = $this->input->post('responden');
        $dataSurvei = $this->input->post('survei');

        $dataResponden['id'] = $this->Model->cekRow('tbl_responden', 'RSP', '6');
        $simpanResponden = $this->Model->setTambah('tbl_responden', $dataResponden);

        $dataSurvei['id'] = $this->Model->cekRow('tbl_survei', 'SRV', '6');
        $dataSurvei['id_responden'] = $dataResponden['id'];
        $simpanSurvei = $this->Model->setTambah('tbl_survei', $dataSurvei);

        echo json_encode($simpanResponden && $simpanSurvei);
    }

    public function manajemenPertanyaan()
    {
        foreach ($_POST as $key => $value) {
            if ($key != 'aksi' && $key != 'where') {
                $data[$key] = $value;
            }
        }

        $data['jawaban'] = json_encode($data['jawaban']);

        if ($_POST['aksi'] == 'Tambah') {
            $simpan = $this->Model->setTambah('tbl_pertanyaan', $data);

            echo json_encode([$simpan, $data]);
        } elseif ($_POST['aksi'] == 'Ubah') {
            $where = $this->input->post('where');
            $ubah = $this->Model->setUpdate('tbl_pertanyaan', $data, ['no' => $where]);

            echo json_encode([$ubah, $data, $where]);
        }
    }

    public function manajemen()
    {
        foreach ($_POST as $key => $value) {
            if ($key != 'aksi' && $key != 'where' && $key != 'tabel') {
                $data[$key] = $value;
            }
        }

        $tbl = $_POST['tabel'];

        if ($_POST['aksi'] == 'Tambah') {
            $simpan = $this->Model->setTambah($tbl, $data);

            echo json_encode([$simpan, $data]);
        } elseif ($_POST['aksi'] == 'Ubah') {
            $where = $this->input->post('where');
            $ubah = $this->Model->setUpdate($tbl, $data, ['id' => $where]);

            echo json_encode([$ubah, $data, $where]);
        }
    }
}
