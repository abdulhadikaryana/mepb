Nama Aplikasi:  Manajemen Kinerja Penggiat Budaya

Tugas utama:
1. Penyebarluasan Informasi
2. Konsolidasi permasalahan
3. Pendataan

- Tiap hari mengerjakan minimal 1 tugas utama
- Di penyebarluasan informasi ada tema:
   - layanan umum
   - bantuan pemerintah
   - event/kegiatan/lomba
- Di penyebarluasan informasi ada topik (nanti ditentukan untuk di tambah di sistem)
- Record bisa edit, tidak boleh hapus.

Level User
    - Setditjen
        - Group Administrator
        - Group Kelengkapan Administrasi
        - Group UPT
            - Group Dinas Kab/Kota
                - Group Penggiat

- Penyebaran info lewat medsos (twitter), informasi dari akun ditjen kebudayaan kemdikbud di retweet oleh penyuluh budaya

Penggiat budaya harus membuat laporan triwulan berupa:
    - print laporan kegiatan tiap bulan
    - laporan secara fisik setelah di setujui oleh dinas
    - laporan tersebut di upload di sistem

Penggiat budaya bisa mengunggah dokumen
    - BPJS
    - Absensi

Pastikan apakah geo tagging bisa langsung aktif di aplikasi mobile.



======================================================================================

Nama penggiat | penyebarluasan | konsolidasi | pendataan 


======================================================================================

Kemdikbud
    UPT
======================================================================================

CREATE OR REPLACE VIEW view_kegiatan AS
(SELECT 'penyebarluasan informasi' AS kegiatan, penyebarluasan.id, DATE_FORMAT(penyebarluasan.tanggal_entri, '%Y-%m-%d') AS tanggal_entri, penyebarluasan.lokasi, penyebarluasan.created_by, penyebarluasan.tema AS obyek, user.username, user.id as userid, profile.fullname from user LEFT JOIN profile ON profile.user_id = user.id LEFT JOIN penyebarluasan ON penyebarluasan.created_by = user.id WHERE user.group=40) 
UNION (SELECT 'konsolidasi masalah' AS kegiatan, konsolidasi.id, DATE_FORMAT(konsolidasi.tanggal_entri, '%Y-%m-%d') AS tanggal_entri, konsolidasi.lokasi, konsolidasi.created_by, konsolidasi.metode AS obyek, user.username, user.id as userid, profile.fullname from user LEFT JOIN profile ON profile.user_id = user.id LEFT JOIN konsolidasi ON konsolidasi.created_by = user.id WHERE user.group=40) 
UNION (SELECT 'pendataan' AS kegiatan, pendataan.id, DATE_FORMAT(pendataan.tanggal_entri, '%Y-%m-%d') AS tanggal_entri, pendataan.lokasi, pendataan.created_by, pendataan.obyek AS obyek, user.username, user.id as userid, profile.fullname from user LEFT JOIN profile ON profile.user_id = user.id LEFT JOIN pendataan ON pendataan.created_by = user.id WHERE user.group=40)
ORDER BY kegiatan,id,tanggal_entri


=========================================================================================
API Dapobud
https://penggiat.dapobud.kemdikbud.go.id/web/mobile-api/api/data-by-date?date=2017-06-18

{
    "dataid": 2431,
    "nama": "Mardiono",
    "desakel": "Air Belo",
    "kecamatan": "Mentok",
    "kabupatenkota": "Kab. Bangka Barat",
    "provinsi": "Prov. Bangka Belitung",
    "email": "elegi77@yahoo.co.id",
    "tanggal_entri": "2017-06-18 10:32:14",
    "point_lokasi_objek": "POINT(-2.05186 105.208)",
    "jenis": "Tenaga Budaya",
    "latitude": -2.05186,
    "longitude": 105.208
},


====================================
Tidak ada di daftar penggiat:
--------------------------------
acid.numb@ymail.com
any_fom@yahoo.com
saktidwi23@gmail.com
indah082108@gmail.com
ermangogo@gmail.com
mamik.wiigati@gmail.com
lily.nurullita@yahoo.co.id
norman.supit@gmail.com
welovetradition@gmail.com
rifaatulhuda@yahoo.co.id
ramadinda.sucita@gmail.com
terry_ses@ymail.com
speedindie@gmail.com
mas.sumari@yahoo.com
karyana.abdhadi@gmail.com

===============================
Tidak ada di laporan bulan juni
----------------------------
1. Fadhil Fachrian
2. Fransh Antoh
3. Masitah
4. Nelsano Anesry 
5. Rizal Kamsurya


============================
API Google MAP
----------------------------
AIzaSyD_Zi42hif-HM8iaG92u2rU0_0N-56uM7o

=============================
EMAIL GOOGLE
----------------------------
cat.kemendikbud
$$gedungFSudirman


==============================
INSERT INTO view_master (kegiatan,id_kegiatan,tanggal_entri,lokasi,desakel,kecamatan,kabupatenkota,provinsi,obyek,topik,created_by)
SELECT 'penyebarluasan',id,tanggal_entri,lokasi,desakel,kecamatan,kabupatenkota,provinsi,tema,topik,created_by
FROM penyebarluasan

INSERT INTO view_master (kegiatan,id_kegiatan,tanggal_entri,lokasi,desakel,kecamatan,kabupatenkota,provinsi,obyek,topik,created_by)
SELECT 'konsolidasi',id,tanggal_entri,lokasi,desakel,kecamatan,kabupatenkota,provinsi,metode,sub_metode,created_by
FROM konsolidasi

INSERT INTO view_master (kegiatan,id_kegiatan,tanggal_entri,lokasi,desakel,kecamatan,kabupatenkota,provinsi,obyek,topik,created_by)
SELECT 'pendataan',id,tanggal_entri,lokasi,desakel,kecamatan,kabupatenkota,provinsi,obyek,name,created_by
FROM pendataan


==============================
select id,username, user.group,
(SELECT count(id) FROM view_master WHERE user.id = view_master.created_by and kegiatan='penyebarluasan') as penyebarluasan,
(SELECT count(id) FROM view_master WHERE user.id = view_master.created_by and kegiatan='konsolidasi') as konsolidasi,
(SELECT count(id) FROM view_master WHERE user.id = view_master.created_by and kegiatan='pendataan') as pendataan
FROM USER
WHERE user.group=40
ORDER BY username ASC