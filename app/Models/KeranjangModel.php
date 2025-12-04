<?php
namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    // FIX: Menggunakan 'harga_jual' untuk sinkronisasi dengan BarangModel
    protected $allowedFields = ['id_user', 'id_barang', 'nama_barang', 'gambar', 'harga_jual', 'jumlah']; 
    
    /**
     * Menghitung total harga semua item di keranjang user tertentu.
     * @param int $idUser ID pengguna.
     * @return float Total harga keranjang.
     */
    public function getTotalKeranjang($idUser)
    {
        // Menggunakan harga_jual untuk perhitungan SUM
        $builder = $this->db->table($this->table);
        $result = $builder->select('SUM(harga_jual * jumlah) AS total_harga', false) 
            ->where('id_user', $idUser)
            ->get()
            ->getRow();
            
        return $result->total_harga ?? 0;
    }
    
    /**
     * Mengambil semua item keranjang user.
     * @param int $idUser ID pengguna.
     * @return array Daftar item keranjang.
     */
    public function getItemsKeranjang($idUser)
    {
        return $this->where('id_user', $idUser)->findAll();
    }

    /**
     * Menghapus semua item keranjang user.
     * @param int $idUser ID pengguna.
     * @return bool Hasil operasi delete.
     */
    public function hapusKeranjangByUser($idUser)
    {
        return $this->where('id_user', $idUser)->delete();
    }
}