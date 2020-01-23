<?php
session_start();
include ('inc/function.php');
include ('inc/pdo.php');
$fichier = file_get_contents('./files/capture.json');
$json = json_decode($fichier, true);

$datas = array();
foreach ($json as $jisonne) {
    if (isset($jisonne["_source"])) {
        $jisonne = $jisonne['_source'];
        if (isset($jisonne["layers"])) {
            $jisonne = $jisonne['layers'];
        }
        if (isset($jisonne["frame"]["frame.time"])) {
            $date = $jisonne["frame"]["frame.time"];
        }
        if (isset($jisonne["eth"]["eth.src"])) {
            $ethSrc = $jisonne["eth"]["eth.src"];
        }
        if (isset($jisonne["eth"]["eth.dst"])) {
            $ethDst = $jisonne["eth"]["eth.dst"];
        }
        if (isset($jisonne["ip"]["ip.src"])) {
            $ipSrc = $jisonne["ip"]["ip.src"];
        }
        if (isset($jisonne["ip"]["ip.dst"])) {
            $ipDst = $jisonne["ip"]["ip.dst"];
        }
        if (isset($jisonne["udp"]["udp.srcport"])) {
            $portSrc = $jisonne["udp"]["udp.srcport"];
        }
        if (isset($jisonne["udp"]["udp.dstport"])) {
            $portDst = $jisonne["udp"]["udp.dstport"];
        }
        if (isset($jisonne["tcp"])){
            $tcp = $jisonne["tcp"];
        }
        if (isset($jisonne["udp"])){
            $udp = $jisonne["udp"];
        }
//        if (isset($jisonne["tcp"])) {
//            $protocole = "TCP";
//        } else {
//            $protocole = "UDP";
//        }

        $datas[] = array(
            'date' => $date,
            'eth' => array(
                'src' => $ethSrc,
                'dst' => $ethDst
            ),
            'ip' => array(
                'src' => $ipSrc,
                'dst' => $ipDst
            ),
            'port' => array(
                'src' => $portSrc,
                'dst' => $portDst
            ),
//            'protocole' => $protocole

        );
    }
}

include ('inc/header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Tram et yohoho</title>
    <link href="style.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>

<canvas id="myChart" ></canvas>


<table class="wrap">
    <thead>
    <tr>
        <td>Date</td>
        <td>Protocole</td>
        <td>Adresse IP Source</td>
        <td>Adresse IP Destination</td>
        <td>Adresse MAC Source</td>
        <td>Adresse MAC Destination</td>
        <td>Port Source</td>
        <td>Port Destination</td>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach ($datas as $data) {
        echo '<tr>';
        echo '<td>' . $data['date'] . '</td>';
//        echo '<td>' . $data['protocole'] . '</td>';
        echo '<td>' . $data['ip']['src'] . '</td>';
        echo '<td>' . $data['ip']['dst'] . '</td>';
        echo '<td>' . $data['eth']['src'] . '</td>';
        echo '<td>' . $data['eth']['dst'] . '</td>';
        echo '<td>' . $data['port']['src'] . '</td>';
        echo '<td>' . $data['port']['dst'] . '</td>';
        echo '</tr>';
    }
    ?>


    </tbody>
</table>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: ['TCP', 'UDP'],
            datasets: [{
                label: 'TCP', 'UDP',
                backgroundColor: [
                    'rgb(148, 68, 15)',
                    'rgb(0, 0, 0)'

                ],
                borderColor: 'rgb(255, 255, 255)',
                data: [<?=$udp?>, <?=$tcp?>]
            }]
        },
// Configuration options go here
        options: {}
    });
</script>


<script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="asset/js/script.js"></script>
</body>
</html>

<?php include ('inc/footer.php');