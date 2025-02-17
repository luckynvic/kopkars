<?php

use yii\db\Migration;
use yii\db\Schema;

class m200001_000004_produk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('produk', [
            'kode_toko' => $this->string(50)->notNull(),
            'sku' => $this->string(20)->notNull(),
            'status_aktif'=> $this->boolean()->defaultValue(true)->notNull(),
            'nama_produk' => $this->string(70)->notNull(),
            'nama_produk_pendek' => $this->string(20),
            'brand' => $this->string(70)->notNull(),
            'warna'  => $this->string(20)->notNull(),
            'deskripsi' => $this->string(2000),
            'harga_modal_async' => $this->integer()->defaultValue(0)->notNull(),
            'harga_async' => $this->integer()->defaultValue(0)->notNull(),
            'stok_async' => $this->integer()->defaultValue(0)->notNull(),
            'berat' => $this->integer()->notNull(),
            'foto_1' => $this->binary(),
            'foto_2' => $this->binary(),
            'foto_3' => $this->binary(),
            'foto_4' => $this->binary(),
            'foto_5' => $this->binary(),
            'foto_6' => $this->binary(),
            'foto_7' => $this->binary(),
            'video_url_1' => $this->string(250),
            'video_url_2' => $this->string(250),
            'video_url_3' => $this->string(250),
            'video_url_4' => $this->string(250),
            'video_url_5' => $this->string(250),
            'rekomendasi_1' => $this->string(250),
            'rekomendasi_2' => $this->string(250),
            'rekomendasi_3' => $this->string(250),
            'rekomendasi_4' => $this->string(250),
            'rekomendasi_5' => $this->string(250),
            'urlid_bli' => $this->string(),
            'urlid_bkl' => $this->string(),
            'urlid_fbc' => $this->string(),
            'urlid_fbm' => $this->string(),
            'urlid_jdi' => $this->string(),
            'urlid_lzd' => $this->string(),
            'urlid_shp' => $this->string(),
            'urlid_tkp' => $this->string(),
            'id_tkp' => $this->string(),
        ]);

        $this->addPrimaryKey('produk_sku_pkey','produk',array('kode_toko','sku'));

        $this->addForeignKey('produk_toko_fkey', 'produk', 'kode_toko', 'toko', 'kode', 'RESTRICT', 'CASCADE');

        $this->createIndex('produk_kode_toko_sku_idx', 'produk', ['kode_toko','sku'], true);

        $this->createIndex('produk_kode_toko_nama_produk_idx', 'produk', ['kode_toko','nama_produk'], true);

        $this->createIndex('produk_kode_toko_nama_produk_pendek_idx', 'produk', ['kode_toko','nama_produk_pendek'], true);

        $this->batchInsert('produk', ['kode_toko','sku','nama_produk','harga_async','stok_async','berat','video_url_1','video_url_2','video_url_3','rekomendasi_1','rekomendasi_2','rekomendasi_3','rekomendasi_4','rekomendasi_5','brand','warna'],
        [
            ['hiiphooray-tani','SKUHT0001','Bakteri Baik EM4 1 Liter Perikanan dan Tambak',22500,15,1300,NULL,NULL,NULL,'SKUHT0068','SKUHT0078','SKUHT0077','SKUHT0039','SKUHT0067','EM4','Multicolor'],
            ['hiiphooray-tani','SKUHT0002','Bakteri Baik EM4 1 Liter Pertanian',22500,30,1300,NULL,NULL,NULL,'SKUHT0056','SKUHT0077','SKUHT0001','SKUHT0039','SKUHT0067','EM4','Multicolor'],
            ['hiiphooray-tani','SKUHT0003','Fungisida Antracol 70WP 250gr Ekstra Zinc Kontak Protektif',38000,10,300,NULL,NULL,NULL,'SKUHT0004','SKUHT0015','SKUHT0010','SKUHT0038','SKUHT0008','Bayer','Multicolor'],
            ['hiiphooray-tani','SKUHT0004','Fungisida Score 250EC 80ml Sistemik Bunuh Jamur Penyakit',60000,5,200,NULL,NULL,NULL,'SKUHT0003','SKUHT0015','SKUHT0009','SKUHT0024','SKUHT0008','Syngeta','Multicolor'],
            ['hiiphooray-tani','SKUHT0005','Gunting Kebun C-Mart A0050 Pruning Shears Taiwan',75000,1,350,NULL,NULL,NULL,'SKUHT0038','SKUHT0071','SKUHT0007','SKUHT0035','SKUHT0006','C-mart','Multicolor'],
            ['hiiphooray-tani','SKUHT0006','Gunting Kebun Tiger 700 Pruning Shears Taiwan',50000,4,350,NULL,NULL,NULL,'SKUHT0071','SKUHT0038','SKUHT0007','SKUHT0035','SKUHT0005','Tiger','Multicolor'],
            ['hiiphooray-tani','SKUHT0007','Gunting Kebun Tjap Mata JHS-283 Solingen Germany',111000,4,450,NULL,NULL,NULL,'SKUHT0024','SKUHT0005','SKUHT0034','SKUHT0038','SKUHT0060','Tjap Mata','Multicolor'],
            ['hiiphooray-tani','SKUHT0008','Herbisida Roundup 200ml Pembasmi Rumput',22000,20,400,NULL,NULL,NULL,'SKUHT0038','SKUHT0024','SKUHT0011','SKUHT0009','SKUHT0010','Roundup','Multicolor'],
            ['hiiphooray-tani','SKUHT0009','Insektisida Curacron 500EC 100ml Hama Tewas',35000,20,300,NULL,NULL,NULL,'SKUHT0015','SKUHT0010','SKUHT0038','SKUHT0056','SKUHT0004','Curacron','Multicolor'],
            ['hiiphooray-tani','SKUHT0010','Insektisida Decis 50ml Kontak Andalan Petani Desa',19000,20,200,NULL,NULL,NULL,'SKUHT0015','SKUHT0009','SKUHT0038','SKUHT0055','SKUHT0012','Bayer','Multicolor'],
            ['hiiphooray-tani','SKUHT0011','Insektisida Nematisida Furadan 1KG Sistemik Kontak',27000,20,1150,NULL,NULL,NULL,'SKUHT0026','SKUHT0010','SKUHT0012','SKUHT0013','SKUHT0009','FMC','Multicolor'],
            ['hiiphooray-tani','SKUHT0012','Insektisida Regent 50SC 50ml Sistemik Kontak Hama KO',21500,20,200,NULL,NULL,NULL,'SKUHT0015','SKUHT0011','SKUHT0038','SKUHT0055','SKUHT0012','Regent','Multicolor'],
            ['hiiphooray-tani','SKUHT0013','Mulsa Hitam Perak Montana Lebar 60cm Efek ke Warna Buah',4000,100,40,NULL,NULL,NULL,'SKUHT0059','SKUHT0040','SKUHT0037','SKUHT0060','SKUHT0026','Montana','Multicolor'],
            ['hiiphooray-tani','SKUHT0014','Paranet Maxima 80 persen Lebar 3 Meter Bahan Kuat Cuaca',14500,0,200,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Maxima','Multicolor'],
            ['hiiphooray-tani','SKUHT0015','Perekat Perata Dustik 1 Liter Wajib Saat Semprot',45000,5,1300,NULL,NULL,NULL,'SKUHT0024','SKUHT0003','SKUHT0004','SKUHT0009','SKUHT0010','Dustik','Multicolor'],
            ['hiiphooray-tani','SKUHT0016','POC Hantu Biogen 500ml Pembuahan',65000,10,650,NULL,NULL,NULL,'SKUHT0017','SKUHT0069','SKUHT0015','SKUHT0038','SKUHT0039','Jimmy Hantu','Multicolor'],
            ['hiiphooray-tani','SKUHT0017','POC Hantu Biogen 500ml Pertumbuhan',65000,10,650,NULL,NULL,NULL,'SKUHT0016','SKUHT0069','SKUHT0015','SKUHT0024','SKUHT0039','Jimmy Hantu','Multicolor'],
            ['hiiphooray-tani','SKUHT0018','Polybag 10x15 Untuk Semai Bahan Awet Tahan Lama',100,1000,3,NULL,NULL,NULL,'SKUHT0019','SKUHT0062','SKUHT0065','SKUHT0066','SKUHT0040','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0019','Polybag 15x15 Untuk Semai Bahan Awet Tahan Lama',150,800,5,NULL,NULL,NULL,'SKUHT0018','SKUHT0020','SKUHT0062','SKUHT0066','SKUHT0069','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0020','Polybag 20x20 Bahan Awet Tahan Lama',300,300,10,NULL,NULL,NULL,'SKUHT0019','SKUHT0021','SKUHT0063','SKUHT0066','SKUHT0069','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0021','Polybag 25x25 Bahan Awet Tahan Lama',500,200,20,NULL,NULL,NULL,'SKUHT0020','SKUHT0022','SKUHT0063','SKUHT0065','SKUHT0069','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0022','Polybag 35x35 Bahan Awet Tahan Lama',700,100,30,NULL,NULL,NULL,'SKUHT0021','SKUHT0023','SKUHT0060','SKUHT0065','SKUHT0059','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0023','Polybag 40x40 Bahan Awet Tahan Lama',900,50,40,NULL,NULL,NULL,'SKUHT0022','SKUHT0060','SKUHT0065','SKUHT0039','SKUHT0059','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0024','Pressure Sprayer Vistar 5L Semprotan Bertekanan',125000,3,2000,NULL,NULL,NULL,'SKUHT0015','SKUHT0003','SKUHT0008','SKUHT0010','SKUHT0038','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0025','Pupuk KNO3 Merah Pak Tani 2KG Bereaksi Cepat',50000,10,2300,NULL,NULL,NULL,'SKUHT0069','SKUHT0037','SKUHT0040','SKUHT0052','SKUHT0064','Pak Tani','Multicolor'],
            ['hiiphooray-tani','SKUHT0026','Pupuk NPK Mutiara 16-16-16 1KG Ekstra Mg Ca',13000,100,1150,'https://www.youtube.com/watch?v=bD1R72hAdAQ','https://www.youtube.com/watch?v=fnLzD7NoXM8',NULL,'SKUHT0039','SKUHT0040','SKUHT0065','SKUHT0028','SKUHT0027','Mutiara','Multicolor'],
            ['hiiphooray-tani','SKUHT0027','Pupuk NPK Mutiara Grower 15-09-20 1KG Ekstra TE',15000,24,1150,NULL,NULL,NULL,'SKUHT0039','SKUHT0040','SKUHT0066','SKUHT0028','SKUHT0026','Mutiara Grower','Multicolor'],
            ['hiiphooray-tani','SKUHT0028','Vitamin B1 Thiamine Grow Quick Plus 100ml Cepat Tumbuh',22000,20,200,NULL,NULL,NULL,'SKUHT0039','SKUHT0019','SKUHT0029','SKUHT0017','SKUHT0069','Grow','Multicolor'],
            ['hiiphooray-tani','SKUHT0029','ZPT Atonik 100ml Cepat Tumbuhnya',18500,20,250,NULL,NULL,NULL,'SKUHT0028','SKUHT0039','SKUHT0020','SKUHT0017','SKUHT0052','Atonik','Multicolor'],
            ['hiiphooray-tani','SKUHT0030','Benih Unggul Jawara Caisim Manis GLORY Daun Renyah dan Tebal',18000,15,40,NULL,NULL,NULL,'SKUHT0032','SKUHT0065','SKUHT0018','SKUHT0019','SKUHT0060','Benih Unggul JAWARA','Multicolor'],
            ['hiiphooray-tani','SKUHT0031','Benih Unggul Jawara Cabe Rawit SIUNG Sangat Produktif',19000,15,35,NULL,NULL,NULL,'SKUHT0033','SKUHT0065','SKUHT0018','SKUHT0019','SKUHT0027','Benih Unggul JAWARA','Multicolor'],
            ['hiiphooray-tani','SKUHT0032','Benih Unggul Jawara Kangkung WALET Daun Renyah',17000,6,150,NULL,NULL,NULL,'SKUHT0030','SKUHT0065','SKUHT0018','SKUHT0019','SKUHT0060','Benih Unggul JAWARA','Multicolor'],
            ['hiiphooray-tani','SKUHT0033','Benih Unggul Jawara Timun Hijau MAESTRO Manis Renyah',21000,5,35,NULL,NULL,NULL,'SKUHT0031','SKUHT0065','SKUHT0018','SKUHT0019','SKUHT0060','Benih Unggul JAWARA','Multicolor'],
            ['hiiphooray-tani','SKUHT0034','Peralatan Berkebun Bestguard E50 Garden Combination Tool',31000,5,400,NULL,NULL,NULL,'SKUHT0020','SKUHT0039','SKUHT0037','SKUHT0040','SKUHT0035','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0035','Sekop Mini Sendok Tanah Untuk Hobi Berkebun',12000,5,200,NULL,NULL,NULL,'SKUHT0019','SKUHT0039','SKUHT0037','SKUHT0040','SKUHT0034','no brand','Hitam'],
            ['hiiphooray-tani','SKUHT0036','Terusi CuSO4 Copper Sulfate 100gr Fungisida Berspektrum Luas',10000,9,150,NULL,NULL,NULL,'SKUHT0015','SKUHT0071','SKUHT0024','SKUHT0056','SKUHT0003','no brand','Biru'],
            ['hiiphooray-tani','SKUHT0037','Garam Inggris Magnesium Sulfate MgSO4 250gr Pupuk Wajib',10000,4,280,NULL,NULL,NULL,'SKUHT0039','SKUHT0040','SKUHT0052','SKUHT0061','SKUHT0069','no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0038','Pressure Sprayer Kyokan 1L Simpel dan Praktis',40000,2,1100,NULL,NULL,NULL,'SKUHT0010','SKUHT0015','SKUHT0003','SKUHT0071','SKUHT0024','Kyokan','Multicolor'],
            ['hiiphooray-tani','SKUHT0039','Kapur Dolomit Super 1KG Ekstra MgO Menaikan pH',3000,48,1150,NULL,NULL,NULL,'SKUHT0002','SKUHT0040','SKUHT0069','SKUHT0065','SKUHT0059','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0040','Pupuk Magnesium Kalsium Panen Raya 1KG Penyubur dan Pembenah Tanah',7000,48,1150,'https://www.youtube.com/watch?v=U0Qbsh_oDYY&t=169s','https://www.youtube.com/watch?v=lRi_qNz0BlE',NULL,'SKUHT0039','SKUHT0026','SKUHT0013','SKUHT0066','SKUHT0061','Panen Raya','Multicolor'],
            ['hiiphooray-tani','SKUHT0041','Pupuk MKP Pak Tani 1KG Pembuahan dan Pembungaan',40000,20,1150,NULL,NULL,NULL,'SKUHT0064','SKUHT0052','SKUHT0025','SKUHT0043','SKUHT0037','Pak Tani','Multicolor'],
            ['hiiphooray-tani','SKUHT0042','Benih Unggul Jawara Semangka Hibrid FIFA F1 Buah Besar',28000,5,15,NULL,NULL,NULL,'SKUHT0033','SKUHT0065','SKUHT0039','SKUHT0027','SKUHT0019','Benih Unggul JAWARA','Multicolor'],
            ['hiiphooray-tani','SKUHT0043','Pupuk Kalsium Nitrat Meroke Karate Plus Boroni 1KG Pembuahan',11000,24,1150,NULL,NULL,NULL,'SKUHT0064','SKUHT0072','SKUHT0052','SKUHT0041','SKUHT0037','KARATE PLUS BORONI','Multicolor'],
            ['hiiphooray-tani','SKUHT0044','Pupuk NP 12-60 Pak Tani Ultradap 1KG Pembuahan dan Pembungaan',38000,20,1150,NULL,NULL,NULL,'SKUHT0069','SKUHT0041','SKUHT0037','SKUHT0064','SKUHT0041','Pak Tani','Multicolor'],
            ['hiiphooray-tani','SKUHT0045','Pupuk NK 15-15 Meroke CPN 1KG Pembuahan',24000,2,1150,NULL,NULL,NULL,'SKUHT0037','SKUHT0016','SKUHT0064','SKUHT0067','SKUHT0072','MerokeCPN','Multicolor'],
            ['hiiphooray-tani','SKUHT0046','Pupuk NP 12-61 Meroke MAP 1KG Pembungaan',34000,2,1150,NULL,NULL,NULL,'SKUHT0037','SKUHT0039','SKUHT0064','SKUHT0056','SKUHT0067','Meroke MAP','Multicolor'],
            ['hiiphooray-tani','SKUHT0047','Pupuk NPK 8-9-39+3MgO+TE Meroke Flex-G 1KG',45000,2,1150,NULL,NULL,NULL,'SKUHT0069','SKUHT0039','SKUHT0041','SKUHT0052','SKUHT0072','Meroke Flex-G','Multicolor'],
            ['hiiphooray-tani','SKUHT0048','Pupuk MKP Meroke 1KG Pembuahan dan Pembungaan',35000,2,1150,NULL,NULL,NULL,'SKUHT0052','SKUHT0072','SKUHT0025','SKUHT0037','SKUHT0024','Meroke MKP','Multicolor'],
            ['hiiphooray-tani','SKUHT0049','Pupuk NPK 6-27-38+TE Meroke Provit Maxi 500gr Pembuahan dan Pembungaan',26000,2,600,NULL,NULL,NULL,'SKUHT0052','SKUHT0072','SKUHT0025','SKUHT0037','SKUHT0024','Provit','Multicolor'],
            ['hiiphooray-tani','SKUHT0050','Pupuk Kalsium Nitrat Meroke Calnit 1KG Pertumbuhan Cepat',13500,24,1150,NULL,NULL,NULL,'SKUHT0017','SKUHT0026','SKUHT0035','SKUHT0020','SKUHT0069','Meroke Calnit','Multicolor'],
            ['hiiphooray-tani','SKUHT0051','Pupuk MgO+SO3 Meroke MAG-S 1KG Setara Garam Inggris',13000,2,1150,NULL,NULL,NULL,'SKUHT0037','SKUHT0039','SKUHT0060','SKUHT0035','SKUHT0023','Meroke MAG-S','Multicolor'],
            ['hiiphooray-tani','SKUHT0052','Pupuk Boron Plus MgO 1KG Penghobi Wajib Punya',30000,20,1150,NULL,NULL,NULL,'SKUHT0064','SKUHT0041','SKUHT0069','SKUHT0043','SKUHT0067','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0053','Pupuk Guano Beautiful Orange Pembuahan dan Pembungaan',32000,4,1000,NULL,NULL,NULL,'SKUHT0069','SKUHT0070','SKUHT0039','SKUHT0002','SKUHT0061','Beautiful','Multicolor'],
            ['hiiphooray-tani','SKUHT0054','Paranet Maxima 75 persen Lebar 3 Meter Bahan Kuat Cuaca',14500,205,200,NULL,NULL,NULL,'SKUHT0016','SKUHT0029','SKUHT0002','SKUHT0013','SKUHT0068','Maxima','Multicolor'],
            ['hiiphooray-tani','SKUHT0055','Paranet Bintang 65 persen Lebar 3 Meter Bahan Kuat Cuaca',14000,100,205,NULL,NULL,NULL,'SKUHT0016','SKUHT0029','SKUHT0001','SKUHT0013','SKUHT0067','Bintang','Multicolor'],
            ['hiiphooray-tani','SKUHT0056','Paranet Maxima 70 persen Lebar 3 Meter Bahan Kuat Cuaca',14250,100,205,NULL,NULL,NULL,'SKUHT0016','SKUHT0029','SKUHT0002','SKUHT0013','SKUHT0068','Maxima','Multicolor'],
            ['hiiphooray-tani','SKUHT0057','Pelet Ikan Hi-Pro-Vite 781-2 Repack 1 Kg Membesarkan Ikan Kecil',13000,30,1150,NULL,NULL,NULL,'SKUHT0001','SKUHT0068','SKUHT0039','SKUHT0056','SKUHT0058','Hi-Pro-Vite 781','Multicolor'],
            ['hiiphooray-tani','SKUHT0058','Pelet Ikan Hi-Pro-Vite 781 Repack 1 Kg Penggemukan Ikan',13000,30,1150,NULL,NULL,NULL,'SKUHT0001','SKUHT0067','SKUHT0039','SKUHT0055','SKUHT0057','Hi-Pro-Vite 781','Multicolor'],
            ['hiiphooray-tani','SKUHT0059','Kapur Dolomit Super 10KG Ekstra MgO Menaikan pH',27000,100,12000,NULL,NULL,NULL,'SKUHT0002','SKUHT0040','SKUHT0069','SKUHT0065','SKUHT0039','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0060','Planter Bag Easy Grow 50L Bahan Kuat Tahan Lama',18000,100,160,'https://youtu.be/lCMSmIRFR1E',NULL,NULL,'SKUHT0061','SKUHT0020','SKUHT0039','SKUHT0065','SKUHT0013','Easy Grow','Multicolor'],
            ['hiiphooray-tani','SKUHT0061','Planter Bag Easy Grow 75L Bahan Kuat Tahan Lama',24000,100,220,'https://youtu.be/lCMSmIRFR1E',NULL,NULL,'SKUHT0060','SKUHT0073','SKUHT0059','SKUHT0066','SKUHT0013','Easy Grow','Multicolor'],
            ['hiiphooray-tani','SKUHT0062','Seedlings Bag Easy Grow L 12x12cm Degradable Akar Gembira',900,1000,10,NULL,NULL,NULL,'SKUHT0063','SKUHT0019','SKUHT0066','SKUHT0039','SKUHT0017','Easy Grow','Multicolor'],
            ['hiiphooray-tani','SKUHT0063','Seedlings Bag Easy Grow XL 15x15cm Degradable Akar Gembira',1100,1000,12,NULL,NULL,NULL,'SKUHT0062','SKUHT0020','SKUHT0066','SKUHT0039','SKUHT0017','Easy Grow','Putih'],
            ['hiiphooray-tani','SKUHT0064','Pupuk KNO3 Putih Pak Tani 2KG High Kalium Pembuahan',53000,15,2300,NULL,NULL,NULL,'SKUHT0069','SKUHT0072','SKUHT0040','SKUHT0052','SKUHT0025','Pak Tani','Multicolor'],
            ['hiiphooray-tani','SKUHT0065','Media Tanam 1 Pack Tanaman Buah, Sayur, Hias',15000,10,3500,NULL,NULL,NULL,'SKUHT0039','SKUHT0018','SKUHT0040','SKUHT0055','SKUHT0065','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0066','Media Tanam 1 Pack Porous',15000,10,2300,NULL,NULL,NULL,'SKUHT0039','SKUHT0019','SKUHT0040','SKUHT0056','SKUHT0065','OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0067','Waring Jaring Cap Jangkar Lebar 1.2 Meter Murah',4000,80,120,NULL,NULL,NULL,'SKUHT0058','SKUHT0001','SKUHT0055','SKUHT0039','SKUHT0068','Jangkar','Hitam'],
            ['hiiphooray-tani','SKUHT0068','Waring Jaring Cap Jangkar Mas Lebar 1.2 Meter Lubang Anti Geser',5500,100,120,NULL,NULL,NULL,'SKUHT0057','SKUHT0001','SKUHT0056','SKUHT0039','SKUHT0067','Jangkar Mas','Hitam'],
            ['hiiphooray-tani','SKUHT0069','Pupuk Guano Taiwan per Kantong Import Premium',2500,2000,30,'https://www.youtube.com/watch?v=JGSSm3swoDc&t=28s',NULL,NULL,'SKUHT0016','SKUHT0041','SKUHT0039','SKUHT0067','SKUHT0070','Guano','Multicolor'],
            ['hiiphooray-tani','SKUHT0070','Pupuk Guano Taiwan 40 Kantong (1 Pack) Import Premium',70000,50,1100,'https://www.youtube.com/watch?v=JGSSm3swoDc&t=28s',NULL,NULL,'SKUHT0016','SKUHT0041','SKUHT0039','SKUHT0068','SKUHT0069','Guano','Multicolor'],
            ['hiiphooray-tani','SKUHT0071','Kepala Semprotan Misty Hand Sprayer Awet dan Kuat',15000,20,200,NULL,NULL,NULL,'SKUHT0010','SKUHT0003','SKUHT0035','SKUHT0008','SKUHT0038','Misty Cool','Hijau'],
            ['hiiphooray-tani','SKUHT0072','Pembungkus Buah Fruit Cover Easy Grow XL 30x40 Pelindung Buah',1800,500,10,NULL,NULL,NULL,'SKUHT0067','SKUHT0041','SKUHT0064','SKUHT0052','SKUHT0040','Easy Grow','Putih'],
            ['hiiphooray-tani','SKUHT0073','Planter Bag Easy Grow 100L Bahan Kuat Tahan Lama',37000,50,370,'https://www.youtube.com/watch?v=bD1R72hAdAQ',NULL,NULL,'SKUHT0061','SKUHT0021','SKUHT0059','SKUHT0066','SKUHT0013','Easy Grow','Hijau'],
            ['hiiphooray-tani','SKUHT0074','Turus Penyangga Tanaman 50cm Bahan Coco Fiber',12000,3,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0075','Turus Penyangga Tanaman 70cm Bahan Coco Fiber',15000,3,250,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0076','Turus Penyangga Tanaman 100cm Bahan Coco Fiber',20000,3,400,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0077','Bakteri Baik EM4 1 Liter Pengolah Limbah dan Toilet Septic Tank',23000,15,1300,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'EM4','Multicolor'],
            ['hiiphooray-tani','SKUHT0078','Bakteri Baik EM4 1 Liter Peternakan Hewan Sehat Kuat Semangat',22500,15,1300,NULL,NULL,NULL,'SKUHT0001','SKUHT0077',NULL,NULL,NULL,'EM4','Multicolor'],
            ['hiiphooray-tani','SKUHT0079','Drum Galvanis Pot Tanaman Tahan Karat Awet Turun Temurun',160000,100,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0080','Drum Besi Pot Tanaman Dilapisi Cat',125000,100,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0081','Paket Tanaman Buah Senior Tinggal Menikmati Hasil',1200000,100,10,'https://www.youtube.com/watch?v=G8HyWWmpQUI','https://www.youtube.com/watch?v=qNIPjG_3sQM',NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0082','Paket Bibit Tanaman Buah Junior Kirim Kondisi Segar',220000,100,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0083','Grafing Tool Gunting Okulasi Alat Sambung Tanaman dan Memotong',68500,10,400,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Taffware','Multicolor'],
            ['hiiphooray-tani','SKUHT0084','Tape Tool Alat Pengikat Perambat Tanaman Cepat dan Rapi',150000,10,710,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'VKTECH','Multicolor'],
            ['hiiphooray-tani','SKUHT0085','PH Meter Tanah dan Alat Ukur Kelembapan Serta Light Sensor',48000,10,110,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'OEM','Multicolor'],
            ['hiiphooray-tani','SKUHT0086','Mata Bor Pelubang Tanah Untuk Menanam dan Resapan Air',38000,10,160,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'MPT','Multicolor'],
            ['hiiphooray-tani','SKUHT0087','Penyiram Tanaman Otomatis Aman Saat Ditinggal Keluar Kota',14000,50,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ROBESBON','Multicolor'],
            ['hiiphooray-tani','SKUHT0088','Termometer Hygrometer Digital Dilengkapi Jam Dengan External Module',48000,15,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Taffware','Multicolor'],
            ['hiiphooray-tani','SKUHT0089','Termometer Hygrometer Digital Dilengkapi Jam',35000,15,110,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Taffware','Multicolor'],
            ['hiiphooray-tani','SKUHT0090','Penyiram Tanaman Otomatis Isi 2 Penyedot Air Wadah Sekitar',20000,30,110,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0091','Hormon Tanaman Strepson 100ml Mutasi Varigata Permanen',41000,24,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0092','Hormon Tanaman Triakontanol 100ml Aktivator Hormon Tanaman',25000,24,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0093','Hormon Tanaman Auksin 100ml Besar dan Panjangkan Akar',25000,24,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0094','Hormon Tanaman Sitokinin 100ml Besar Panjangkan Batang dan Tunas Daun',25000,24,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0095','Hormon Tanaman CPPU 100ml Besarkan Buah dan Mata Tunas',27500,24,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0096','Hormon Tanaman Giberelin GA3 100ml Pembungaan dan Pembuahan',25000,24,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0097','Hormon Tanaman Mix Auksin Giberelin GA3 100ml Fase Generatif',27500,12,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0098','Hormon Tanaman Mix Auksin Sitokinin 100ml Fase Vegetatif',27500,12,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0099','Media Tanam Kompos Bambu 15 Liter Porous dan Subur',25000,100,3500,'https://www.youtube.com/watch?v=BB2nzYTzDlI','https://www.youtube.com/watch?v=XaBTK2RGV8g','https://www.youtube.com/watch?v=TP0w_LTMY14',NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0100','Media Tanam Kompos Bambu 5 Liter Porous dan Subur',12500,100,1300,'https://www.youtube.com/watch?v=BB2nzYTzDlI','https://www.youtube.com/watch?v=XaBTK2RGV8g','https://www.youtube.com/watch?v=TP0w_LTMY14',NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0101','Pupuk Kompos Bambu Pilihan 15 Liter Trichoderma dan PGPR Alami',35000,100,3500,'https://www.youtube.com/watch?v=BB2nzYTzDlI','https://www.youtube.com/watch?v=XaBTK2RGV8g','https://www.youtube.com/watch?v=TP0w_LTMY14',NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0102','Pupuk Kompos Bambu Pilihan 5 Liter Trichoderma dan PGPR Alami',17500,100,1300,'https://www.youtube.com/watch?v=BB2nzYTzDlI','https://www.youtube.com/watch?v=XaBTK2RGV8g','https://www.youtube.com/watch?v=TP0w_LTMY14',NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0103','Turus Penyangga Tanaman 30cm Bahan Coco Fiber',6000,20,400,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0104','Turus Penyangga Tanaman 60cm Bahan Coco Fiber',12000,20,200,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
            ['hiiphooray-tani','SKUHT0105','PH Meter Digital Air Alat Ukur PH Air Terkalibrasi',51000,20,120,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no brand','Multicolor'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('produk');
    }
}
