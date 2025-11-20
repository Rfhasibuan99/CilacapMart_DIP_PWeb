# TODO: Implementasi Fitur Keranjang dan Pesanan

## Langkah-langkah Utama:
1. **Migrasi Database**
   - Buat migrasi untuk tabel `pesanan` dan `detail_pesanan`
   - Tambahkan kolom role di tabel users jika belum ada

2. **Model**
   - Buat PesananModel untuk mengelola data pesanan
   - Update KeranjangModel jika perlu

3. **Controller**
   - Buat Pesanan controller untuk mengelola pesanan
   - Update Keranjang controller untuk fungsi checkout

4. **View**
   - Buat view untuk daftar pesanan
   - Buat view untuk detail pesanan
   - Update view keranjang untuk tombol checkout

5. **Routes**
   - Tambahkan routes untuk pesanan

6. **Role Admin dan User**
   - Implementasi role-based access
   - View berbeda untuk admin dan user

7. **Integrasi dengan Toko**
   - Pastikan pesanan bisa dari toko1-toko5
   - Update model toko untuk integrasi

8. **Testing**
   - Test alur keranjang ke pesanan
   - Test role admin dan user

## Status:
- [x] Migrasi database
- [x] PesananModel
- [x] Pesanan controller
- [x] View pesanan
- [x] Update Keranjang controller
- [x] Routes
- [ ] Role implementation
- [ ] Integrasi toko
- [ ] Testing
