<?php

echo "Mencoba koneksi ke https://repo.packagist.org/packages.json\n\n";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://repo.packagist.org/packages.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1); // Memberikan output detail
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); // Memaksa IPv4
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Timeout koneksi 10 detik

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "\n\n--- KESALAHAN ---\n";
    echo 'cURL Error (' . curl_errno($ch) . '): ' . curl_error($ch) . "\n";
} else {
    echo "\n\n--- KONEKSI BERHASIL ---\n";
    echo "Berhasil mendapatkan respons dari server.\n";
    // print_r(json_decode($response)); // Baris ini dimatikan agar tidak terlalu ramai
}

curl_close($ch);
