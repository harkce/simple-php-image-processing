Tugas Besar Pengolahan Citra Digital
====================================
Muhammad Habib Fikri Sundayana
1301144118
====================================

Untuk menjalankan program, pada root folder jalankan perintah:

php -S localhost:8000

Kemudian, buka http://localhost:8000/ pada browser

Fungsionalitas yang dikerjakan:
- gambar menjadi 3 matriks RGB (image2matrix.php)
- grayscale (grayscale.php)
- pergeseran gambar (slide.php)
- zoom (zoom.php)
- rotate (rotate.php)
- increase/decrease brightness (brightness.php)
- double/half brightness (kalibright.php)
- zigzag warp (warping.php)
- convulsion - box blur & gaussian blur (convulsion.php)
- smoothing - mean & median (smooth.php)
- image sharpening (sharpen.php)
- edge detection (edge.php)
- erosi (erosion.php)
- dilasi (dilation.php)

Struktur Folder
root
|-- documentation/		Folder yang berisi dokumentasi setiap fungsi
|-- function/			Folder yang berisi fungsi-fungsi yang digunakan program
|-- js/					Folder JavaScript
  |-- code.js			File JavaScript untuk memanggil fungsi-fungsi di folder function/
|-- habib.jpg			Contoh image beresolusi sedang
|-- habibkecil.jpg		Contoh image beresolusi kecil
|-- index.html			File yang berisi tampilan program
|-- lenna.png			Contoh image beresolusi tinggi
|-- README.txt			File ini


Tools yang digunakan
- HTML untuk tampilan
- JavaScript untuk memanggil fungsi dan mengembalikan hasil ke tampilan
- PHP untuk pemrosesan gambar