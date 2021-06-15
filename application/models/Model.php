<?php

/**
 * 
 */
class Model extends CI_Model
{
    public function getPage($url, $jenis = '')
    {
        $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
        $numSegments = count($segments);
        $currentSegment = $segments[$numSegments - 1];

        $classActive = ($jenis == 'icon' ? ($url == $currentSegment ? 'text-yellow' : 'text-primary') : ($url == $currentSegment ? 'active' : ''));

        return $classActive;
    }

    function query($query)
    {
        $res = $this->db->query($query)->result_array();
        return $res;
    }

    function ambilData($tbl, $select = '*', $join = [], $where = [], $order = '')
    {
        $this->db->select($select);
        $this->db->from($tbl);
        if (!empty($join)) {
            foreach ($join as $val) {
                $this->db->join($val['tbl'], $val['on'], 'left');
            }
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($order != '') {
            $this->db->order_by($order);
        }
        $res = $this->db->get()->result_array();

        return $res;
    }

    function setTambah($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function setUpdate($table, $data, $where)
    {
        $this->db->set($data);
        $this->db->where($where);
        return $this->db->update($table);
    }

    function setHapus($table, $data)
    {
        return $this->db->delete($table, $data);
    }

    function cekData($tbl, $where)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get_where($tbl, $where);
        return $res->result_array()[0]['total'];
    }

    function ambilTotalData($tbl)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get($tbl);
        return $res->result_array()[0]['total'];
    }

    function cekRow($table, $val, $panjang)
    {
        $query = "SELECT * FROM $table";
        $row = $this->db->query($query)->num_rows() + 1;

        do {
            $no = str_pad($row, $panjang, '0', STR_PAD_LEFT);
            $id = $val . '-' . $no;
            $cek = "SELECT * FROM $table where id = '$id'";
            $query_cek = $this->db->query($cek)->num_rows();
            $row++;
        } while ($query_cek > 0);
        return $id;
    }

    function getWaktu()
    {
        date_default_timezone_set('Asia/Makassar');
        $waktu = date('Y-m-d H:i:s');

        return $waktu;
    }

    function getRomawi($angka)
    {
        $hsl = "";
        if ($angka < 1 || $angka > 5000) {
            // Statement di atas buat nentuin angka ngga boleh dibawah 1 atau di atas 5000
            $hsl = "Batas Angka 1 s/d 5000";
        } else {
            while ($angka >= 1000) {
                // While itu termasuk kedalam statement perulangan
                // Jadi misal variable angka lebih dari sama dengan 1000
                // Kondisi ini akan di jalankan
                $hsl .= "M";
                // jadi pas di jalanin , kondisi ini akan menambahkan M ke dalam
                // Varible hsl
                $angka -= 1000;
                // Lalu setelah itu varible angka di kurangi 1000 ,
                // Kenapa di kurangi
                // Karena statment ini mengambil 1000 untuk di konversi menjadi M
            }
        }


        if ($angka >= 500) {
            // statement di atas akan bernilai true / benar
            // Jika var angka lebih dari sama dengan 500
            if ($angka > 500) {
                if ($angka >= 900) {
                    $hsl .= "CM";
                    $angka -= 900;
                } else {
                    $hsl .= "D";
                    $angka -= 500;
                }
            }
        }
        while ($angka >= 100) {
            if ($angka >= 400) {
                $hsl .= "CD";
                $angka -= 400;
            } else {
                $angka -= 100;
            }
        }
        if ($angka >= 50) {
            if ($angka >= 90) {
                $hsl .= "XC";
                $angka -= 90;
            } else {
                $hsl .= "L";
                $angka -= 50;
            }
        }
        while ($angka >= 10) {
            if ($angka >= 40) {
                $hsl .= "XL";
                $angka -= 40;
            } else {
                $hsl .= "X";
                $angka -= 10;
            }
        }
        if ($angka >= 5) {
            if ($angka == 9) {
                $hsl .= "IX";
                $angka -= 9;
            } else {
                $hsl .= "V";
                $angka -= 5;
            }
        }
        while ($angka >= 1) {
            if ($angka == 4) {
                $hsl .= "IV";
                $angka -= 4;
            } else {
                $hsl .= "I";
                $angka -= 1;
            }
        }

        return ($hsl);
    }

    function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split    = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0] . ' ' . (isset($split[3]) ? $split[3] : '');

        return $tgl_indo;
    }
}
