![logo_cognira_remove_bg](https://github.com/user-attachments/assets/988836d8-2f59-4710-8f15-31abed9eb6fa)


# 🧾 Cognira
Cognira adalah sistem forum diskusi berbasis website yang kami kembangkan, dengan tujuan untuk menjadi ruang bagi para penggunanya dalam berbagi dan mendiskusikan berbagai pengetahuan. Nama "Cognira" berasal dari gabungan dua kata, yaitu "Cognition" yang berarti pengetahuan, dan "Aura" yang berarti ruang, sehingga menggambarkan sebuah platform sebagai "ruang pengetahuan" bagi penggunanya. Sistem ini dirancang untuk memudahkan interaksi, pertukaran ide, dan kolaborasi antar pengguna melalui forum diskusi.

[![Made withPHP](https://img.shields.io/badge/Made%20with-PHP-purple?style=for-the-badge&logo=PHP)](https://php.net/try)

## 📖 Makna Logo 
Makna logo dari cognira, yaitu buku menyimbolkan macam-macam pengetahuan. Lampu menyimbolkan berbagai ide/gagasan yang disampaikan oleh para pengguna. Huruf C yang mengcover buku dan lampu merupakan huruf awal dari cognira itu sendiri

## 🎯 Fitur-Fitur yang Tersedia 
👥 Untuk User 
1. 🔔 Adanya badge notifikasi di navbar yang memberikan indicator bahwa ada pemberitahuan untuk pengguna
2. ✏️🩹 User dapat mengelola pertanyaan, jawaban, dan komentar yang telah dikirim, yaitu mengedit dan menghapus.
3. 🖍 ️Terdapat fitur highlight/sorot dan scroll untuk jawaban atau komentar yang baru kita inputkan 

👨‍💻Untuk Admin
1. 🔔 Adanya badge notifikasi pada bagian laporan di navbar sehingga admin tidak perlu mengecek terus-menerus. Cukup saat ada notifikasi saja 
2. ⚠️ Adanya modal component yang memberitahukan untuk memblokir pengguna setelah dilaporkan sebanyak 3x oleh pengguna lain secara otomatis. 
3. ⛔ Adanya fitur blokir akun pengguna Ketika pengguna telah dilaporkan 3x. Dan nanti ada alert yg dilengkapi countdown masa blokir.

## ⚙️Teknologi yang Digunakan

Sistem ini dibangun dengan menggunakan :

- [XAMPP](https://www.apachefriends.org/) - Aplikasi XAMPP merupakan sebuah paket perangkat lunak (software) komputer yang berfungsi sebagai server lokal untuk mengampu berbagai jenis data website yang sedang dalam proses pengembangan.
- [Visual Studio Code](https://code.visualstudio.com/) - Visual Studio Code (VS Code) adalah editor kode sumber ringan dan kuat, mendukung banyak bahasa pemrograman, dan dilengkapi fitur seperti debugging, kontrol versi, dan ekstensi.
- [Microsoft Edge](https://www.microsoft.com/id-id/edge/?form=MA13FJ) - Microsoft Edge adalah browser web cepat dan aman dari Microsoft, berbasis Chromium dengan fitur tambahan seperti integrasi Microsoft 365.
- [Mozilla Firefox](https://www.mozilla.org/id/firefox/new/) - Mozilla Firefox adalah browser web open-source yang fokus pada privasi, keamanan, dan kecepatan. Dikenal dengan fitur-fitur seperti blokir iklan otomatis dan kontrol privasi yang kuat.
- [Bootstrap](https://getbootstrap.com/) - Bootstrap adalah framework CSS yang memudahkan pembuatan desain responsif dan tampilan web yang menarik dengan komponen siap pakai seperti tombol, navigasi, dan grid system.




## 💻 Persyaratan Sistem

- XAMPP 8.2.12 atau diatasnya
- PHP 8.2 atau diatasnya
- Bootstrap 5 atau diatasnya

## 📁 Struktur 

```sh
app_cognira
├── actions/     #File-file aksi seperti menghapus, edit, dll
├── admin/       #File-file  untuk tampilan admin
├── asset/       #File-file  css,  gambar,  js
├── auth/        #File-file  tampilan login & proses login&logout
├── halamanlain/ #File-file  tampilan-tampilan footer  
├── question/    #File-file  untuk  tampilan & proses pertanyaan
├── registrasi/	 #File-file untuk  tampilan & proses registrasi
├── template/    #File-file tampilan navbar, modal component, dll
├── user/        #File-file untuk tampilan user			   
├── config.php   #File untuk koneksi database  
└── index.php    #File untuk halaman landing page		 
```


## 🛠️ Installation

Pindahkan folder app_cognira ke dalam folder
```
C:\xampp\htdocs\
```
start apache pada XAMPP

Akses pada browser dengan url 
```sh
http:/localhost/app_cognira
```

## Tampilan website
Berikut contoh tampilan dari wesbsite sistem forum diskusi "Cognira"
### User
![Screenshot 2025-01-23 220129](https://github.com/user-attachments/assets/384cf4e0-12fe-46e7-97b5-4f8710600688)

![Screenshot 2025-01-22 205515](https://github.com/user-attachments/assets/9419f8dd-422e-40e1-bb46-5388a230afe4)

![Screenshot 2025-01-22 211524](https://github.com/user-attachments/assets/53380ae3-27f5-403a-b6b9-5511aa79c8d8)

### Admin
![Screenshot 2025-01-22 214111](https://github.com/user-attachments/assets/c9755a3a-779b-4c62-9e0e-d7e2af41d2f2)

![Screenshot 2025-01-22 215538](https://github.com/user-attachments/assets/44e0439e-a7ce-40b1-89d7-cc465bfb0100)

![Screenshot 2025-01-22 215033](https://github.com/user-attachments/assets/4c96616f-37fb-4b9b-9205-ee93f75257e2)


