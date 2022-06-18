FR James

[Documetation](https://longhaired-wallaby-a66.notion.site/Fitur-Step-1-b368e4b6dfb24583ab5f7984b4921114)

Stacks:

- Laravel
- MySQL
- AdminLTE
- Bootstrap 4
- jQuery
- jQuery Datatables

Features:

- [x] Users management
- [x] Roles management
- [x] Permissions management
- [x] Customers management
- [x] Products management
- [x] Variants management
- [x] Orders management
- [x] Integrasi wilayah Indonesia (provinsi, kota, kecamata, kelurahan, dan kode pos)
- [x] Shippings management
- [x] Payment methods management
- [x] Employees management
- [x] Employee types management (sales, input, packing)
- [x] Order sources management
- [x] Print order as invoice
- [x] Auto assign customer type
- [x] Auto complete order dengan status sent setelah 7 hari
- [x] Filter orders
- [x] Export orders
- [x] Retur item order 
- [ ] Dashboard
  - [x] Total penjualan berdasarkan order source
  - [x] Total customer berdasarkan type (new, repeat, member)
  - [ ] Grafik order berdasarkan status
  - [ ] Grafik penjualan


Improvements:

- [x] Hapus validasi perubahan status order dan payment status order
- [x] Tipe customer menjadi member apabila sudah memenuhi kondisi minimal order 6x atau total nominal keseluruhan order 2jt (menunggu info total nominal diambil setelah atau sebelum diskon) dengan status order completed
- [x] Ubah bahasa ke Indonesia
- [x] Rebuild return agar dapat memilih lebih dari 1 item
- [x] Tambah field note di model order item, agar dapat menampung catatan untuk per item apabila ada scenario ukuran custom
- [x] Chart dibagian dashboard

[Review 16 Juni 2022](https://longhaired-wallaby-a66.notion.site/Review-2c3fb148b8dd42378a1142ceb9e5b621):

- [x]  submit retur seharusnya tidak bisa lebih dari jumlah barang di invoice
- [x]  Tampilan dashboard ada opsi filter by tanggal (Seperti di orderlist)
- [x]  Pie Chart Dashboard Sumber marketplace dihapus, ganti dengan childnya (tokped, lazada, dll)
- [ ]  bisa bulk print invoice dari order list (ada opsi untuk select, order mana aja yang mau diprint invoicenya)
- [x]  Input Order baru, pada saat masukkan cari customer bisa juga via nomor HP, tidak hanya via nama. Karena kemungkinan nama bisa banyak yang sama.
- [x]  Menu list customer, bisa filter / search by nomor hp
- [x]  Jika edit data customer, mengapa tidak merubah data informasi yang ada di order list ?
- [x] Ubah Penulisan
  - [x]  Kustomer = Customer
  - [x]  Karyawan = Tim
  - [x]  Nama = Sumber Traffic
  - [x]  Nama = Nama Kurir
  - [x]  Nama = Metode Pembayaran
