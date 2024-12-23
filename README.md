*connection.php* 
File ini biasanya mengatur koneksi ke database. Contohnya:
Membuat koneksi menggunakan mysqli atau PDO.
Menyimpan konfigurasi seperti host, username, password, dan nama database.
Bisa juga ada logika untuk menangani kesalahan koneksi.

*index.php*
Ini kemungkinan halaman utama aplikasi web Anda.
Bisa berisi tampilan data, seperti tabel atau dashboard.
Jika aplikasi menggunakan sistem login, halaman ini mungkin hanya bisa diakses oleh pengguna yang sudah masuk.

*login.php*
Form untuk login pengguna.
Input biasanya berupa username/email dan password.
Ada validasi data, dan logika untuk mencocokkan data pengguna di database.

*register.php*
Halaman untuk mendaftarkan akun pengguna baru.
Input berupa nama, email, password, atau informasi tambahan lainnya.
Biasanya ada logika untuk menyimpan data ke database setelah validasi.

*server.php*
File ini sering digunakan untuk menyimpan fungsi atau logika pemrosesan backend.
Contoh: memproses data dari form, query database, atau menangani autentikasi.
