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

- [x] Validasi payment status pada order dihilangkan
- [x] Setelah order status completed atau canceled, status sudah tidak dapat diedit
- [ ] Tipe customer menjadi member apabila sudah memenuhi kondisi minimal order 6x atau total nominal keseluruhan order 2jt (menunggu info total nominal diambil setelah atau sebelum diskon) dengan status order completed
- [ ] Ubah bahasa ke Indonesia
- [ ] Rebuild return agar mengacu pada order dengan items secara default terpilih seluruhnya
  - [ ] Order yang dapat di return adalah order dengan status selain waiting dan processed
  - [ ] Tambah field position untuk menampung data [Gudang, Ekspedisi, Hilang]
- [ ] Tambah field note di model order item, agar dapat menampung catatan untuk per item apabila ada scenario ukuran custom
- [ ] Form order untuk guest.
- [ ] Chart dibagian dashboard (menunggu info)
- [ ] Tambah field order_number di model order, agar memudahkan mencari order
