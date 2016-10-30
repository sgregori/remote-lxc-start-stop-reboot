<meta name="viewport" content="width=device-width, user-scalable=no">
<?php

$contenedores = array("contenedor_1","contenedor_2");

if(!empty($_POST["vm"])){

      $connection = ssh2_connect('localhost', 22);
      ssh2_auth_password($connection, 'root','password');

      switch($_POST["accion"]){

              case "start":
                      $command = "lxc-start -d -n ".$_POST["vm"]." & ";
              break;

              case "stop":
                      $command = "lxc-stop -n ".$_POST["vm"]."
                      sleep 30
                      lxc-ls -f |grep ".$_POST["vm"]." ";
              break;

              case "reboot":
                      $command = "
                      lxc-stop -n ".$_POST["vm"]."
                      sleep 30
                      lxc-start -d -n ".$_POST["vm"]."
                      lxc-ls -f |grep ".$_POST["vm"]."
                      ";
              break;

      }

        $stream = ssh2_exec($connection, $command);
        fclose($stream);

}

?>
<form method="post">
<select name="vm" style="width: 100%; max-width: 500px; height: 40px;">
<?php

foreach ($contenedores as $contenedor){

echo '<option value="'.$contenedor.'">'.$contenedor.'</option>';

}

?>
</select>
<br>
<select name="accion" style="width: 100%; max-width: 500px; height: 40px;">
<option value="start">START</option>
<option value="stop">STOP</option>
<option value="reboot" selected>REBOOT</option>
</select>
<br>
<input type="submit" name="submit" value="EJECUTAR" style="width: 100%; max-width: 500px; height: 40px;">
</form>

<a href="/"><input type="button" name="submit" value="RECARGAR" style="width: 100%; max-width: 500px; height: 40px;"></a>
