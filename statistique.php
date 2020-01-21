<pre>
<?php
$fichier = file_get_contents('./files/capture.json');
$json = json_decode($fichier, true);

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
        echo $date . ' ' . $protocole . ' ' . $ethSrc . ' - ' . $ethDst . '------------------------------' . $ipSrc . ' - ' . $ipDst . ' ' . $portSrc . ' ' . $portDst . "\n";

    }
}
?>

 <table id="table">
        <thead>
        <th>Date</th>
        <th>Adresse IP Source</th>
        <th>Adresse IP Destination</th>
        <th>Adresse MAC Source</th>
        <th>Adresse MAC Destination</th>
        <th>Protocole</th>
        <th>Port Source</th>
        <th>Port Destination</th>
        </thead>
            <tbody>
            </tbody>
 </table>




</pre>