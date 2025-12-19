# 🔌 Sistem Monitoring Unit UP2D Pasundan

Aplikasi web untuk mengelola dan memantau unit-unit operasional PLN UP2D Pasundan, termasuk UPS (Uninterruptible Power Supply), UKB (Unit Kabel Bawah), dan Deteksi.

---

## 📋 Daftar Isi

1. [Cara Login](#-cara-login)
2. [Menu Utama](#-menu-utama)
3. [Mengelola Units](#-mengelola-units)
4. [Mengelola Users](#-mengelola-users)
5. [Peminjaman Unit](#-peminjaman-unit)
6. [Pelaporan Anomali](#-pelaporan-anomali)
7. [Dashboard](#-dashboard)

---

## 🔐 Cara Login

1. **Buka aplikasi** melalui browser (Chrome, Firefox, Edge)
2. Masukkan **Email** dan **Password** yang sudah terdaftar
3. Klik tombol **"Login"**
4. Jika berhasil, Anda akan diarahkan ke halaman utama

> 💡 **Tips:** Jika lupa password, hubungi Administrator untuk reset password.

---

## 🏠 Menu Utama

Setelah login, Anda akan melihat sidebar di sebelah kiri dengan menu:

| Menu | Fungsi |
|------|--------|
| **Dashboard** | Melihat ringkasan data dan statistik unit |
| **Units** | Mengelola data unit (UPS, UKB, Deteksi) |
| **Peminjaman** | Melihat daftar peminjaman unit |
| **Users** | Mengelola data pengguna (khusus Admin) |
| **Pelaporan Anomali** | Melihat laporan kerusakan/anomali unit |

---

## 🔧 Mengelola Units

### Melihat Daftar Unit
1. Klik menu **"Units"** di sidebar
2. Akan muncul tabel berisi semua unit yang tersedia
3. Gunakan kolom **"Cari"** untuk mencari unit tertentu

### Menambah Unit Baru
1. Klik tombol **"+ Add Unit"** di pojok kanan atas
2. Pilih tipe unit: **UPS**, **UKB**, atau **Deteksi**
3. Isi semua data yang diperlukan:
   - Informasi dasar (nama, kondisi, merk, dll)
   - Informasi dokumen (BPKB, STNK, KIR)
   - Tanggal penting (pajak, service)
4. Klik **"Add"** untuk menyimpan

### Mengedit Unit
1. Klik ikon **pensil** (✏️) pada baris unit yang ingin diedit
2. Ubah data yang diperlukan
3. Klik **"Save Changes"** untuk menyimpan

### Menghapus Unit
1. Klik ikon **tempat sampah** (🗑️) pada baris unit
2. Akan muncul popup konfirmasi
3. Klik **"Hapus"** untuk menghapus, atau **"Batal"** untuk membatalkan
4. Unit yang dihapus akan masuk ke **Arsip Unit**

### Melihat Arsip Unit
- Klik tombol **"Arsip Unit"** di bawah tabel untuk melihat unit yang sudah dihapus

---

## 👥 Mengelola Users

> ⚠️ **Catatan:** Menu ini hanya tersedia untuk Admin

### Melihat Daftar User
1. Klik menu **"Users"** di sidebar
2. Akan muncul tabel berisi semua pengguna

### Menambah User Baru
1. Klik tombol **"+ Add User"**
2. Isi data:
   - **Nama** - Nama lengkap pengguna
   - **NIP** - Nomor Induk Pegawai
   - **Email** - Email untuk login
   - **Password** - Password minimal 8 karakter
   - **Role** - Pilih hak akses (lihat penjelasan role di bawah)
3. Klik **"Add"** untuk menyimpan

### Mengedit User
1. Klik ikon **pensil** (✏️) pada baris user
2. Ubah data yang diperlukan
3. Kosongkan password jika tidak ingin mengubah
4. Klik **"Save Changes"**

### Menghapus User
1. Klik ikon **tempat sampah** (🗑️)
2. Konfirmasi penghapusan di popup
3. Klik **"Hapus"**

---

## 🔑 Sistem Role (Hak Akses)

### Penjelasan Role

Sistem ini memiliki **4 jenis role** dengan hak akses berbeda:

| Role ID | Nama Role | Keterangan |
|---------|-----------|------------|
| 1 | **Pending** | Role default untuk user baru yang belum disetujui Admin |
| 2 | **User** | Pengguna biasa yang bisa mengajukan peminjaman dan laporan |
| 3 | **Admin** | Administrator dengan akses penuh ke semua fitur |
| 4 | **PemakuKepentingan** | Stakeholder yang bisa melihat data tanpa akses edit |

### Cara Kerja Role

#### 1. User Baru Mendaftar
- Saat user baru **register/daftar**, secara otomatis akan mendapat role **"Pending"** (ID: 1)
- User dengan role Pending **belum bisa mengakses** fitur utama aplikasi
- Admin harus **mengubah role** user tersebut agar bisa menggunakan aplikasi

#### 2. Admin Mengubah Role User
1. Login sebagai **Admin**
2. Buka menu **"Users"**
3. Cari user yang baru mendaftar (lihat kolom Role = "Pending")
4. Klik ikon **pensil** (✏️) untuk edit
5. Ubah **Role** sesuai kebutuhan:
   - Pilih **"User"** → untuk pegawai biasa
   - Pilih **"Admin"** → untuk administrator
   - Pilih **"PemakuKepentingan"** → untuk stakeholder
6. Klik **"Save Changes"**

#### 3. Hak Akses Berdasarkan Role

| Fitur | Pending | User | Admin | PemakuKepentingan |
|-------|---------|------|-------|-------------------|
| Login | ✅ | ✅ | ✅ | ✅ |
| Lihat Dashboard | ❌ | ✅ | ✅ | ✅ |
| Form Peminjaman | ❌ | ✅ | ✅ | ❌ |
| Form Pelaporan | ❌ | ✅ | ✅ | ❌ |
| Kelola Units | ❌ | ❌ | ✅ | ❌ |
| Kelola Users | ❌ | ❌ | ✅ | ❌ |
| Kelola Peminjaman | ❌ | ❌ | ✅ | ❌ |
| Kelola Laporan | ❌ | ❌ | ✅ | ❌ |

### Setup Awal Admin

> ⚠️ **PENTING:** Langkah ini dilakukan saat pertama kali aplikasi dijalankan

Untuk membuat akun Admin pertama kali, jalankan perintah berikut di terminal:

```bash
php artisan db:seed --class=RoleSeeder      # Membuat data role
php artisan db:seed --class=AdminUserSeeder # Membuat akun admin default
```

**Akun Admin Default:**
- Email: `admin@pln.local`
- Password: `admin123`

> 💡 **Tips:** Segera ubah password default setelah login pertama kali!

### Alur Aktivasi User Baru

```
┌─────────────────────────────────────────────────────────────────┐
│  1. User mendaftar → Role otomatis: "Pending"                   │
│                              ↓                                   │
│  2. Admin login → Buka menu Users → Edit user                   │
│                              ↓                                   │
│  3. Admin ubah role dari "Pending" ke "User" atau lainnya       │
│                              ↓                                   │
│  4. User bisa login dan menggunakan fitur sesuai role-nya       │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📝 Peminjaman Unit

### Mengajukan Peminjaman (Untuk User)
1. Buka halaman **Form** 
2. Pilih tab **"Form Peminjaman"**
3. Pilih **Tipe Unit** (UPS/UKB/Deteksi)
4. Pilih **Unit** yang tersedia dari dropdown
5. Isi data peminjaman:
   - Lokasi penggunaan
   - Tanggal mobilisasi & demobilisasi
   - Tanggal event mulai & selesai
   - Tujuan penggunaan
   - UP3
   - Tamu VIP (opsional)
6. Klik **"Kirim"**
7. Jika berhasil, akan muncul popup notifikasi sukses

### Melihat Daftar Peminjaman (Untuk Admin)
1. Klik menu **"Peminjaman"** di sidebar
2. Lihat semua data peminjaman dalam tabel
3. Status peminjaman:
   - 🔵 **Sedang Digunakan** - Unit masih dipinjam
   - 🟢 **Selesai** - Peminjaman sudah selesai
   - 🔴 **Cancel** - Peminjaman dibatalkan

### Mengedit Peminjaman
1. Klik ikon **pensil** (✏️)
2. Ubah data yang diperlukan
3. Ubah **Status** jika peminjaman sudah selesai
4. Klik **"Simpan"**

### Menghapus Peminjaman
1. Klik ikon **tempat sampah** (🗑️)
2. Konfirmasi di popup
3. Klik **"Hapus"**

---

## ⚠️ Pelaporan Anomali

### Melaporkan Kerusakan/Anomali (Untuk User)
1. Buka halaman **Form**
2. Pilih tab **"Form Pelaporan Anomali"**
3. Pilih **Tipe Unit** dan **Unit** yang bermasalah
4. Isi data laporan:
   - Tanggal kejadian
   - Lokasi penggunaan
   - No. Berita Acara
   - UP3
   - Keterangan kerusakan
   - Keperluan anggaran (jika ada)
5. Upload **Bukti Foto** (wajib, minimal 1 foto)
6. Klik **"Kirim"**

### Melihat Laporan Anomali (Untuk Admin)
1. Klik menu **"Pelaporan Anomali"** di sidebar
2. Lihat semua laporan dalam tabel
3. Kondisi kendaraan:
   - 🟢 **BAIK** - Sudah diperbaiki
   - 🟡 **DIGUNAKAN** - Sedang dipakai
   - 🔴 **RUSAK/PERBAIKAN** - Perlu perbaikan

### Mengedit Laporan
1. Klik ikon **pensil** (✏️)
2. Ubah data yang diperlukan
3. Ubah **Kondisi Kendaraan** jika sudah diperbaiki
4. Bisa menambah foto baru atau menghapus foto lama
5. Klik **"Simpan"**

> 💡 **Tips:** Jika unit sudah selesai diperbaiki, segera hapus dari daftar agar data tetap akurat.

---

## 📊 Dashboard

Dashboard menampilkan ringkasan data:
- Total unit berdasarkan tipe (UPS, UKB, Deteksi)
- Status unit (Standby, Digunakan, Tidak Siap Operasi)
- Kondisi unit (Baik, Rusak, Perbaikan)
- Grafik dan statistik

---

## 🔔 Notifikasi

Pada setiap aksi (tambah, edit, hapus), sistem akan menampilkan:
- **Popup Konfirmasi** - Sebelum menghapus data
- **Popup Sukses** - Jika aksi berhasil
- **Popup Error** - Jika terjadi kesalahan

---

## ❓ FAQ (Pertanyaan Umum)

**Q: Mengapa saya tidak bisa login?**
> Pastikan email dan password sudah benar. Jika lupa password, hubungi Admin.

**Q: Mengapa unit tidak muncul di dropdown peminjaman?**
> Hanya unit dengan status **"Standby"** yang bisa dipinjam.

**Q: Bagaimana cara mengembalikan unit yang sudah dihapus?**
> Unit yang dihapus masuk ke Arsip. Hubungi Admin untuk memulihkan.

**Q: Apakah data bisa diekspor?**
> Saat ini fitur ekspor belum tersedia.

---

## 📞 Kontak Support

Jika mengalami kendala, silakan hubungi:
- **Admin IT**: [email admin]
- **Telepon**: [nomor telepon]

---

*Dokumentasi ini terakhir diperbarui pada: Desember 2025*
