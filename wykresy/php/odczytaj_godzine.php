<?php
// Skrypt do odczytania godziny, o której jest najwięcej włączonych świateł

$conn = mysqli_connect("localhost", "root", "", "plc_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pietro = isset($_GET["pietro"]) ? intval($_GET["pietro"]) : 1;
$czas   = isset($_GET["czas"]) ? intval($_GET["czas"]) : 1;

// Sprawdzenie, czy piętro jest poprawne (0 = parter)
if ($pietro < 0 || $pietro > 3) {
    die("Nieprawidłowe piętro");
}

// Sprawdzenie, czy czas jest poprawny
if ($czas < 1 || $czas > 3) {
    die("Nieprawidłowy czas");
}

// Ustawienie interwału
switch ($czas) {
    case 1: $interval = "1"; break;  // 24h
    case 2: $interval = "7"; break;  // 7 dni
    case 3: $interval = "30"; break; // 30 dni
}

// Przygotowanie zapytania SQL
if ($pietro == 0) {
    // Parter — tylko 3 światła po 2 czujniki
    $sql = "SELECT 
        SUM(
            l0_1_1 + l0_1_2 + l0_2_1 + l0_2_2 + l0_3_1 + l0_3_2
        ) AS ilosc_wlaczen,
        HOUR(data) AS godzina
    FROM `light`
    WHERE data > NOW() - INTERVAL $interval DAY
    GROUP BY godzina
    ORDER BY ilosc_wlaczen DESC LIMIT 1;";
} else {
    // Piętra 1–3 — 7 świateł po 2 czujniki
    $sql = "SELECT 
        SUM(
            l{$pietro}_1_1 + l{$pietro}_1_2 +
            l{$pietro}_2_1 + l{$pietro}_2_2 +
            l{$pietro}_3_1 + l{$pietro}_3_2 +
            l{$pietro}_4_1 + l{$pietro}_4_2 +
            l{$pietro}_5_1 + l{$pietro}_5_2 +
            l{$pietro}_6_1 + l{$pietro}_6_2 +
            l{$pietro}_7_1 + l{$pietro}_7_2
        ) AS ilosc_wlaczen,
        HOUR(data) AS godzina
    FROM `light`
    WHERE data > NOW() - INTERVAL $interval DAY
    GROUP BY godzina
    ORDER BY ilosc_wlaczen DESC LIMIT 1;";
}

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Błąd zapytania SQL: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $response = [
        'godzina'        => $row['godzina'],
        'ilosc_wlaczen'  => $row['ilosc_wlaczen'],
    ];
} else {
    $response = [
        'godzina'        => "brak danych",
        'ilosc_wlaczen'  => "brak danych"
    ];
}

echo json_encode($response);
mysqli_close($conn);
?>