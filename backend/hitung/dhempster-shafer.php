<?php

$gejala = [
    "Penglihatan mata kabur atau tidak fokus",
    "Adanya garis gelombang dalam penglihatan",
    "Tidak bisa mengenal warna dengan baik",
    "Membutuhkan cahaya yang sangat terang untuk membaca",
    "Sulit untuk mengenali wajah",
    "Tidak bisa melihat warna cerah",
    "Mengalami halusinasi dalam melihat warna",
    "Sulit melihat pada malam hari",
    "Mata menjadi sensitif terhadap cahaya /silau",
    "Ada lingkaran putih dalam sumber cahaya seperti lampu",
    "Penglihatan mata menjadi ganda",
    "Nyeri pada bagian belakang mata",
    "Gangguan penglihatan",
    "Melihat bayangan lampu berkedip",
    "Penglihatan menjadi tidak jelas pada bagian tepi",
    "Sakit mata",
    "Mual dan muntah pada saat sakit mata",
    "Tidak bisa melihat saat redup atau tidak ada cahaya",
    "Mata merah",
    "Mata menjadi lebih menonjol",
    "Ada tekanan kuat pada bagian dalam mata",
    "Mata seperti menghasilkan pasir",
    "Kelopak mata seperti tertarik",
    "Mata kehilangan kemampuan untuk melihat",
    "Nyeri pada mata",
    "Nyeri saat menggerakkan kelopak mata",
    "Rasa takut abnormal pada cahaya (fotofobia)",
    "Mata berair",
    "Kecenderungan untuk memegang bacaan lebih jauh agar bisa melihat huruf lebih jelas",
    "Menyipitkan mata",
    "Penglihatan kabur ketika membaca dengan jarak normal",
    "Sakit kepala atau mata menegang pada saat membaca",
    "Kesulitan membaca cetakan huruf berukuran kecil",
    "Mata seperti melihat bintik-bintik kecil pada pandangan",
    "Mata seperti tertutup oleh rambut atau beberapa benang kecil meskipun sebenarnya tidak",
    "Mata memberikan respon berkedip dalam waktu cepat saat melihat cahaya",
    "Mengalami penglihatan seperti ada bintik-bintik hitam beterbangan"
];

$penyakit = [
    "Degenerasi Makula",
    "Katarak",
    "Neuristik Optik",
    "Gllukoma Sudut Terbuka",
    "Glukoma Sudut Tertutup",
    "Graves",
    "Keratitis",
    "Presbiopi",
    "Ablasi Retina",
    "Iridosiklitis Akut"
];

$relasi = [
    [0, 1, 2, 3, 4, 5, 6],
    [0, 7, 8, 9, 10],
    [11, 12, 2, 13],
    [14, 11],
    [15, 16, 17, 9, 18],
    [19, 20, 21, 22, 23, 18, 8, 10],
    [18, 23, 24, 8, 25, 26, 27],
    [28, 29, 30, 31, 32],
    [33, 34, 35],
    [18, 36, 15, 26, 23, 27]
];

// CETAK RELASI
for ($i = 0; $i < count($penyakit); $i++) {
    echo $penyakit[$i] . ": ";
    for ($j = 0; $j < count($relasi[$i]); $j++) {
        $indexGejala = $relasi[$i][$j];
        echo $gejala[$indexGejala] . ", ";
    }
    echo "\n";
}


// NILAI GEJALA
$nilaiGejala = [];
for ($i = 0; $i < count($relasi); $i++) {
    $nilaiGejala[$i] = [];
    $value = 1.0 / count($relasi[$i]);
    for ($j = 0; $j < count($relasi[$i]); $j++) {
        $nilaiGejala[$i][$j] = $value;
    }
}

// CETAK NILAI GEJALA
for ($i = 0; $i < count($relasi); $i++) {
    echo "=====================================================\n";
    echo $penyakit[$i] . ": \n";
    for ($j = 0; $j < count($relasi[$i]); $j++) {
        $indexGejala = $relasi[$i][$j];
        echo $gejala[$indexGejala] . "(" . $nilaiGejala[$i][$j] . "), ";
    }
    echo "\n";
}

// FUNGSI DENSITAS
$simbolFungsiDensitas = array_fill(0, count($gejala), []);

for ($i = 0; $i < count($penyakit); $i++) {
    for ($j = 0; $j < count($relasi[$i]); $j++) {
        $indexGejala = $relasi[$i][$j];
        $simbolFungsiDensitas[$indexGejala][] = $i;
    }
}

// Hitung Belief and Plausality
$belief = array_fill(0, count($gejala), 0);
$plausibility = array_fill(0, count($gejala), 0);

for ($i = 0; $i < count($belief); $i++) {
    $b = 0;
    $n = count($simbolFungsiDensitas[$i]);
    for ($j = 0; $j < $n; $j++) {
        $indexPenyakit = $simbolFungsiDensitas[$i][$j];
        $indexGejala = array_search($i, $relasi[$indexPenyakit]);
        $b += $nilaiGejala[$indexPenyakit][$indexGejala];
    }

    $belief[$i] = $b / $n;
    $plausibility[$i] = 1 - $belief[$i];
}

//CETAK SIMBOL FUNGSI DENSITAS
for ($i = 0; $i < count($simbolFungsiDensitas); $i++) {
    echo "G" . ($i + 1) . "{";
    for ($j = 0; $j < count($simbolFungsiDensitas[$i]); $j++) {
        if ($j > 0) {
            echo ", ";
        }
        echo "P" . ($simbolFungsiDensitas[$i][$j] + 1);
    }
    echo "}\tbelief: " . $belief[$i] . "\tplausibility: " . $plausibility[$i] . "\n";
}

// INPUT GEJALA PENYAKIT YANG AKAN DIDETEKSI
$gejalaTest = [19, 20, 21, 22, 23, 18, 8, 10];

if ($gejalaTest) {
    $indexGejala1 = $gejalaTest[0];
    $m1Symbols = [$simbolFungsiDensitas[$indexGejala1], [-1]];
    $m1Values = [$plausibility[$indexGejala1], $belief[$indexGejala1]];

    if (count($gejalaTest) > 1) {
        for ($i = 1; $i < count($gejalaTest); $i++) {
            $indexGejala2 = $gejalaTest[$i];
            $m2Symbols = [$simbolFungsiDensitas[$indexGejala2], [-1]];
            $m2Values = [$plausibility[$indexGejala2], $belief[$indexGejala2]];

            $matrixSymbols = array_fill(0, count($m1Values), array_fill(0, count($m2Values), null));
            $matrixValues = array_fill(0, count($m1Values), array_fill(0, count($m2Values), 0));
            $sumNULL = 0;

            for ($j = 0; $j < count($matrixValues); $j++) {
                for ($k = 0; $k < count($matrixValues[$j]); $k++) {
                    $matrixValues[$j][$k] = $m1Values[$j] * $m2Values[$k];
                    $symbol1 = $m1Symbols[$j];
                    $symbol2 = $m2Symbols[$k];

                    if ($j < count($matrixValues) - 1) {
                        if ($k < count($matrixValues[$j]) - 1) {
                            $isSubset = true;
                            foreach ($symbol1 as $s1) {
                                if (!in_array($s1, $symbol2)) {
                                    $isSubset = false;
                                    break;
                                }
                            }
                            $matrixSymbols[$j][$k] = $isSubset ? $symbol1 : null;
                        } else {
                            $matrixSymbols[$j][$k] = $symbol1;
                        }
                    } else {
                        $matrixSymbols[$j][$k] = ($k < count($matrixValues[$j]) - 1) ? $symbol2 : [-1];
                    }

                    if ($matrixSymbols[$j][$k] === null) {
                        $sumNULL += $matrixValues[$j][$k];
                    }
                }
            }

            $newSymbols = array_fill(0, count($m1Symbols) + 1, []);
            $newValues = array_fill(0, count($m1Values) + 1, 0);
            $denominator = 1 - $sumNULL;

            for ($j = 0; $j < count($m1Symbols) - 1; $j++) {
                $newSymbols[$j] = $m1Symbols[$j];
                $numerator = $matrixValues[$j][1];
                $newValues[$j] = $numerator / $denominator;
            }

            $newSymbols[count($m1Symbols) - 1] = $m2Symbols[0];
            $numerator = $matrixValues[count($matrixValues) - 1][0];
            $newValues[count($m1Symbols) - 1] = $numerator / $denominator;

            $newSymbols[count($newSymbols) - 1] = [-1];
            $numerator = $matrixValues[count($matrixValues) - 1][count($matrixValues[0]) - 1];
            $newValues[count($newValues) - 1] = $numerator / $denominator;

            $m1Symbols = $newSymbols;
            $m1Values = $newValues;
        }

        $penyakitTerdeteksi = [];
        for ($i = 0; $i < count($m1Symbols); $i++) {
            foreach ($m1Symbols[$i] as $symbol) {
                if ($symbol !== -1 && !in_array($symbol, $penyakitTerdeteksi)) {
                    $penyakitTerdeteksi[] = $symbol;
                }
            }
        }

        $iMAX = -1;
        $MAX_DENSITY = PHP_FLOAT_MIN;
        $densitasPenyakit = array_fill(0, count($penyakitTerdeteksi), 0);
        for ($i = 0; $i < count($penyakitTerdeteksi); $i++) {
            $value = 0;
            $p = $penyakitTerdeteksi[$i];
            for ($j = 0; $j < count($m1Symbols); $j++) {
                if (in_array($p, $m1Symbols[$j])) {
                    $value += $m1Values[$j];
                }
            }
            $densitasPenyakit[$i] = $value;
            if ($densitasPenyakit[$i] > $MAX_DENSITY) {
                $MAX_DENSITY = $densitasPenyakit[$i];
                $iMAX = $i;
            }
        }

        echo "---------------------------------------------\n";
        for ($i = 0; $i < count($penyakitTerdeteksi); $i++) {
            $value = $densitasPenyakit[$i];
            echo "m{P" . ($penyakitTerdeteksi[$i] + 1) . "} = " . $value . "\n";
        }

        echo "---------------------------------------------\n";
        $indexPenyakitDiagnosa = $penyakitTerdeteksi[$iMAX];
        $penyakitDiagnosa = $penyakit[$indexPenyakitDiagnosa];
        echo "Hasil Diagnosa: " . $penyakitDiagnosa . "\n";
    }
}

?>
