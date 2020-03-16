# WEBSERVICE DEFINITION
=======================
## Microtime
```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/helpers/microtime
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
|                                  | {                                               |
|                                  |    microtime: DEC                               |
|                                  | }                                               |
|                                  |                                                 |

## Tema dan Topik
```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/helpers/tema-topik
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
|                                  | {                                               |
|                                  |     status: ok/error,                           |
|                                  |     message: data return/no data return,        |
|                                  |     data: {                                     |
|                                  |        penyebaran_info: [                       |
|                                  |            {                                    |
|                                  |                id_tema: INT,                    |
|                                  |                nama_tema: STRING,               |
|                                  |                topik: [                         |
|                                  |                    {                            |
|                                  |                        id: INT,                 |
|                                  |                        nama_topik: STRING       |
|                                  |                    },                           |
|                                  |                    ...                          |
|                                  |                ]                                |
|                                  |             }                                   |
|                                  |         ],                                      |
|                                  |        konsolidasi_masalah: [                   |
|                                  |            {                                    |
|                                  |                id_tema: INT,                    |
|                                  |                nama_tema: STRING,               |
|                                  |                topik: [                         |
|                                  |                    {                            |
|                                  |                        id: INT,                 |
|                                  |                        nama_topik: STRING       |
|                                  |                    },                           |
|                                  |                    ...                          |
|                                  |                ]                                |
|                                  |            }                                    |
|                                  |        ]                                        |
|                                  |     },                                          |
|                                  | }                                               |
|                                  |                                                 |

## Check UUID Penyebarluasan
```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/helpers/check-uuid-penyebarluasan
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
| uuid: RANDOM_STRING              | {                                               |
|                                  |    true/false                                   |
|                                  | }                                               |
|                                  |                                                 |

## Check UUID Konsolidasi
```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/helpers/check-uuid-konsolidasi
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
| uuid: RANDOM_STRING              | {                                               |
|                                  |    true/false                                   |
|                                  | }                                               |
|                                  |                                                 |

## Login/autentikasi
Proses login dari pengguna aplikasi akan memerlukan dua parameter yaitu username dan password. Response merupakan data probadi pengguna serta counter supply dan demand yang di-posting dan di-response (direspon pengguna lain). ID database tidak disertakan dalam data user, digantikan oleh token_string. Selama token string masih valid/tidak melebihi masa expired maka user tetap bisa menggunakan protected webservice tanpa perlu login ulang. 
Agar token string sangat unik dan tidak sama antar pengguna, dalam pembuatan token_string perlu disertakan id database dan/atau datetime/unixtime saat user melakukan login.

```javascript
Method: POST
Header: { Content-type: "application/json" }
Path: /v1/websvc-auth/login
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
| {                                | {                                               |
|      username: "username"        |   status: success/error,                        |
|      password: "password"        |   message: login berhasil/failed                |
| }                                |   data: [                                       |
|                                  |     {                                           |
|                                  |        id: id                                   |
|                                  |        username: "username",                    |
|                                  |        email: "email",                          |
|                                  |        token_string: "token",                   |
|                                  |        token_expired: "YYYY-MM-DD HH:mm:ss",    |
|                                  |    }                                            |
|                                  |   ]                                             |
|                                  | }                                               |

## Profile
Untuk mendapatkan, mengedit profile user melalui aplikasi

### Get Profile
Untuk mendapatkan profile

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/user/profile
```
| Request                          | Response                                            | 
|----------------------------------|-----------------------------------------------------|
|                                  |  {                                                  |                      
|                                  |      status: ok/error,                              |
|                                  |      message: profile berhasil diambil/belum ada,   |
|                                  |      data: {                                        |
|                                  |          fullname: STRING,                          |
|                                  |          phone: STRING,                             |
|                                  |          birthdate: YYYY-MM-DD,                     |
|                                  |          gender: STRING,                            |
|                                  |          gender_code: M/F,                          |
|                                  |          photo: base64:IMG_STRING,                  |
|                                  |          address: STRING,                           |
|                                  |          kecamatan_id: INT,                         |
|                                  |          kecamatan: STRING,                         |
|                                  |          kabkota_id: INT,                           |
|                                  |          kabupatenkota: STRING,                     |
|                                  |          provinsi_id: INT,                          |
|                                  |          provinsi: STRING,                          |
|                                  |          twitter: STRING                            |
|                                  |    }                                                |
|                                  |  }                                                  |
|                                  |                                                     |


### Create Profile
Untuk membuat profile

```javascript
Method: POST
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/user/create-profile
```
| Request                          | Response                                            | 
|----------------------------------|-----------------------------------------------------|
| {                                | {                                                   |
| 	  fullname: STRING,            |    status: ok/error,                                |
| 	  phone: STRING,               |    message: data berhasil disimpan/ada kesalahan,   |
| 	  birthdate: DD-MM-YYYY,       |    data: {                                          |
| 	  gender: ENUM(M, F),          |        fullname: STRING,                            |
| 	  address: STRING,             |        phone: STRING,                               |
| 	  kecamatan_id: INT,           |        birthdate: YYYY-MM-DD,                       |
| 	  kabkota_id: INT,             |        gender: STRING,                              |
|     provinsi_id: INT,            |        gender_code: M/F,                            |
| 	  twitter: STRING              |        address: STRING,                             |
| }                                |        kecamatan_id: INT,                           |
|                                  |        kecamatan: STRING,                           |
|                                  |        kabkota_id: INT,                             |
|                                  |        kabupatenkota: STRING,                       |
|                                  |        provinsi_id: INT,                            |
|                                  |        provinsi: STRING,                            |
|                                  |        twitter: STRING                              |
|                                  |                                                     |
|                                  |    }                                                |
|                                  |  }                                                  |


### Update Profile
Untuk mengubah profile

```javascript
Method: PATCH
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/user/update-profile
```
| Request                          | Response                                            | 
|----------------------------------|-----------------------------------------------------|
| {                                | {                                                   |
| 	  fullname: STRING,            |    status: ok/error,                                |
| 	  phone: STRING,               |    message: data berhasil disimpan/ada kesalahan,   |
| 	  birthdate: DD-MM-YYYY,       |    data: {                                          |
| 	  gender: ENUM(M, F),          |        fullname: STRING,                            |
| 	  address: STRING,             |        phone: STRING,                               |
| 	  kecamatan_id: INT,           |        birthdate: YYYY-MM-DD,                       |
| 	  kabkota_id: INT,             |        gender: STRING,                              |
|     provinsi_id: INT,            |        gender_code: M/F,                            |
| 	  twitter: STRING              |        address: STRING,                             |
| }                                |        kecamatan_id: INT,                           |  
|                                  |        kecamatan: STRING,                           |
|                                  |        kabkota_id: INT,                             |
|                                  |        kabupatenkota: STRING,                       |
|                                  |        provinsi_id: INT,                            |
|                                  |        provinsi: STRING,                            |
|                                  |        twitter: STRING                              |
|                                  |    }                                                |
|                                  |  }                                                  |


### Get User Photo
Untuk mendapatkan foto user

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/user/user-photo
```
| Request                          | Response                                            | 
|----------------------------------|-----------------------------------------------------|
|                                  |  {                                                  |
|                                  |      status: ok/error,                              |
|                                  |      message: data return/no data return,           |
|                                  |      data: {                                        |
|                                  |            photo: base64:IMG_STRING                 |
|                                  |      }                                              |
|                                  |  }                                                  |
|                                  |                                                     |


### Update User Photo
Untuk mengubah foto user

```javascript
Method: PATCH
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/user/update-user-photo
```
| Request                          | Response                                            | 
|----------------------------------|-----------------------------------------------------|
| {                                |  {                                                  |
|    photo: base64:IMG_STRING      |        status: ok/error,                            |
| }                                |        message: update photo berhasil/gagal,        |
|                                  |        data: {                                      |
|                                  |             photo: base64:IMG_STRING                |
|                                  |        }                                            |
|                                  |  }                                                  |
|                                  |                                                     |


## Daftar Wilayah
Untuk mendapatkan daftar Provinsi/Kabupatenkota/Kecamatan. Akan digunakan untuk select box pada form aplikasi.

```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/wilayah/index
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
|                                  | {                                               |
|                                  |   status: ok/error,                             |
|                                  |   message: data return/no data return           |
|                                  |   data: [                                       |
|                                  |     {                                           |
|                                  |         id_provinsi: INT,                       |
|                                  |         nama_provinsi: STRING,                  |
|                                  |         kabupatenkota: [                        |
|                                  |            {                                    |
|                                  |               id_kabkota: INT,                  |
|                                  |               nama_kabkota: STRING,             |
|                                  |               kecamatan: [                      |
|                                  |                 {                               |
|                                  |                    id_kecamatan: INT,           |
|                                  |                    nama_kecamatan: STRING       |
|                                  |                  },                             |
|                                  |                  ...                            |
|                                  |                ]                                |
|                                  |            },                                   |
|                                  |            ...                                  |
|                                  |       }                                         |
|                                  |   ]                                             |
|                                  | }                                               |

## Daftar Provinsi
Untuk mendapatkan daftar Provinsi. Akan digunakan untuk select box pada form aplikasi.

```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/wilayah/provinsi
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
|                                  | {                                               |
|                                  |   status: ok/error,                             |
|                                  |   message: data return/no data return           |
|                                  |   data: [                                       |
|                                  |     {                                           |
|                                  |        id: INT,                                 |
|                                  |        nama_provinsi: STRING                    |
|                                  |     },                                          |
|                                  |     ...                                         |
|                                  |   ]                                             |
|                                  | }                                               |
|                                  |                                                 |                  

## Daftar Kabupatenkota
Untuk mendapatkan daftar Kabupaten/Kota. Akan digunakan untuk select box pada form aplikasi.

```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/wilayah/kabupatenkota
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
| {                                |  {                                              |
|   provinsi_id: INT               |     status: ok/error,                           |              
| }                                |     message: data return/no data return         |
|                                  |     data: [                                     |
|                                  |        {                                        |
|                                  |           id: INT,                              |
|                                  |           nama_kabkota: STRING,                 |
|                                  |           tipe: STRING,                         |
|                                  |           provinsi_id: INT                      |
|                                  |        },                                       |
|                                  |        ...                                      |
|                                  |     ]                                           |
|                                  |  }                                              |

## Daftar Kecamatan
Untuk mendapatkan daftar Kecamatan. Akan digunakan untuk select box pada form aplikasi.

```javascript
Method: GET
Header: { Content-type: "application/json" }
Path: /v1/wilayah/kecamatan
```
| Request                          | Response                                        | 
|----------------------------------|-------------------------------------------------|
| {                                |  {                                              |
|   kabkota _id: INT               |     status: ok/error,                           |              
| }                                |     message: data return/no data return         |
|                                  |     data: [                                     |
|                                  |        {                                        |
|                                  |           id: INT,                              |
|                                  |           nama_kecamatan: STRING,               |
|                                  |           kabkota_id: INT                       |
|                                  |        },                                       |
|                                  |        ...                                      |
|                                  |     ]                                           |
|                                  |  }                                              |

## Penyebarluasan Informasi
Laporan Penyebarluasan Informasi

### Tambah laporan Penyebarluasan Informasi

```javascript
Method: POST
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/penyebarluasan/create
```
| Request                                | Response                                        | 
|----------------------------------------|-------------------------------------------------|
| {                                      |  {                                              |
|   uuid: STRING,                        |      status: ok/error,                          |
| 	tanggal_entri: YYYY-MM-DD HH:mm:ss,  |      message: data berhasil disimpan,           |
| 	lokasi: STRING,                      |      data: [{                                   |
| 	desakel: STRING,                     |          id: INT,                               |
|   kecamatan: STRING,                   |          uuid: STRING,                          |
| 	kabupatenkota: STRING,               |          tanggal_entri: YYYY-MM-DD HH:mm:ss,    |
| 	provinsi: STRING,                    |          lokasi: STRING,                        |                      
| 	metode: Langsung/Tidak Langsung,     |          desakel: STRING,                       |
| 	tema: STRING,                        |          kecamatan: STRING,                     |
|   topik: STRING,                       |          kecamatan_id: INT,                     |
| 	audiens: INT,                        |          kabupatenkota: STRING,                 |
|   deskripsi: STRING,                   |          kabupatenkota_id: INT,                 |
| 	foto1: base64:IMG_STRING,            |          provinsi: STRING,                      |
|   foto2: base64:IMG_STRING,            |          provinsi_id: INT,                      |
| 	foto3: base64:IMG_STRING,            |          metode: STRING,                        |
| 	latitude: DEC,                       |          tema: STRING,                          |
| 	longitude: DEC                       |          topik: STING,                          |
| }                     	             |          audiens: INT,                          |
| 	                                     |          deskripsi: STRING,                     |
| 	                                     |          foto1: base64:IMG_STRING,              |
|                                        |          foto2: base64:IMG_STRING,              |
|                                        |          foto3: base64:IMG_STRING,              |
|                                        |          latitude: DEC,                         |
|                                        |          longitude: DEC,                        |
|                                        |      }]                                         |
|                                        |  }                                              |

### Get laporan Penyebarluasan Informasi

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/penyebarluasan/index
```
| Request                                | Response                                        | 
|----------------------------------------|-------------------------------------------------|
|                                        |  {                                              |
|                                        |    status: ok/error,                            |
|                                        |    message: "data return/no data return",       |
|                                        |    data: [                                      |
|                                        |      {                                          |
|                                        |          id: INT,                               |
|                                        |          uuid: STRING,                          |
|                                        |          tanggal_entri: YYYY-MM-DD HH:mm:ss,    |
|                                        |          lokasi: STRING,                        |
|                                        |          desakel: STRING,                       |
|                                        |          kecamatan: STRING,                     |
|                                        |          kecamatan_id: INT,                     |
|                                        |          kabupatenkota: STRING,                 |
|                                        |          kabupatenkota_id: INT,                 |
|                                        |          provinsi: STRING,                      |
|                                        |          provinsi_id: INT,                      |
|                                        |          metode: STRING,                        |
|                                        |          tema: STRING,                          |
|                                        |          topik:STRING,                          |
|                                        |          audiens: INT,                          |
|                                        |          deskripsi: STRING,                     |
|                                        |          foto1: base64:IMG_STRING,              |
|                                        |          foto2: base64:IMG_STRING,              |
|                                        |          foto3: base64:IMG_STRING,              |
|                                        |          latitude: DEC,                         |
|                                        |          longitude: DEC                         |
|                                        |      },                                         |
|                                        |      ...                                        |
|                                        |    ]                                            |
|                                        |  }                                              |
|                                        |                                                 |

## Konsolidasi Permasalahan
Laporan Konsolidasi Permasalahan

### Tambah laporan Konsolidasi Permasalahan

```javascript
Method: POST
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/konsolidasi/create
```
| Request                                     | Response                                        | 
|---------------------------------------------|-------------------------------------------------|
| {                                           |  {                                              |
|   uuid: STRING                              |     status: ok/error,                           |
|   tanggal_entri: YYYY-MM-DD HH:mm:ss,       |     message: data berhasil disimpan,            |
|	lokasi: STRING,                           |     data: [{                                    |
|	desakel: STRING,                          |         id: INT,                                |
|	kecamatan: STRING,                        |         uuid: STRING,                           |
|	kabupatenkota: STRING,                    |         tanggal_entri: YYYY-MM-DD HH:mm:ss,     |
|	provinsi: STRING,                         |         lokasi: STRING,                         |
|	metode: STRING,                           |         desakel: STRING,                        |
|	sub_metode: STRING,                       |         kecamatan: STRING,                      |
|   deskripsi: STRING,                        |         kecamatan_id: INT,                      |
|	solusi: STRING,                           |         kabupatenkota: STRING,                  |
|   foto1: base64:IMG_STRING,                 |         kabupatenkota_id: INT,                  |
|	foto2: base64:IMG_STRING,                 |         provinsi: STRING,                       |
|   foto3: base64:IMG_STRING,                 |         provinsi_id: INT,                       |
|	latitude: DEC,                            |         metode: STRING,                         |
|	longitude: DEC                            |         sub_metode: STRING,                     |
| }	                                          |         deskripsi: STRING,                      |
|	                                          |         solusi: STRING,                         |
|	                                          |         foto1: base64:IMG_STRING,               |
|                                             |         foto2: base64:IMG_STRING,               |
|                                             |         foto3: base64:IMG_STRING,               |
|                                             |         latitude: DEC,                          |
|                                             |         longitude: DEC                          |
|                                             |     }]                                          |
|                                             |  }                                              |
|                                             |                                                 |

### Get laporan Konsolidasi Permasalahan

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/konsolidasi/index
```
| Request                                | Response                                        | 
|----------------------------------------|-------------------------------------------------|
|                                        |  {                                              |
|                                        |    status: ok/error,                            |
|                                        |    message: "data return/no data return",       |
|                                        |    data: [                                      |
|                                        |      {                                          |
|                                        |          id: INT,                               |
|                                        |          uuid: STRING,                          |
|                                        |          tanggal_entri: YYYY-MM-DD HH:mm:ss,    |
|                                        |          lokasi: STRING,                        |
|                                        |          desakel: STRING,                       |
|                                        |          kecamatan: STRING,                     |
|                                        |          kecamatan_id: INT,                     |
|                                        |          kabupatenkota: STRING,                 |
|                                        |          kabupatenkota_id: INT,                 |
|                                        |          provinsi: STRING,                      |
|                                        |          provinsi_id: INT,                      |
|                                        |          metode: STRING,                        |
|                                        |          sub_metode: STRING,                    |
|                                        |          deskripsi:STRING,                      |
|                                        |          solusi: STRING,                        |
|                                        |          foto1: STRING,                         |
|                                        |          foto2: STRING,                         |
|                                        |          foto3: STRING,                         |
|                                        |          latitude: DEC,                         |
|                                        |          longitude: DEC                         |
|                                        |      },                                         |
|                                        |      ...                                        |
|                                        |    ]                                            |
|                                        |  }                                              |
|                                        |                                                 |

### Get Statistik Penyebarluasan

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/statistik/penyebarluasan
```
| Request                                | Response                                        | 
|----------------------------------------|-------------------------------------------------|
|                                        |  {                                              |
|                                        |    status: ok/error,                            |
|                                        |    message: "data return/no data return",       |
|                                        |    data: {                                      |
|                                        |       tanggal: DD-MM-YYY,                       |
|                                        |       today_count: INT,                         |
|                                        |       month_count: INT,                         |
|                                        |       total: INT                                |
|                                        |   }                                             |

### Get Statistik Konsolidasi

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/statistik/konsolidasi
```
| Request                                | Response                                        | 
|----------------------------------------|-------------------------------------------------|
|                                        |  {                                              |
|                                        |    status: ok/error,                            |
|                                        |    message: "data return/no data return",       |
|                                        |    data: {                                      |
|                                        |       tanggal: DD-MM-YYY,                       |
|                                        |       today_count: INT,                         |
|                                        |       month_count: INT,                         |
|                                        |       total: INT                                |
|                                        |   }                                             |

### Get Statistik Pendataan

```javascript
Method: GET
Header: { X-Auth-Token: "TOKEN_STRING", Content-type: "application/json" }
Path: /v1/statistik/pendataan
```
| Request                                | Response                                        | 
|----------------------------------------|-------------------------------------------------|
|                                        |  {                                              |
|                                        |    status: ok/error,                            |
|                                        |    message: "data return/no data return",       |
|                                        |    data: {                                      |
|                                        |       tanggal: DD-MM-YYY,                       |
|                                        |       today_count: INT,                         |
|                                        |       month_count: INT,                         |
|                                        |       total: INT                                |
|                                        |   }                                             |