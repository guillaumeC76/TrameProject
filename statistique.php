<?php
session_start();
include('inc/function.php');
include('inc/pdo.php');
$fichier = file_get_contents('./files/capture.json');
$json = json_decode($fichier, true);

include('inc/header.php'); ?>
<div class="containerFlex">
    <div class="containerGraphique">
        <div id="chartContainer1">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="containerGraphique2">
        <div id="chartContainer2">
            <canvas id="chartMac"></canvas>
        </div>
    </div>
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
            type: 'bar',
            data: {
                labels: ['TCP', 'UDP'],
                datasets: [{
                    label: 'Types de connexions',
                    data: [<?=$udp?>, <?=$tcp?>],
                    backgroundColor: [
                        '#25313c',
                        '#407eae'
                    ],
                    borderColor: [
                        '#25313c',
                        '#407eae'
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
                        '#25313c',
                        '#407eae',
                        '#88959A',
                        '#c2c2c2',
                        '#ECECEC'
                    ],
                    borderColor: [
                        '#25313c',
                        '#407eae',
                        '#88959A',
                        '#c2c2c2',
                        '#ECECEC'
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
