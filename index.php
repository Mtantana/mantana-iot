<body onload="JavaScript:timedRefresh(15000);"> 
<br><h1>Wasinee Na Ranong  62108659 </h1></br>

<iframe src="https://thingspeak.com/channels/1458415/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15" width="450" height="260"></iframe>
<iframe src="https://thingspeak.com/channels/1458415/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15" width="450" height="260"></iframe>
<iframe src="https://thingspeak.com/channels/1458415/maps/channel_show" width="450" height="260"></iframe>
<?php
 $Temperature = file_get_contents('https://api.thingspeak.com/channels/1458415/fields/1/last.txt');
 $Humidity = file_get_contents('https://api.thingspeak.com/channels/1458415/fields/2/last.txt');
?>
<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
}
</script>
 <br> <?php echo "Humidity is = ".$Temperature ?> </br> 
 <br> <?php echo " Temperature is = ".$Humidity ?> </br>
 
</body>
