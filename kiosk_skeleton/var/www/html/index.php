<h1>Kioskbrowser</h1>

<?php 
  $wifiSSID = passthru("get-ini /boot/kioskbrowser.ini wifi ssid");
  $wifiPSK = passthru("get-ini /boot/kioskbrowser.ini wifi psk");
?>
CPU temperature: <br>
<?php passthru("sudo vcgencmd measure_temp"); ?>
<br>
CPU voltage: <br>
<?php passthru("sudo vcgencmd measure_volts"); ?>
<br>
Throttling status (everything except 0x0 means throttling, get a better power supply!): <br>
<?php passthru("sudo vcgencmd get_throttled"); ?>
<br>
Last heartbeat:
<?php echo date("Y-m-d H:i:s", filemtime("/dev/shm/heartbeat")); ?>
<br>
WiFi SSID / PSK:
<?php echo $wifiSSID.' / '.$wifiPSK; ?>
<br>

<br><br>
<img src="/screenshot.php?<?php echo microtime(); ?>">

<form method="post" action="">
  <input type="text" name="wifi_ssid" value="<?php echo $wifiSSID; ?>" />
  <input type="text" name="wifi_password" value="<?php echo $wifiPSK; ?>" />
  <button type="submit">Updaten</button>
</form>

<?php 
  if(isset($_POST['wifi_ssid'])) {
    exec('update-ini /boot/kioskbrowser.ini wifi ssid "'.$_POST['wifi_ssid'].'"'); 
    exec('update-ini /boot/kioskbrowser.ini wifi psk "'.$_POST['wifi_password'].'"'); 
    exec('update-ini /boot/kioskbrowser.ini browser url "https://narrowcasting.itmatic.nl/"'); 
    echo 'Geupdate. Apparaat wordt binnen 2 minuten herstart!';
  } else if(empty($wifiSSID)) {
?>
<script>
  const req = new XMLHttpRequest();
  setInterval(function() {
      req.open("GET", "http://localhost/heartbeat.php");
      req.send();
  }, 10000);
</script>
  <?php } ?>