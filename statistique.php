<?php
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
        if (isset($jisonne["tcp"])) {
            $protocole = "TCP";
        } else {
            $protocole = "UDP";
        }

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
            'protocole' => $protocole


        );

        echo '<tr>';
//        echo '<td> ' . $date . '</td>' . '<td> ' . $protocole . '</td>' . '<td> ' . $ipSrc . '</td>' . '<td> ' . $ipDst . '</td>' . '<td>' . $ethSrc . '</td>' . '<td>' . $ethDst . '</td>' . '<td>' . $portSrc . '</td>' . '<td>' . $portDst . '</td>' . "\n";
        echo '</tr>';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Tram et yohoho</title>
    <link href="style.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>

<!--<canvas id="myChart" width="400" height="400"></canvas>-->

<table class="table">
    <thead>
    <tr>
        <td>Date</td>
        <td>Adresse IP Source</td>
        <td>Adresse IP Destination</td>
        <td>Adresse MAC Source</td>
        <td>Adresse MAC Destination</td>
        <td>Protocole</td>
        <td>Port Source</td>
        <td>Port Destination</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        foreach ($datas as $dataze){

            echo '<td>'.$dataze.'</td>';
        }

        ?>
    </tr>
    </tbody>
</table>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="asset/js/script.js"></script>
</body>
</html>