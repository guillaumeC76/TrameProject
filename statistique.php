<?php
session_start();
include('inc/function.php');
include('inc/pdo.php');
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
            $tcp = $jisonne["tcp"];
        }
        if (isset($jisonne["udp"])) {
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
            )
//            'protocole' => $protocole

        );
    }
}

include('inc/header.php'); ?>


    <div id="chartContainer1">
        <canvas id="myChart"></canvas>
    </div>
    <div id="chartContainer2">
        <canvas id="chartMac"></canvas>
    </div>

    <h3 class="headline">Toutes les statistiques</h3>

    <div class="wrap-tableau">
        <div class="container">
            <div class="wrap-tableau2">
                <div class="tableau">
                    <table id="tableau">
                        <thead>
                        <tr class="headtableau">
                            <th>Date et heure</th>
                            <th>Adresse IP Source</th>
                            <th>Adresse IP Destination</th>
                            <th>Adresse MAC Source</th>
                            <th>Adresse MAC Destination</th>
                            <th>Protocole</th>
                            <th>Port Source</th>
                            <th>Port Destination</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $tcp = 0;
                        $udp = 0;
                        $apple = 0;
                        $wd = 0;
                        $autres = 0;
                        $azurewave = 0;
                        $ubiquiti = 0;
                        $count = count($json);
                        for ($i = 0; $i < $count; $i++) {
                            echo '<tr>';
                            $row = $json[$i]['_source']['layers'];
                            if (isset($row['frame'])) {
                                echo '<td>' . $json[$i]['_source']['layers']['frame']['frame.time'] . '</td>';
                            } else {
                                echo '<td></td>';
                            }
                            if (isset($row['ip'])) {
                                echo '<td>' . $json[$i]['_source']['layers']['ip']['ip.src'] . '</td>';
                                echo '<td>' . $json[$i]['_source']['layers']['ip']['ip.dst'] . '</td>';
                            } else {
                                echo '<td></td>';
                                echo '<td></td>';
                            }
                            if (isset($row['eth'])) {
                                echo '<td>' . $json[$i]['_source']['layers']['eth']['eth.src'] . '</td>';
                                echo '<td>' . $json[$i]['_source']['layers']['eth']['eth.dst'] . '</td>';
                                if ($json[$i]['_source']['layers']['eth']['eth.src_tree']['eth.src.oui_resolved'] == 'Apple, Inc.') {
                                    $apple++;
                                } elseif ($json[$i]['_source']['layers']['eth']['eth.src_tree']['eth.src.oui_resolved'] == 'Intel Corporate') {
                                    $wd++;
                                } elseif ($json[$i]['_source']['layers']['eth']['eth.src_tree']['eth.src.oui_resolved'] == 'AzureWave Technology Inc.') {
                                    $azurewave++;
                                } elseif ($json[$i]['_source']['layers']['eth']['eth.src_tree']['eth.src.oui_resolved'] == 'Ubiquiti Networks Inc.') {
                                    $ubiquiti++;
                                } else {
                                    $autres++;
                                }
                            } else {
                                echo '<td></td>';
                                echo '<td></td>';
                            }
                            if (isset($row['udp'])) {
                                echo '<td>UDP</td>';
                                echo '<td>' . $json[$i]['_source']['layers']['udp']['udp.srcport'] . '</td>';
                                echo '<td>' . $json[$i]['_source']['layers']['udp']['udp.dstport'] . '</td>';
                                $udp++;
                            } else if (isset($row['tcp'])) {
                                echo '<td>TCP</td>';
                                echo '<td>' . $json[$i]['_source']['layers']['tcp']['tcp.srcport'] . '</td>';
                                echo '<td>' . $json[$i]['_source']['layers']['tcp']['tcp.dstport'] . '</td>';
                                $tcp++;
                            } else {
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                            }
                            echo '</tr>';

                        }


                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>


        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['TCP', 'UDP'],
                datasets: [{
                    label: 'Types de connexions',
                    data: [<?=$udp?>, <?=$tcp?>],
                    backgroundColor: [
                        'rgba(255, 165, 0, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 165, 0, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Type de protocole',
                }
            }
        });

        var ctx2 = document.getElementById('chartMac').getContext('2d');
        var chartMac = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Apple', 'Intel', 'Azurewave', 'Ubiquiti', 'Autres'],
                datasets: [{
                    label: 'Types de connexions',
                    data: [<?=$apple?>, <?=$wd?>, <?= $azurewave ?>, <?=$ubiquiti?> ,<?=$autres?>],
                    backgroundColor: [
                        'rgba(255, 165, 0, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(155, 155, 155,0.2)',
                        'rgba(255, 0 ,0, 0.2)',
                        'rgba(40, 250 ,0, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 165, 0, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(155, 155, 155,1)',
                        'rgba(255, 0 ,0, 1)',
                        'rgba(40, 250 ,0, 1)'
                    ],

                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Carte réseau de l\'appareil',
                }
            }
        });

    </script>


<?php include('inc/footer.php');
