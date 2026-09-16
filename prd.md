# Product Requirements Document (PRD) - Catauang (FinTrack PRO)

## 1. Ringkasan Eksekutif
Aplikasi Catauang (dengan antarmuka FinTrack PRO) adalah sistem informasi manajemen keuangan pribadi berbasis web yang terintegrasi [cite: 1]. Sistem ini memfasilitasi pengguna untuk melakukan pencatatan arus kas harian secara rutin, sekaligus mengelola target finansial melalui fitur *wishlist* secara *real-time* [cite: 1].

## 2. Latar Belakang dan Visi Produk
### 2.1 Problem Statement
Saat ini, proses pelacakan dana tabungan dan pengeluaran masih tersebar dan dilakukan secara manual (seperti menggunakan buku atau *spreadsheet* terpisah) [cite: 1]. Kendala utamanya meliputi:
* **Informasi Tersebar:** Data pengeluaran dan *wishlist* berada di platform berbeda [cite: 1].
* **Proses Lambat:** Perhitungan manual untuk kalkulasi alokasi dana memakan waktu [cite: 1].
* **Status Tidak Jelas:** Tidak ada indikator persentase pencapaian target keuangan [cite: 1].
* **Risiko Data Ganda/Hilang:** Catatan manual rentan rusak atau tidak sinkron [cite: 1].

### 2.2 Product Vision
Catauang hadir bagi individu yang membutuhkan kedisiplinan dalam mencapai target finansial, mengintegrasikan pencatatan kas harian dengan pelacakan *wishlist* [cite: 1]. Sistem ini menawarkan otomatisasi perhitungan, sinkronisasi data yang aman, serta pelaporan terpusat agar target keuangan pengguna dapat terpantau dan terealisasi secara terukur [cite: 1].

## 3. Pihak yang Terlibat (Hak Akses)
Sistem membagi pengguna ke dalam dua peran utama:
1. **User (Pengguna Utama):** Entitas yang menjadi fokus utama [cite: 1]. Memiliki akses penuh ke *Dashboard*, Pencatatan Manual, Transaksi (termasuk cetak laporan PDF/Excel/CSV), Nabung Yuk, Wishlist, Profil, dan Pengaturan Tema [cite: 1].
2. **Admin:** Bertindak sebagai pengelola sistem dan *technical support* [cite: 1]. Memiliki wewenang khusus untuk melakukan *user impersonation* (mereplikasi antarmuka pengguna) demi keperluan pemeliharaan, *debugging*, dan membantu kendala teknis pengguna [cite: 1].

## 4. Arsitektur Informasi dan User Flow
### 4.1 User Flow (Pengguna Utama)
Alur navigasi pengguna meliputi:
* **Login** \u2192 **Dashboard Web (Home)** [cite: 1].
* Dari Dashboard, pengguna dapat mengakses:
  * **Pencatatan Manual:** Input *Income* dan *Outcome* [cite: 1].
  * **Transaksi:** Mencetak laporan PDF/Excel, filter kategori, dan riwayat [cite: 1].
  * **Nabung Yuk & Wishlist:** Perhitungan harga barang dan *Notepad/Checklist* barang keinginan [cite: 1].
  * **Profile:** Pengubahan foto profil, nama pengguna, dan kata sandi [cite: 1].
  * **Option:** Pengaturan tema web, *settings*, dan *Sign Out/Logout* [cite: 1].

### 4.2 Admin Flow
* **Login** \u2192 **User Online** \u2192 **Traffic** [cite: 1].

## 5. Kebutuhan Fungsional Utama
Merujuk pada desain *wireframe* dan prototipe awal, berikut adalah fungsionalitas inti yang harus dibangun:
1. **Dashboard & Ringkasan Keuangan:** 
   * Menampilkan Total Saldo Kas (Surplus Aktif), Pemasukan Bulan Ini, Pengeluaran Bulan Ini, dan Arus Kas Bersih (Net) [cite: 1].
   * Visualisasi tren arus kas 6 bulan terakhir dalam bentuk grafik [cite: 1].
   * Menampilkan daftar transaksi terkini [cite: 1].
2. **Manajemen Transaksi:** 
   * Form pencatatan dengan input nominal, tanggal, kategori, keterangan, dan unggah bukti/struk [cite: 1].
   * Fitur filter pencarian (berdasarkan kata kunci, tipe, kategori, rentang waktu) serta ekspor ke CSV/PDF [cite: 1].
3. **Manajemen Kategori:** 
   * Kemampuan membuat, mengubah, dan menghapus (*CRUD*) kategori pengeluaran dan pemasukan [cite: 1].
4. **Laporan & Analitik:** 
   * Kalkulasi tingkat tabungan (*Savings Rate*) dan pembuatan ringkasan keuangan bulanan komprehensif [cite: 1].
5. **Nabung Yuk & Wishlist:** 
   * Modul khusus untuk menetapkan target harga barang dan sistem secara otomatis menghitung sisa dana yang dibutuhkan [cite: 1].

## 6. Rekomendasi Arsitektur Sistem & Tech Stack
Untuk merealisasikan aplikasi web yang optimal, berkinerja tinggi, dan selaras dengan lingkungan pengembangan saat ini (tanpa XAMPP):
* **Frontend/Tampilan:** Menggunakan antarmuka bawaan Laravel (Blade Templates) yang dipadukan dengan **Tailwind CSS** untuk mereplikasi prototipe desain FinTrack PRO secara presisi dan efisien.
* **Backend:** Menggunakan kerangka kerja **Laravel** (versi 11+) sebagai fondasi utama yang menangani rute, logika bisnis (*controllers*), dan keamanan sistem.
* **Database:** Menggunakan **SQLite** sebagai basis data bawaan dan ringan, sangat ideal untuk tahap pengembangan (prototyping) tanpa memerlukan instalasi eksternal seperti XAMPP atau server database terpisah.
