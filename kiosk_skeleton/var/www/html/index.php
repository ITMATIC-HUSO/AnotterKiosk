<h1>Kioskbrowser</h1>

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

<br><br>
<img src="/screenshot.php?<?php echo microtime(); ?>">

<form method="post" action="">
  <input type="text" name="wifi_ssid" />
  <input type="text" name="wifi_password" />
  <button type="submit">Updaten</button>
</form>

<?php 
  if(isset($_POST['wifi_ssid'])) {
    exec('update-ini /boot/kioskbrowser.ini wifi ssid "'.$_POST['wifi_ssid'].'"'); 
    exec('update-ini /boot/kioskbrowser.ini wifi psk "'.$_POST['wifi_password'].'"'); 
    exec('update-ini /boot/kioskbrowser.ini browser url "https://narrowcasting.itmatic.nl/"'); 
    echo 'Geupdate. Reboot het apparaat!';
  }
?>
