<?php

require_once 'init.php';

if (Input::post("action") != "install") {
    jsonecho(0, 'Aksi tidak valid!');
}

$required_fields = ["hostname","username","password","database"];

foreach ($required_fields as $f) {
    if (!Input::post($f)) {
        jsonecho(0, "Tidak ada data: ".$f);
    }
}

if (!create_database(Input::post())) {
    jsonecho(0, "Database tidak dapat dibuat, harap cek kembali pengaturan Anda.");
} else if (!create_tables(Input::post())) {
    jsonecho(0, "Tabel database tidak dapat dibuat, harap cek kembali pengaturan Anda.");
} else if (!write_config(Input::post())) {
    jsonecho(0, "File konfigurasi database tidak dapat ditulis, mohon chmod file /app/config/database.php ke 777");
} else {
    delete();
    jsonecho(1, null);
}