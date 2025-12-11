<?php
namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $allowedFields = ['id_user', 'id_barang', 'nama_barang', 'gambar', 'harga_jual', 'jumlah']; 
    

    public function getTotalKeranjang($idUser)
    {
        $builder = $this->db->table($this->table);
        $result = $builder->select('SUM(harga_jual * jumlah) AS total_harga', false) 
            ->where('id_user', $idUser)
            ->get()
            ->getRow();
            
        return $result->total_harga ?? 0;
    }
    
    public function getItemsKeranjang($idUser)
    {
        return $this->where('id_user', $idUser)->findAll();
    }

    public function hapusKeranjangByUser($idUser)
    {
        return $this->where('id_user', $idUser)->delete();
    }
}