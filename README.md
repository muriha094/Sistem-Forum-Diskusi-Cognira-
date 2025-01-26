![logo_cognira_remove_bg](https://github.com/user-attachments/assets/988836d8-2f59-4710-8f15-31abed9eb6fa)

# Cognira
Cognira adalah sistem forum diskusi berbasis website yang kami kembangkan, dengan tujuan untuk menjadi ruang bagi para penggunanya dalam berbagi dan mendiskusikan berbagai pengetahuan. Nama "Cognira" berasal dari gabungan dua kata, yaitu "Cognition" yang berarti pengetahuan, dan "Aura" yang berarti ruang, sehingga menggambarkan sebuah platform sebagai "ruang pengetahuan" bagi penggunanya. Sistem ini dirancang untuk memudahkan interaksi, pertukaran ide, dan kolaborasi antar pengguna melalui forum diskusi.

[![Made withPHP](https://img.shields.io/badge/Made%20with-PHP-purple?style=for-the-badge&logo=PHP)](https://php.net/try)

### Makna Logo 
Makna logo dari cognira, yaitu buku menyimbolkan macam-macam pengetahuan. Lampu menyimbolkan berbagai ide/gagasan yang disampaikan oleh para pengguna. Huruf C yang mengcover buku dan lampu merupakan huruf awal dari cognira itu sendiri

### Fitur-Fitur yang Tersedia 
Untuk User 
1. Adanya badge notifikasi di navbar yang memberikan indicator bahwa ada pemberitahuan untuk pengguna
2. User dapat mengelola pertanyaan, jawaban, dan komentar yang telah dikirim, yaitu mengedit dan menghapus.
3. Terdapat fitur highlight/sorot dan scroll untuk jawaban atau komentar yang baru kita inputkan 

Untuk Admin
1. Adanya badge notifikasi pada bagian laporan di navbar sehingga admin tidak perlu mengecek terus-menerus. Cukup saat ada notifikasi saja 
2. Adanya modal component yang memberitahukan untuk memblokir pengguna setelah dilaporkan sebanyak 3x oleh pengguna lain secara otomatis. 
3. Adanya fitur blokir akun pengguna Ketika pengguna telah dilaporkan 3x. Dan nanti ada alert yg dilengkapi countdown masa blokir.

## Tech

Sistem ini dibangun dengan menggunakan :

- [XAMPP](https://www.apachefriends.org/) - Aplikasi XAMPP merupakan sebuah paket perangkat lunak (software) komputer yang berfungsi sebagai server lokal untuk mengampu berbagai jenis data website yang sedang dalam proses pengembangan.
- [Visual Studio Code](https://code.visualstudio.com/) - Visual Studio Code (VS Code) adalah editor kode sumber ringan dan kuat, mendukung banyak bahasa pemrograman, dan dilengkapi fitur seperti debugging, kontrol versi, dan ekstensi.
- [Microsoft Edge](https://www.microsoft.com/id-id/edge/?form=MA13FJ) - Microsoft Edge adalah browser web cepat dan aman dari Microsoft, berbasis Chromium dengan fitur tambahan seperti integrasi Microsoft 365.
- [Mozilla Firefox](https://www.mozilla.org/id/firefox/new/) - Mozilla Firefox adalah browser web open-source yang fokus pada privasi, keamanan, dan kecepatan. Dikenal dengan fitur-fitur seperti blokir iklan otomatis dan kontrol privasi yang kuat.
- [Bootstrap](https://getbootstrap.com/) - Bootstrap adalah framework CSS yang memudahkan pembuatan desain responsif dan tampilan web yang menarik dengan komponen siap pakai seperti tombol, navigasi, dan grid system.

Dibangun dengan bahasa pemograman :

- [PHP](https://www.php.net/) - PHP adalah bahasa pemrograman untuk membuat aplikasi web dinamis dan interaktif di sisi server.
- [HTML] - HTML (HyperText Markup Language) adalah bahasa markup yang digunakan untuk membuat struktur halaman web.
- [CSS] - Cascading Style Sheets (CSS) adalah bahasa yang digunakan untuk mengatur tampilan dan layout halaman web, seperti warna, font, dan tata letak.
- [Javascript] - JavaScript adalah bahasa pemrograman yang digunakan untuk membuat halaman web interaktif, seperti animasi, form validation, dan fitur dinamis lainnya. Bahkan, bisa juga untuk membuat logika.
- [SQL] - Structured Query Language (SQL) adalah bahasa untuk mengelola dan mengakses data dalam database.

## Installation

Dillinger requires [Node.js](https://nodejs.org/) v10+ to run.

Install the dependencies and devDependencies and start the server.

```sh
cd dillinger
npm i
node app
```

For production environments...

```sh
npm install --production
NODE_ENV=production node app
```

## Plugins

Dillinger is currently extended with the following plugins.
Instructions on how to use them in your own application are linked below.

| Plugin | README |
| ------ | ------ |
| Dropbox | [plugins/dropbox/README.md][PlDb] |
| GitHub | [plugins/github/README.md][PlGh] |
| Google Drive | [plugins/googledrive/README.md][PlGd] |
| OneDrive | [plugins/onedrive/README.md][PlOd] |
| Medium | [plugins/medium/README.md][PlMe] |
| Google Analytics | [plugins/googleanalytics/README.md][PlGa] |

## Development

Want to contribute? Great!

Dillinger uses Gulp + Webpack for fast developing.
Make a change in your file and instantaneously see your updates!

Open your favorite Terminal and run these commands.

First Tab:

```sh
node app
```

Second Tab:

```sh
gulp watch
```

(optional) Third:

```sh
karma test
```

#### Building for source

For production release:

```sh
gulp build --prod
```

Generating pre-built zip archives for distribution:

```sh
gulp build dist --prod
```

## Docker

Dillinger is very easy to install and deploy in a Docker container.

By default, the Docker will expose port 8080, so change this within the
Dockerfile if necessary. When ready, simply use the Dockerfile to
build the image.

```sh
cd dillinger
docker build -t <youruser>/dillinger:${package.json.version} .
```

This will create the dillinger image and pull in the necessary dependencies.
Be sure to swap out `${package.json.version}` with the actual
version of Dillinger.

Once done, run the Docker image and map the port to whatever you wish on
your host. In this example, we simply map port 8000 of the host to
port 8080 of the Docker (or whatever port was exposed in the Dockerfile):

```sh
docker run -d -p 8000:8080 --restart=always --cap-add=SYS_ADMIN --name=dillinger <youruser>/dillinger:${package.json.version}
```

> Note: `--capt-add=SYS-ADMIN` is required for PDF rendering.

Verify the deployment by navigating to your server address in
your preferred browser.

```sh
127.0.0.1:8000
```

## License

MIT

**Free Software, Hell Yeah!**

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

   [dill]: <https://github.com/joemccann/dillinger>
   [git-repo-url]: <https://github.com/joemccann/dillinger.git>
   [john gruber]: <http://daringfireball.net>
   [df1]: <http://daringfireball.net/projects/markdown/>
   [markdown-it]: <https://github.com/markdown-it/markdown-it>
   [Ace Editor]: <http://ace.ajax.org>
   [node.js]: <http://nodejs.org>
   [Twitter Bootstrap]: <http://twitter.github.com/bootstrap/>
   [jQuery]: <http://jquery.com>
   [@tjholowaychuk]: <http://twitter.com/tjholowaychuk>
   [express]: <http://expressjs.com>
   [AngularJS]: <http://angularjs.org>
   [Gulp]: <http://gulpjs.com>

   [PlDb]: <https://github.com/joemccann/dillinger/tree/master/plugins/dropbox/README.md>
   [PlGh]: <https://github.com/joemccann/dillinger/tree/master/plugins/github/README.md>
   [PlGd]: <https://github.com/joemccann/dillinger/tree/master/plugins/googledrive/README.md>
   [PlOd]: <https://github.com/joemccann/dillinger/tree/master/plugins/onedrive/README.md>
   [PlMe]: <https://github.com/joemccann/dillinger/tree/master/plugins/medium/README.md>
   [PlGa]: <https://github.com/RahulHP/dillinger/blob/master/plugins/googleanalytics/README.md>
