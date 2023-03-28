<?php

$data = [
    ["remaja", "tinggi", "single", "punya", "tidak"],
    ["remaja", "tinggi", "single", "tidak", "tidak"],
    ["dewasa", "tinggi", "sigle", "punya", "iya"],
    ["tua", "sedang", "single", "punya", "iya"],
    ["tua", "rendah", "menikah", "punya", "iya"],
    ["tua", "rendah", "menikah", "tidak", "tidak"],
    ["dewasa", "rendah", "menikah", "tidak", "iya"],
    ["remaja", "sedang", "single", "punya", "tidak"],
    ["remaja", "rendah", "menikah", "punya", "iya"],
    ["tua", "sedang", "menikah", "punya", "iya"],
    ["remaja", "sedang", "menikah", "tidak", "iya"],
    ["dewasa", "sedang", "single", "tidak", "iya"],
    ["dewasa", "tinggi", "menikah", "punya", "iya"],
    ["tua", "sedang", "single", "tidak", "tidak"],
];

function banyakDataIyaTidak($data)
{
    $jumlahTotalData = count($data);
    $dataIya = 0;
    $dataTidak = 0;
    $kumpulanData = [
        "jumlahData" => [$jumlahTotalData],
        "jumlahDataIya" => 0,
        "jumlahDataTidak" => 0
    ];
    for ($urutanData = 0; $urutanData < $jumlahTotalData; $urutanData++) {
        if (end($data[$urutanData]) == "iya") {
            $dataIya++;
        } else {
            $dataTidak++;
        }
    }
    $kumpulanData["jumlahDataIya"] = $dataIya;
    $kumpulanData["jumlahDataTidak"] = $dataTidak;
    return $kumpulanData;
}

function menghitungFakta($data, $iyaTidak, $kata)
{
    $hasilData = 0;
    $jumlahKolom = count($data[0]) - 1;
    $jumlahBaris = count($data);
    for ($kolom = 0; $kolom < $jumlahKolom; $kolom++) {
        for ($baris = 0; $baris < $jumlahBaris; $baris++) {
            if ($data[$baris][$kolom] == $kata &&  end($data[$baris]) == $iyaTidak) {
                $hasilData++;
            }
        }
    }
    if($hasilData != 0){
        return $hasilData;
    }
    
};

function menghitungHasilFakta($dataFakta, $dataIyaTidak)
{
    $hasilDataIyaTidak = [
        'iya' => [1, 1],
        'tidak' => [1, 1]
    ];
    $hasilAkhir = [0, 0];
    for ($hitungTotalFakta = 0; $hitungTotalFakta < count($dataFakta); $hitungTotalFakta++) {
        for ($pembilang = 0; $pembilang < count($dataFakta[$hitungTotalFakta]); $pembilang++) {
            if ($hitungTotalFakta == 0) {
                $hasilDataIyaTidak['iya'][0] = $hasilDataIyaTidak['iya'][0] * $dataFakta[$hitungTotalFakta][$pembilang];
                $hasilDataIyaTidak['iya'][1] = $hasilDataIyaTidak['iya'][1] * $dataIyaTidak['jumlahDataIya'];
            } else {
                $hasilDataIyaTidak['tidak'][0] = $hasilDataIyaTidak['tidak'][0] * $dataFakta[$hitungTotalFakta][$pembilang];
                $hasilDataIyaTidak['tidak'][1] = $hasilDataIyaTidak['tidak'][1] * $dataIyaTidak['jumlahDataTidak'];
            }
        }
    }
    $hasilDataIyaTidak['iya'][0] = $hasilDataIyaTidak['iya'][0] * $dataIyaTidak['jumlahDataIya'];
    $hasilDataIyaTidak['iya'][1] = $hasilDataIyaTidak['iya'][1] * $dataIyaTidak['jumlahData'][0];
    $hasilDataIyaTidak['tidak'][0] = $hasilDataIyaTidak['tidak'][0] * $dataIyaTidak['jumlahDataTidak'];
    $hasilDataIyaTidak['tidak'][1] = $hasilDataIyaTidak['tidak'][1] * $dataIyaTidak['jumlahData'][0];

    $hasilAkhir[0] = round($hasilDataIyaTidak['iya'][0] / $hasilDataIyaTidak['iya'][1] * 100, 2);
    $hasilAkhir[1] = round($hasilDataIyaTidak['tidak'][0] / $hasilDataIyaTidak['tidak'][1] * 100, 2);
    return $hasilAkhir;
};

function jawaban($hasilAkhir)
{
    if ($hasilAkhir[0] > $hasilAkhir[1]) {
        return "Kemungkinan iya";
    }
    return "kemungkinan tidak";
}

// Menghitung Fakta
$cekKata = "iya";
$dataFaktaIya = [];
$dataFaktaTidak = [];
$dataFaktaIyaTidak = [
    [], []
];
$dataHasilHitung = 0;
$pertanyaan = explode(" ", strtolower($_GET['pertanyaan']));
for ($iyaTidak = 0; $iyaTidak < 2; $iyaTidak++) {
    for ($kata = 0; $kata < count($pertanyaan); $kata++) {
        $dataHasilHitung = menghitungFakta($data, $cekKata, $pertanyaan[$kata]);
        if ($cekKata == 'iya' && $dataHasilHitung != null) {
            array_push($dataFaktaIya, $dataHasilHitung);
            $dataFaktaIyaTidak[$iyaTidak] = $dataFaktaIya;
        } else if($cekKata == 'tidak' && $dataHasilHitung != null){
            array_push($dataFaktaTidak, $dataHasilHitung);
            $dataFaktaIyaTidak[$iyaTidak] = $dataFaktaTidak;
        }
    }
    $cekKata = 'tidak';
}
// Akhir Menghitung Fakta

var_dump(banyakDataIyaTidak($data));
var_dump($dataFaktaIyaTidak);
var_dump(menghitungHasilFakta($dataFaktaIyaTidak, banyakDataIyaTidak($data)));

$jawaban = jawaban(
    menghitungHasilFakta(
        $dataFaktaIyaTidak,
        banyakDataIyaTidak($data)
    )
);
