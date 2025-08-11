<?php
    ini_set('display_errors', 1); // Włącz wyświetlanie błędów
ini_set('display_startup_errors', 1); // Błędy przy starcie
error_reporting(E_ALL); // Pokazuj wszystkie typy błędów

    $conn = mysqli_connect("localhost", "root", "", "plc_database");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Parametry GET
    $pietro = isset($_GET["pietro"]) ? intval($_GET["pietro"]) : 2;
    $czas = isset($_GET["czas"]) ? intval($_GET["czas"]) : 1;

    // Walidacja pietra (0 = parter, 1-3 = piętra)
    if ($pietro < 0 || $pietro > 3) {
        die("Nieprawidłowe piętro");
    }

    // Walidacja czasu
    if ($czas < 1 || $czas > 3) {
        die("Nieprawidłowy czas");
    }

    // Ustawienie interwału
    switch($czas) {
        case 1: $interval = "1"; break;
        case 2: $interval = "7"; break;
        case 3: $interval = "30"; break;
    }

    // SQL w zależności od pietra
    if ($pietro == 0) {
        $sql_temp = "SELECT t0_1, t0_2, t0_3, t_zewn, czas_dodania 
                     FROM temperatura 
                     WHERE czas_dodania > NOW() - INTERVAL $interval DAY 
                     ORDER BY czas_dodania DESC";
    } else {
        $sql_temp = "SELECT t{$pietro}_1, t{$pietro}_2, t{$pietro}_3, t{$pietro}_4, t{$pietro}_5, t{$pietro}_6, t{$pietro}_7, t_zewn, czas_dodania 
                     FROM temperatura 
                     WHERE czas_dodania > NOW() - INTERVAL $interval DAY 
                     ORDER BY czas_dodania DESC";
    }

    // Inicjalizacja tablic
    $czas_arr = [];
    $t0_1 = $t0_2 = $t0_3 = [];
    $t1_1 = $t1_2 = $t1_3 = $t1_4 = $t1_5 = $t1_6 = $t1_7 = [];
    $t2_1 = $t2_2 = $t2_3 = $t2_4 = $t2_5 = $t2_6 = $t2_7 = [];
    $t3_1 = $t3_2 = $t3_3 = $t3_4 = $t3_5 = $t3_6 = $t3_7 = [];
    $temp_zewn = [];

    // Pobieranie danych
    $result = mysqli_query($conn, $sql_temp);
    if (!$result || mysqli_num_rows($result) === 0) {
        echo json_encode([
            'najmniejszaTemperatura' => "brak danych",
            'najwyzszaTemperatura' => "brak danych",
            'sredniaTemperatura' => "brak danych",
            'najnizszaTemperaturaCzujnik' => "",
            'najwyzszaTemperaturaCzujnik' => "",
            'sredniaZewnetrzna' => "brak danych"
        ]);
        mysqli_close($conn);
        exit;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $czas_arr[] = $row['czas_dodania'];

        switch($pietro) {
            case 0:
                if (!is_null($row['t0_1'])) $t0_1[] = round($row['t0_1'], 1);
                if (!is_null($row['t0_2'])) $t0_2[] = round($row['t0_2'], 1);
                if (!is_null($row['t0_3'])) $t0_3[] = round($row['t0_3'], 1);
                break;
            case 1:
                if (!is_null($row['t1_1'])) $t1_1[] = round($row['t1_1'], 1);
                if (!is_null($row['t1_2'])) $t1_2[] = round($row['t1_2'], 1);
                if (!is_null($row['t1_3'])) $t1_3[] = round($row['t1_3'], 1);
                if (!is_null($row['t1_4'])) $t1_4[] = round($row['t1_4'], 1);
                if (!is_null($row['t1_5'])) $t1_5[] = round($row['t1_5'], 1);
                if (!is_null($row['t1_6'])) $t1_6[] = round($row['t1_6'], 1);
                if (!is_null($row['t1_7'])) $t1_7[] = round($row['t1_7'], 1);
                break;
            case 2:
                if (!is_null($row['t2_1'])) $t2_1[] = round($row['t2_1'], 1);
                if (!is_null($row['t2_2'])) $t2_2[] = round($row['t2_2'], 1);
                if (!is_null($row['t2_3'])) $t2_3[] = round($row['t2_3'], 1);
                if (!is_null($row['t2_4'])) $t2_4[] = round($row['t2_4'], 1);
                if (!is_null($row['t2_5'])) $t2_5[] = round($row['t2_5'], 1);
                if (!is_null($row['t2_6'])) $t2_6[] = round($row['t2_6'], 1);
                if (!is_null($row['t2_7'])) $t2_7[] = round($row['t2_7'], 1);
                break;
            case 3:
                if (!is_null($row['t3_1'])) $t3_1[] = round($row['t3_1'], 1);
                if (!is_null($row['t3_2'])) $t3_2[] = round($row['t3_2'], 1);
                if (!is_null($row['t3_3'])) $t3_3[] = round($row['t3_3'], 1);
                if (!is_null($row['t3_4'])) $t3_4[] = round($row['t3_4'], 1);
                if (!is_null($row['t3_5'])) $t3_5[] = round($row['t3_5'], 1);
                if (!is_null($row['t3_6'])) $t3_6[] = round($row['t3_6'], 1);
                if (!is_null($row['t3_7'])) $t3_7[] = round($row['t3_7'], 1);
                break;
        }

        if (!is_null($row['t_zewn'])) $temp_zewn[] = round($row['t_zewn'], 1);
    }

    // Grupowanie
    $pomieszczenia = [
        [$t0_1, $t0_2, $t0_3], // parter
        [$t1_1, $t1_2, $t1_3, $t1_4, $t1_5, $t1_6, $t1_7],
        [$t2_1, $t2_2, $t2_3, $t2_4, $t2_5, $t2_6, $t2_7],
        [$t3_1, $t3_2, $t3_3, $t3_4, $t3_5, $t3_6, $t3_7]
    ];

    // Cookies nazwy
    $pietro0 = isset($_COOKIE["pietro0"]) ? json_decode($_COOKIE["pietro0"], true) : [];
    $pietro1 = isset($_COOKIE["pietro1"]) ? json_decode($_COOKIE["pietro1"], true) : [];
    $pietro2 = isset($_COOKIE["pietro2"]) ? json_decode($_COOKIE["pietro2"], true) : [];
    $pietro3 = isset($_COOKIE["pietro3"]) ? json_decode($_COOKIE["pietro3"], true) : [];

    $nazwy_czujnikow = [
        [$pietro0["t0_1"], $pietro0["t0_2"], $pietro0["t0_3"]],
        [$pietro1["t1_1"], $pietro1["t1_2"], $pietro1["t1_3"], $pietro1["t1_4"], $pietro1["t1_5"], $pietro1["t1_6"], $pietro1["t1_7"]],
        [$pietro2["t2_1"], $pietro2["t2_2"], $pietro2["t2_3"], $pietro2["t2_4"], $pietro2["t2_5"], $pietro2["t2_6"], $pietro2["t2_7"]],
        [$pietro3["t3_1"], $pietro3["t3_2"], $pietro3["t3_3"], $pietro3["t3_4"], $pietro3["t3_5"], $pietro3["t3_6"], $pietro3["t3_7"]]
    ];
        

    // Funkcje
    function znajdzNajmniejszaTemperature($tablica) {
        $najmniejsza = null;
        $czujnik = null;
        for ($i = 0; $i < count($tablica); $i++) {
            if (!empty($tablica[$i])) {
                $filtered = array_filter($tablica[$i], fn($val) => !is_null($val) && $val != 0 && $val != 99 && $val > 0 && $val <70);
                if (!empty($filtered)) {
                    $min_local = min($filtered);
                } else {
                    continue;
                }
                if ($najmniejsza === null || $min_local < $najmniejsza)   {
                    $najmniejsza = $min_local;
                    $czujnik = $i;
                }
            }
        }
        return $najmniejsza !== null ? ['temp' => $najmniejsza, 'czujnik' => $czujnik] : ['temp' => null, 'czujnik' => null];
    }
    function znajdzNajwyzszaTemperature($tablica) {
        $najwyzsza = null;
        $czujnik = null;
        for ($i = 0; $i < count($tablica); $i++) {
            if (!empty($tablica[$i])) {
                $filtered = array_filter($tablica[$i], fn($val) => !is_null($val) && $val != 0 && $val != 99 && $val > 0 && $val <70);
                if (!empty($filtered)) {
                    $max_local = max($filtered);
                } else {
                    continue;
                }
                if ($najwyzsza === null || $max_local > $najwyzsza) {
                    $najwyzsza = $max_local;
                    $czujnik = $i;
                }
            }
        }
        return $najwyzsza !== null ? ['temp' => $najwyzsza, 'czujnik' => $czujnik] : ['temp' => null, 'czujnik' => null];
    }
    function znajdzSredniaTemperature($tablica) {
        $suma = 0;
        $licznik = 0;
        for($i = 0; $i < count($tablica); $i++) {
            if (!empty($tablica[$i])) {
                $filtered = array_filter($tablica[$i], fn($val) => !is_null($val) && $val != 0 && $val != 99 && $val > 0 && $val <70);
                $suma += array_sum($filtered);
                $licznik += count($filtered);
            }
        }
        return $licznik > 0 ? round($suma / $licznik, 2) : null;
    }
    
    function obliczSredniaTemperatureZewnetrzna($tablica){
        $suma = 0;
        $licznik = 0;
        for($i = 0; $i < count($tablica); $i++){
            $suma += $tablica[$i];
            $licznik++;
        }
        return $licznik > 0 ? round($suma / $licznik, 2) : null;
    }
    function sprawdzBledneDane($tablica, $nazwy) {
        $bledne = [];
        for ($i = 0; $i < count($tablica); $i++) {
            foreach ($tablica[$i] as $val) {
                if (is_null($val) || $val == 0 || $val == 99 || $val < 0 || $val > 70) {
                    $bledne[] = $nazwy[$i]; //wpisanie nazw wszyztkich czujnikow z blednymi danymi
                }
            }
        }
        return array_values(array_unique($bledne)); //usuniecie duplikatow z tablicy
    }
    
    // Obliczenia
    $najnizsza = znajdzNajmniejszaTemperature($pomieszczenia[$pietro]);
    $najwyzsza = znajdzNajwyzszaTemperature($pomieszczenia[$pietro]);
    $srednia = znajdzSredniaTemperature($pomieszczenia[$pietro]);
    $sredniaTempZewn = obliczSredniaTemperatureZewnetrzna($temp_zewn);

    $bledneCzujniki = sprawdzBledneDane($pomieszczenia[$pietro], $nazwy_czujnikow[$pietro-1]);

    // Odpowiedź JSON
    $response = [
        'najmniejszaTemperatura' => $najnizsza['temp'] ?? "Brak danych",
        'najwyzszaTemperatura' => $najwyzsza['temp'] ?? "Brak danych",
        'sredniaTemperatura' => $srednia ?? "Brak danych",
        'najnizszaTemperaturaCzujnik' => $nazwy_czujnikow[$pietro][$najnizsza['czujnik']] ?? "",
        'najwyzszaTemperaturaCzujnik' => $nazwy_czujnikow[$pietro][$najwyzsza['czujnik']] ?? "",
        'sredniaZewnetrzna' => $sredniaTempZewn ?? "Brak danych",
        'bledneDane' => !empty($bledneCzujniki),
        'czujnikBledneDane' => $bledneCzujniki
    ];

    echo json_encode($response);

    mysqli_close($conn);
?>