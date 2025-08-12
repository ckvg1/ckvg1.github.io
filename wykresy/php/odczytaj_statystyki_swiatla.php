<?php
$conn = mysqli_connect("localhost", "root", "", "plc_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pietro = isset($_GET["pietro"]) ? intval($_GET["pietro"]) : 1;
$czas = isset($_GET["czas"]) ? intval($_GET["czas"]) : 1;

// Walidacja piętra (0 = parter)
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

// Zapytanie SQL
if ($pietro == 0) {
    $sql = "SELECT 
        SUM(l0_1_1) AS l0_1_1_count,
        SUM(l0_1_2) AS l0_1_2_count,
        SUM(l0_2_1) AS l0_2_1_count,
        SUM(l0_2_2) AS l0_2_2_count,
        SUM(l0_3_1) AS l0_3_1_count,
        SUM(l0_3_2) AS l0_3_2_count
        FROM light
        WHERE data > NOW() - INTERVAL $interval DAY";
} else {
    $sql = "SELECT 
        SUM(l{$pietro}_1_1) AS l{$pietro}_1_1_count,
        SUM(l{$pietro}_1_2) AS l{$pietro}_1_2_count,
        SUM(l{$pietro}_2_1) AS l{$pietro}_2_1_count,
        SUM(l{$pietro}_2_2) AS l{$pietro}_2_2_count,
        SUM(l{$pietro}_3_1) AS l{$pietro}_3_1_count,
        SUM(l{$pietro}_3_2) AS l{$pietro}_3_2_count,
        SUM(l{$pietro}_4_1) AS l{$pietro}_4_1_count,
        SUM(l{$pietro}_4_2) AS l{$pietro}_4_2_count,
        SUM(l{$pietro}_5_1) AS l{$pietro}_5_1_count,
        SUM(l{$pietro}_5_2) AS l{$pietro}_5_2_count,
        SUM(l{$pietro}_6_1) AS l{$pietro}_6_1_count,
        SUM(l{$pietro}_6_2) AS l{$pietro}_6_2_count,
        SUM(l{$pietro}_7_1) AS l{$pietro}_7_1_count,
        SUM(l{$pietro}_7_2) AS l{$pietro}_7_2_count
        FROM light
        WHERE data > NOW() - INTERVAL $interval DAY";
}

// Inicjalizacja tablic
if ($pietro == 0) {
    $l0_1_1 = $l0_1_2 = $l0_2_1 = $l0_2_2 = $l0_3_1 = $l0_3_2 = [];
} elseif ($pietro == 1) {
    $l1_1_1 = $l1_1_2 = $l1_2_1 = $l1_2_2 = $l1_3_1 = $l1_3_2 = $l1_4_1 = $l1_4_2 =
    $l1_5_1 = $l1_5_2 = $l1_6_1 = $l1_6_2 = $l1_7_1 = $l1_7_2 = [];
} elseif ($pietro == 2) {
    $l2_1_1 = $l2_1_2 = $l2_2_1 = $l2_2_2 = $l2_3_1 = $l2_3_2 = $l2_4_1 = $l2_4_2 =
    $l2_5_1 = $l2_5_2 = $l2_6_1 = $l2_6_2 = $l2_7_1 = $l2_7_2 = [];
} elseif ($pietro == 3) {
    $l3_1_1 = $l3_1_2 = $l3_2_1 = $l3_2_2 = $l3_3_1 = $l3_3_2 = $l3_4_1 = $l3_4_2 =
    $l3_5_1 = $l3_5_2 = $l3_6_1 = $l3_6_2 = $l3_7_1 = $l3_7_2 = [];
}

// Wykonanie zapytania
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Błąd zapytania SQL: " . mysqli_error($conn));
}

while($row = mysqli_fetch_assoc($result)) {
    switch($pietro){
        case 0:
            $l0_1_1[] = $row['l0_1_1_count'];
            $l0_1_2[] = $row['l0_1_2_count'];
            $l0_2_1[] = $row['l0_2_1_count'];
            $l0_2_2[] = $row['l0_2_2_count'];
            $l0_3_1[] = $row['l0_3_1_count'];
            $l0_3_2[] = $row['l0_3_2_count'];
            break;
        case 1:
            $l1_1_1[] = $row['l1_1_1_count'];
            $l1_1_2[] = $row['l1_1_2_count'];
            $l1_2_1[] = $row['l1_2_1_count'];
            $l1_2_2[] = $row['l1_2_2_count'];
            $l1_3_1[] = $row['l1_3_1_count'];
            $l1_3_2[] = $row['l1_3_2_count'];
            $l1_4_1[] = $row['l1_4_1_count'];
            $l1_4_2[] = $row['l1_4_2_count'];
            $l1_5_1[] = $row['l1_5_1_count'];
            $l1_5_2[] = $row['l1_5_2_count'];
            $l1_6_1[] = $row['l1_6_1_count'];
            $l1_6_2[] = $row['l1_6_2_count'];
            $l1_7_1[] = $row['l1_7_1_count'];
            $l1_7_2[] = $row['l1_7_2_count'];
            break;
        case 2:
            $l2_1_1[] = $row['l2_1_1_count'];
            $l2_1_2[] = $row['l2_1_2_count'];
            $l2_2_1[] = $row['l2_2_1_count'];
            $l2_2_2[] = $row['l2_2_2_count'];
            $l2_3_1[] = $row['l2_3_1_count'];
            $l2_3_2[] = $row['l2_3_2_count'];
            $l2_4_1[] = $row['l2_4_1_count'];
            $l2_4_2[] = $row['l2_4_2_count'];
            $l2_5_1[] = $row['l2_5_1_count'];
            $l2_5_2[] = $row['l2_5_2_count'];
            $l2_6_1[] = $row['l2_6_1_count'];
            $l2_6_2[] = $row['l2_6_2_count'];
            $l2_7_1[] = $row['l2_7_1_count'];
            $l2_7_2[] = $row['l2_7_2_count'];
            break;
        case 3:
            $l3_1_1[] = $row['l3_1_1_count'];
            $l3_1_2[] = $row['l3_1_2_count'];
            $l3_2_1[] = $row['l3_2_1_count'];
            $l3_2_2[] = $row['l3_2_2_count'];
            $l3_3_1[] = $row['l3_3_1_count'];
            $l3_3_2[] = $row['l3_3_2_count'];
            $l3_4_1[] = $row['l3_4_1_count'];
            $l3_4_2[] = $row['l3_4_2_count'];
            $l3_5_1[] = $row['l3_5_1_count'];
            $l3_5_2[] = $row['l3_5_2_count'];
            $l3_6_1[] = $row['l3_6_1_count'];
            $l3_6_2[] = $row['l3_6_2_count'];
            $l3_7_1[] = $row['l3_7_1_count'];
            $l3_7_2[] = $row['l3_7_2_count'];
            break;
    }
}

// Grupowanie
$swiatla = [
    [$l0_1_1, $l0_1_2, $l0_2_1, $l0_2_2, $l0_3_1, $l0_3_2],
    [$l1_1_1, $l1_1_2, $l1_2_1, $l1_2_2, $l1_3_1, $l1_3_2, $l1_4_1, $l1_4_2, $l1_5_1, $l1_5_2, $l1_6_1, $l1_6_2, $l1_7_1, $l1_7_2],
    [$l2_1_1, $l2_1_2, $l2_2_1, $l2_2_2, $l2_3_1, $l2_3_2, $l2_4_1, $l2_4_2, $l2_5_1, $l2_5_2, $l2_6_1, $l2_6_2, $l2_7_1, $l2_7_2],
    [$l3_1_1, $l3_1_2, $l3_2_1, $l3_2_2, $l3_3_1, $l3_3_2, $l3_4_1, $l3_4_2, $l3_5_1, $l3_5_2, $l3_6_1, $l3_6_2, $l3_7_1, $l3_7_2]
];

// Nazwy czujników z cookies
$pietro0 = isset($_COOKIE["pietro0"]) ? json_decode($_COOKIE["pietro0"], true) : [];
$pietro1 = isset($_COOKIE["pietro1"]) ? json_decode($_COOKIE["pietro1"], true) : [];
$pietro2 = isset($_COOKIE["pietro2"]) ? json_decode($_COOKIE["pietro2"], true) : [];    
$pietro3 = isset($_COOKIE["pietro3"]) ? json_decode($_COOKIE["pietro3"], true) : [];

$nazwy_czujnikow = [
    [$pietro0["l0_1_1"],$pietro0["l0_1_2"], $pietro0["l0_2_1"], $pietro0["l0_2_2"], $pietro0["l0_3_1"], $pietro0["l0_3_2"]],
    [$pietro1["l1_1_1"],$pietro1["l1_1_2"], $pietro1["l1_2_1"], $pietro1["l1_2_2"], $pietro1["l1_3_1"], $pietro1["l1_3_2"], $pietro1["l1_4_1"], $pietro1["l1_4_2"], $pietro1["l1_5_1"], $pietro1["l1_5_2"], $pietro1["l1_6_1"], $pietro1["l1_6_2"], $pietro1["l1_7_1"], $pietro1["l1_7_2"]],
    [$pietro2["l2_1_1"],$pietro2["l2_1_2"], $pietro2["l2_2_1"], $pietro2["l2_2_2"], $pietro2["l2_3_1"], $pietro2["l2_3_2"], $pietro2["l2_4_1"], $pietro2["l2_4_2"], $pietro2["l2_5_1"], $pietro2["l2_5_2"], $pietro2["l2_6_1"], $pietro2["l2_6_2"], $pietro2["l2_7_1"], $pietro2["l2_7_2"]],
    [$pietro3["l3_1_1"],$pietro3["l3_1_2"], $pietro3["l3_2_1"], $pietro3["l3_2_2"], $pietro3["l3_3_1"], $pietro3["l3_3_2"], $pietro3["l3_4_1"], $pietro3["l3_4_2"], $pietro3["l3_5_1"], $pietro3["l3_5_2"], $pietro3["l3_6_1"], $pietro3["l3_6_2"], $pietro3["l3_7_1"], $pietro3["l3_7_2"]]
];

// Funkcje liczące
function obliczNajczesciejWlaczoneSwiatla($swiatla) {
    $licznik = [];
    foreach ($swiatla as $index => $wartosci) {
        $licznik[$index] = array_sum($wartosci);
    }
    return array_search(max($licznik), $licznik);
}
function obliczNajrzadziejWlaczoneSwiatla($swiatla) {
    $licznik = [];
    foreach ($swiatla as $index => $wartosci) {
        $licznik[$index] = array_sum($wartosci);
    }
    return array_search(min($licznik), $licznik);
}
function obliczCzasWlaczoneSwiatlo($swiatla) {
    return array_sum(array_map('array_sum', $swiatla));
}

$najczesciej = obliczNajczesciejWlaczoneSwiatla($swiatla[$pietro]);
$najrzadziej = obliczNajrzadziejWlaczoneSwiatla($swiatla[$pietro]);
$czas_wlaczone = obliczCzasWlaczoneSwiatlo($swiatla[$pietro]);

$response = [
    'najczesciejWlaczoneSwiatlo' => $nazwy_czujnikow[$pietro][$najczesciej] ?? '',
    'najrzadziejWlaczoneSwiatlo' => $nazwy_czujnikow[$pietro][$najrzadziej] ?? '',
    'czasWlaczoneSwiatlo' => round(($czas_wlaczone * 5)/60, 1)
];
echo json_encode($response);

mysqli_close($conn);
?>