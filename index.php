<body onload="JavaScript:timedRefresh(15000);">
<body style="background-color:powderblue;">
<br><h1>Mantana Laaiadkan  62107594 </h1></br>

<iframe src="https://thingspeak.com/channels/1458409/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15" width="450" height="260"></iframe>
<iframe src="https://thingspeak.com/channels/1458409/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15" width="450" height="260"></iframe>
<iframe src="https://thingspeak.com/channels/1458409/maps/channel_show" width="450" height="260"></iframe>
<?php
 $Temperature = file_get_contents('https://api.thingspeak.com/channels/1458409/fields/1/last.txt');
 $Humidity = file_get_contents('https://api.thingspeak.com/channels/1458409/fields/2/last.txt');
?>
<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
}
</script>
 <br> <?php echo "Humidity is = ".$Temperature ?> </br> 
 <br> <?php echo " Temperature is = ".$Humidity ?> </br>
 
</body>
