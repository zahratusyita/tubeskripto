# SecureVote Desa

SecureVote Desa adalah aplikasi e-voting akademik untuk simulasi **pemilihan kepala desa**. Sistem ini dibangun dengan Laravel 13 dan dirancang untuk menunjukkan konsep keamanan pemilihan digital: autentikasi admin, validasi hak pilih, pemisahan identitas pemilih dari surat suara, enkripsi RSA-OAEP, token anonim, dan rekap suara yang hanya dibuka setelah pemilihan ditutup.

Dataset pemilih pada demo memakai data dari `nama mahasiswa dan nim.pdf`. NIM digunakan sebagai simulasi NIK, nama mahasiswa sebagai nama warga, dan kelas sebagai wilayah/dusun.

## Teknologi

- Laravel 13
- Blade + Tailwind CSS + Vite
- SQLite untuk demo lokal
- Struktur migration kompatibel untuk MySQL
- OpenSSL RSA-OAEP untuk enkripsi suara
- Laravel Hash untuk kata sandi admin
- Laravel Crypt untuk menyimpan private key secara terenkripsi
- HMAC-SHA256 untuk integritas surat suara

## Fitur Utama

- Halaman pemilih untuk input NIK/NIM.
- Biodata pemilih muncul otomatis setelah NIK/NIM valid.
- Pemilih hanya bisa memilih satu kali.
- Calon kepala desa dapat dikelola oleh admin.
- Admin login memakai NIK/NIM dan kata sandi.
- Dasbor admin untuk melihat status pemilihan, partisipasi, dan ringkasan keamanan.
- Pantauan langsung untuk melihat progres pemilih dan surat suara masuk.
- Rekap suara baru dapat dibuka setelah pemilihan ditutup.
- Halaman Bukti untuk menjelaskan keamanan sistem saat presentasi.

## Alur Kerja Pemilih

1. Pemilih membuka halaman utama.
2. Pemilih memasukkan NIK/NIM.
3. Sistem mencari data pemilih di tabel `voters`.
4. Jika terdaftar dan belum memilih, sistem menampilkan biodata pemilih.
5. Pemilih memilih salah satu calon kepala desa.
6. Sistem mengenkripsi pilihan menggunakan public key RSA-OAEP.
7. Sistem membuat token anonim acak.
8. Sistem menyimpan surat suara terenkripsi ke tabel `ballots`.
9. Sistem menandai pemilih sebagai sudah memilih di tabel `voters`.
10. Pemilih diarahkan ke halaman sukses.

## Alur Kerja Admin

1. Admin masuk melalui `/admin/login`.
2. Admin melihat ringkasan pemilihan pada menu Dasbor.
3. Admin dapat mengelola calon pada menu Calon.
4. Admin dapat melihat data pemilih dan status sudah/belum memilih.
5. Admin dapat membuka atau menutup pemilihan.
6. Selama pemilihan masih dibuka, hasil per calon dikunci.
7. Setelah pemilihan ditutup, admin dapat membuka Pantauan atau Rekap untuk melihat hasil akhir.
8. Admin dapat membuka menu Bukti untuk menunjukkan konsep keamanan sistem.

## Struktur Data Inti

### `users`

Menyimpan akun admin.

- `identity_number`
- `name`
- `password`
- `role`
- `last_login_at`

Kata sandi admin disimpan sebagai hash, bukan teks asli.

### `voters`

Menyimpan identitas pemilih dan status partisipasi.

- `identity_number`
- `full_name`
- `region`
- `has_voted`
- `voted_at`

Tabel ini tidak menyimpan pilihan calon.

### `ballots`

Menyimpan surat suara anonim dan terenkripsi.

- `election_id`
- `anonymous_token_hash`
- `encrypted_vote`
- `integrity_hash`
- `cast_at`

Tabel ini tidak menyimpan NIK/NIM, nama pemilih, atau `voter_id`.

### `candidates`

Menyimpan data calon kepala desa.

- `ballot_number`
- `name`
- `photo`
- `vision`
- `mission`

### `rsa_keys`

Menyimpan public key dan private key terenkripsi untuk proses enkripsi dan rekap.

## Desain Keamanan

### 1. Kata Sandi Admin Di-hash

Admin login memakai NIK/NIM dan kata sandi. Kata sandi tidak disimpan langsung di database, tetapi disimpan sebagai hash bcrypt melalui Laravel Hash.

Tujuannya:

- mencegah kata sandi asli terbaca jika database bocor;
- membuktikan bahwa sistem tidak menyimpan kredensial dalam bentuk plaintext.

### 2. Identitas Pemilih Dipisahkan dari Surat Suara

Sistem tetap perlu mengetahui siapa yang sudah dan belum memilih. Karena itu identitas pemilih disimpan di tabel `voters`.

Namun pilihan suara tidak disimpan di tabel tersebut. Pilihan suara masuk ke tabel `ballots` tanpa identitas pemilih.

Tujuannya:

- admin bisa melihat status partisipasi;
- admin tidak bisa langsung mengetahui siapa memilih calon apa.

### 3. Surat Suara Dienkripsi RSA-OAEP

Pilihan calon dienkripsi menggunakan public key RSA-OAEP sebelum disimpan.

Data yang tersimpan di tabel `ballots.encrypted_vote` berbentuk teks terenkripsi, bukan nama calon.

Tujuannya:

- menjaga kerahasiaan pilihan suara;
- mencegah isi suara terbaca langsung dari database.

### 4. Token Anonim

Setiap surat suara diberi token acak. Token asli tidak disimpan; sistem hanya menyimpan hash token di `anonymous_token_hash`.

Tujuannya:

- membuat surat suara memiliki penanda unik;
- tidak mengaitkan surat suara dengan identitas pemilih.

### 5. Hash Integritas

Setiap surat suara memiliki `integrity_hash` berbasis HMAC-SHA256.

Tujuannya:

- membantu membuktikan bahwa data terenkripsi tidak berubah;
- memperkuat klaim integritas data surat suara.

### 6. Rekap Dikunci Saat Pemilihan Berjalan

Selama status pemilihan masih dibuka, hasil per calon tidak ditampilkan. Pantauan langsung hanya menampilkan jumlah pemilih yang sudah memilih dan jumlah surat suara terenkripsi yang masuk.

Tujuannya:

- mencegah admin melihat tren suara saat pemungutan suara masih berlangsung;
- menjaga netralitas proses pemilihan.

## Cara Membuktikan Saat Presentasi

Gunakan menu **Bukti** di area admin.

Urutan demo yang disarankan:

1. Masuk sebagai admin.
2. Buka menu Bukti.
3. Tunjukkan bahwa kata sandi admin berbentuk hash `$2y$...`, bukan `admin12345`.
4. Buka halaman pemilih.
5. Pilih menggunakan salah satu NIK/NIM demo, misalnya `F1D02410036`.
6. Kembali ke menu Bukti.
7. Tunjukkan bahwa surat suara tersimpan sebagai teks terenkripsi.
8. Tunjukkan bahwa tabel surat suara tidak menampilkan NIK/NIM atau nama pemilih.
9. Coba gunakan NIK/NIM yang sama lagi untuk membuktikan sistem menolak double voting.
10. Tutup pemilihan dari Dasbor.
11. Buka Pantauan atau Rekap untuk menunjukkan hasil baru muncul setelah pemilihan ditutup.

Kalimat inti presentasi:

> Sistem dapat mengetahui siapa yang sudah memilih tanpa menyimpan siapa memilih calon apa. Identitas pemilih dan surat suara dipisahkan, sedangkan isi suara disimpan secara anonim dan terenkripsi menggunakan RSA-OAEP.

## Menjalankan Aplikasi

```bash
composer install
npm install
php artisan migrate:fresh --seed
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Buka aplikasi:

```text
http://127.0.0.1:8000
```

## Akun Demo

Admin:

```text
NIK/NIM: F1D02410053
Kata sandi: admin12345
```

Pemilih demo:

```text
F1D02410036
F1D02410049
F1D02410041
```

Total data pemilih seed: 146 orang.

## Catatan Database

Konfigurasi lokal memakai SQLite agar cepat untuk demo. Untuk MySQL, ubah `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=securevote_desa
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan:

```bash
php artisan migrate:fresh --seed
```

## Batasan Demo Akademik

- Login pemilih masih memakai NIK/NIM saja agar demo cepat dan mudah.
- Untuk sistem nyata, pemilih sebaiknya memakai NIK + kode akses atau OTP.
- Sistem ini dibuat untuk pembelajaran konsep keamanan e-voting, bukan untuk langsung dipakai sebagai sistem pemilu produksi.
