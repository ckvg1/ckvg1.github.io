<?php
$conn = mysqli_connect("localhost","root","","plc_database");
$sql = "SELECT * FROM `light` WHERE data > now() - INTERVAL 1 day ";

$l0_1_1 = []; 
$l0_1_2 = [];
$l0_2_1 = [];
$l0_2_2 = [];
$l0_3_1 = [];
$l0_3_2 = [];

$l1_1_1 = []; 
$l1_1_2 = [];
$l1_2_1 = [];
$l1_2_2 = [];
$l1_3_1 = [];
$l1_3_2 = [];
$l1_4_1 = [];
$l1_4_2 = [];
$l1_5_1 = [];
$l1_5_2 = [];
$l1_6_1 = [];
$l1_6_2 = [];
$l1_7_1 = [];
$l1_7_2 = [];

$l2_1_1 = []; 
$l2_1_2 = [];
$l2_2_1 = [];
$l2_2_2 = [];
$l2_3_1 = [];
$l2_3_2 = [];
$l2_4_1 = [];
$l2_4_2 = [];
$l2_5_1 = [];
$l2_5_2 = [];
$l2_6_1 = [];
$l2_6_2 = [];
$l2_7_1 = [];
$l2_7_2 = [];

$l3_1_1 = []; 
$l3_1_2 = [];
$l3_2_1 = [];
$l3_2_2 = [];
$l3_3_1 = [];
$l3_3_2 = [];
$l3_4_1 = [];
$l3_4_2 = [];
$l3_5_1 = [];
$l3_5_2 = [];
$l3_6_1 = [];
$l3_6_2 = [];
$l3_7_1 = [];
$l3_7_2 = [];
$data = [];
if(isset($_GET["od"])) {
    $data_od = $_GET["od"];
}

if(isset($_GET["do"])) {
    $data_do = $_GET["do"];
}

if (isset($data_do) && isset($data_od)) {
    $sql = "SELECT * FROM `light` WHERE `data` BETWEEN '$data_od' AND '$data_do'"; 
}
if(isset($_GET["wszystko"])) {
    $wyswietl_wszystkie_dane = $_GET["wszystko"];
}
if(isset($_GET["pietro"])) {
    $pietro = $_GET["pietro"];
}
$result = mysqli_query($conn, $sql);

while ($row=mysqli_fetch_assoc($result)) {
    $l0_1_1[] = $row['l0_1_1']; 
    $l0_1_2[] = $row['l0_1_2'];
    $l0_2_1[] = $row['l0_2_1'];
    $l0_2_2[] = $row['l0_2_2'];
    $l0_3_1[] = $row['l0_3_1'];
    $l0_3_2[] = $row['l0_3_2'];

    $l1_1_1[] = $row['l1_1_1']; 
    $l1_1_2[] = $row['l1_1_2'];
    $l1_2_1[] = $row['l1_2_1'];
    $l1_2_2[] = $row['l1_2_2'];
    $l1_3_1[] = $row['l1_3_1'];
    $l1_3_2[] = $row['l1_3_2'];
    $l1_4_1[] = $row['l1_4_1'];
    $l1_4_2[] = $row['l1_4_2'];
    $l1_5_1[] = $row['l1_5_1'];
    $l1_5_2[] = $row['l1_5_2'];
    $l1_6_1[] = $row['l1_6_1'];
    $l1_6_2[] = $row['l1_6_2'];
    $l1_7_1[] = $row['l1_7_1'];
    $l1_7_2[] = $row['l1_7_2'];

    $l2_1_1[] = $row['l2_1_1']; 
    $l2_1_2[] = $row['l2_1_2'];
    $l2_2_1[] = $row['l2_2_1'];
    $l2_2_2[] = $row['l2_2_2'];
    $l2_3_1[] = $row['l2_3_1'];
    $l2_3_2[] = $row['l2_3_2'];
    $l2_4_1[] = $row['l2_4_1'];
    $l2_4_2[] = $row['l2_4_2'];
    $l2_5_1[] = $row['l2_5_1'];
    $l2_5_2[] = $row['l2_5_2'];
    $l2_6_1[] = $row['l2_6_1'];
    $l2_6_2[] = $row['l2_6_2'];
    $l2_7_1[] = $row['l2_7_1'];
    $l2_7_2[] = $row['l2_7_2'];

    $l3_1_1[] = $row['l3_1_1']; 
    $l3_1_2[] = $row['l3_1_2'];
    $l3_2_1[] = $row['l3_2_1'];
    $l3_2_2[] = $row['l3_2_2'];
    $l3_3_1[] = $row['l3_3_1'];
    $l3_3_2[] = $row['l3_3_2'];
    $l3_4_1[] = $row['l3_4_1'];
    $l3_4_2[] = $row['l3_4_2'];
    $l3_5_1[] = $row['l3_5_1'];
    $l3_5_2[] = $row['l3_5_2'];
    $l3_6_1[] = $row['l3_6_1'];
    $l3_6_2[] = $row['l3_6_2'];
    $l3_7_1[] = $row['l3_7_1'];
    $l3_7_2[] = $row['l3_7_2'];
    $data[] = $row['data'];
}
if(!isset($_GET['wszystko']) || $wyswietl_wszystkie_dane != 'true') {



    $response = [];
   if($pietro == 0) {
        $response = [
        'l0_1_1'=>policzProcentDlaParyCzujnikow($l0_1_1, $l0_1_2),
        'l0_1_2'=>policzProcentDlaParyCzujnikow($l0_1_1, $l0_1_2),
        'l0_2_1'=>policzProcentDlaParyCzujnikow($l0_2_1, $l0_2_2),
        'l0_2_2'=>policzProcentDlaParyCzujnikow($l0_2_1, $l0_2_2),
        'l0_3_1'=>policzProcentDlaParyCzujnikow($l0_3_1, $l0_3_2),
        'l0_3_2'=>policzProcentDlaParyCzujnikow($l0_3_1, $l0_3_2), 
        ];
    }

    if($pietro == 1) {
        $response = [
        'l1_1_1'=>policzProcentDlaParyCzujnikow($l1_1_1, $l1_1_2),
        'l1_1_2'=>policzProcentDlaParyCzujnikow($l1_1_1, $l1_1_2),
        'l1_2_1'=>policzProcentDlaParyCzujnikow($l1_2_1, $l1_2_2),
        'l1_2_2'=>policzProcentDlaParyCzujnikow($l1_2_1, $l1_2_2),
        'l1_3_1'=>policzProcentDlaParyCzujnikow($l1_3_1, $l1_3_2),
        'l1_3_2'=>policzProcentDlaParyCzujnikow($l1_3_1, $l1_3_2),
        'l1_4_1'=>policzProcentDlaParyCzujnikow($l1_4_1, $l1_4_2),
        'l1_4_2'=>policzProcentDlaParyCzujnikow($l1_4_1, $l1_4_2),
        'l1_5_1'=>policzProcentDlaParyCzujnikow($l1_5_1, $l1_5_2),
        'l1_5_2'=>policzProcentDlaParyCzujnikow($l1_5_1, $l1_5_2),
        'l1_6_1'=>policzProcentDlaParyCzujnikow($l1_6_1, $l1_6_2),   
        'l1_6_2'=>policzProcentDlaParyCzujnikow($l1_6_1, $l1_6_2),
        'l1_7_1'=>policzProcentDlaParyCzujnikow($l1_7_1, $l1_7_2),
        'l1_7_2'=>policzProcentDlaParyCzujnikow($l1_7_1, $l1_7_2)
        ];
    }
    if ( $pietro == 2) {
        $response = [
        'l2_1_1'=>policzProcentDlaParyCzujnikow($l2_1_1, $l2_1_2),
        'l2_1_2'=>policzProcentDlaParyCzujnikow($l2_1_1, $l2_1_2),
        'l2_2_1'=>policzProcentDlaParyCzujnikow($l2_2_1, $l2_2_2),
        'l2_2_2'=>policzProcentDlaParyCzujnikow($l2_2_1, $l2_2_2),
        'l2_3_1'=>policzProcentDlaParyCzujnikow($l2_3_1, $l2_3_2),
        'l2_3_2'=>policzProcentDlaParyCzujnikow($l2_3_1, $l2_3_2),
        'l2_4_1'=>policzProcentDlaParyCzujnikow($l2_4_1, $l2_4_2),
        'l2_4_2'=>policzProcentDlaParyCzujnikow($l2_4_1, $l2_4_2),
        'l2_5_1'=>policzProcentDlaParyCzujnikow($l2_5_1, $l2_5_2),
        'l2_5_2'=>policzProcentDlaParyCzujnikow($l2_5_1, $l2_5_2),
        'l2_6_1'=>policzProcentDlaParyCzujnikow($l2_6_1, $l2_6_2),   
        'l2_6_2'=>policzProcentDlaParyCzujnikow($l2_6_1, $l2_6_2),
        'l2_7_1'=>policzProcentDlaParyCzujnikow($l2_7_1, $l2_7_2),
        'l2_7_2'=>policzProcentDlaParyCzujnikow($l2_7_1, $l2_7_2)
        ];
    }
    if ( $pietro == 3) {
        $response = [
        'l3_1_1'=>policzProcentDlaParyCzujnikow($l3_1_1, $l3_1_2),
        'l3_1_2'=>policzProcentDlaParyCzujnikow($l3_1_1, $l3_1_2),
        'l3_2_1'=>policzProcentDlaParyCzujnikow($l3_2_1, $l3_2_2),
        'l3_2_2'=>policzProcentDlaParyCzujnikow($l3_2_1, $l3_2_2),
        'l3_3_1'=>policzProcentDlaParyCzujnikow($l3_3_1, $l3_3_2),
        'l3_3_2'=>policzProcentDlaParyCzujnikow($l3_3_1, $l3_3_2),
        'l3_4_1'=>policzProcentDlaParyCzujnikow($l3_4_1, $l3_4_2),
        'l3_4_2'=>policzProcentDlaParyCzujnikow($l3_4_1, $l3_4_2),
        'l3_5_1'=>policzProcentDlaParyCzujnikow($l3_5_1, $l3_5_2),
        'l3_5_2'=>policzProcentDlaParyCzujnikow($l3_5_1, $l3_5_2),
        'l3_6_1'=>policzProcentDlaParyCzujnikow($l3_6_1, $l3_6_2),   
        'l3_6_2'=>policzProcentDlaParyCzujnikow($l3_6_1, $l3_6_2),
        'l3_7_1'=>policzProcentDlaParyCzujnikow($l3_7_1, $l3_7_2),
        'l3_7_2'=>policzProcentDlaParyCzujnikow($l3_7_1, $l3_7_2)
        ];
    }
    $response['data'] = $data;
    echo json_encode($response);

} else {
    $response = [];
    if($pietro == 0) {
        $response = [
            'l0_1_1' => $l0_1_1,
            'l0_1_2' => $l0_1_2,
            'l0_2_1' => $l0_2_1,
            'l0_2_2' => $l0_2_2,
            'l0_3_1' => $l0_3_1,
            'l0_3_2' => $l0_3_2,
        ];
    }
    elseif ($pietro == 1) {
        $response = [
            'l1_1_1' => $l1_1_1,
            'l1_1_2' => $l1_1_2,
            'l1_2_1' => $l1_2_1,
            'l1_2_2' => $l1_2_2,
            'l1_3_1' => $l1_3_1,
            'l1_3_2' => $l1_3_2,
            'l1_4_1' => $l1_4_1,
            'l1_4_2' => $l1_4_2,
            'l1_5_1' => $l1_5_1,
            'l1_5_2' => $l1_5_2,
            'l1_6_1' => $l1_6_1,
            'l1_6_2' => $l1_6_2,
            'l1_7_1' => $l1_7_1,
            'l1_7_2' => $l1_7_2
        ];
    } elseif ($pietro == 2) {
        $response = [
            'l2_1_1' => $l2_1_1,
            'l2_1_2' => $l2_1_2,
            'l2_2_1' => $l2_2_1,
            'l2_2_2' => $l2_2_2,
            'l2_3_1' => $l2_3_1,
            'l2_3_2' => $l2_3_2,
            'l2_4_1' => $l2_4_1,
            'l2_4_2' => $l2_4_2,
            'l2_5_1' => $l2_5_1,
            'l2_5_2' => $l2_5_2,
            'l2_6_1' => $l2_6_1,
            'l2_6_2' => $l2_6_2,
            'l2_7_1' => $l2_7_1,
            'l2_7_2' => $l2_7_2
        ];
    } elseif ($pietro == 3) {
        $response = [
            'l3_1_1' => $l3_1_1,
            'l3_1_2' => $l3_1_2,
            'l3_2_1' => $l3_2_1,
            'l3_2_2' => $l3_2_2,
            'l3_3_1' => $l3_3_1,
            'l3_3_2' => $l3_3_2,
            'l3_4_1' => $l3_4_1,
            'l3_4_2' => $l3_4_2,
            'l3_5_1' => $l3_5_1,
            'l3_5_2' => $l3_5_2,
            'l3_6_1' => $l3_6_1,
            'l3_6_2' => $l3_6_2,
            'l3_7_1' => $l3_7_1,
            'l3_7_2' => $l3_7_2
        ];
    }

    $response['data'] = $data;
    echo json_encode($response);
}
mysqli_close($conn);

/*
    Funkcja liczy procent, w ktorym swiatlo było włączone (dla jednego pokoju)
    Przykladowo: Jezeli w ciagu 10 godzin, swiatlo w (tym samym pokoju) czujniku 1 bylo wlaczone przez 10 godzin, 
    a czujnik 2 przez 5 godzin, to funkcja zwroci 75% (15 godzin swiatla włączonego / 20 godzin wszystkich odczytow)
 */
function policzProcentDlaParyCzujnikow($czujnik1, $czujnik2) {
    $aktywnych = array_sum($czujnik1) + array_sum($czujnik2);
    $iloscOdczytow = count($czujnik1) + count($czujnik2);

    return $iloscOdczytow > 0 ? round(($aktywnych / $iloscOdczytow) * 100) : 0;
}

?>