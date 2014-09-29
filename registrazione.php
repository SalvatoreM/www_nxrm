<?php include "header.html";?>
<?php @include_once("stat/src/include.php");?>
<?php include "libreria.php";?>
<table style="border: 3px solid black;width: 800px; background-image: url(sfondi/nuvole.jpg);" align="center" background="&#8221;nuvole.jpg&#8221;" cellpadding="0" cellspacing="0">
<tr>
<?php include "menu.html";?>
<?php
// lettura variabili POST
$nomenodo=$_POST['nomenodo'];
$ipwifi=$_POST['ipwifi'];
$ipman=$_POST['ipman'];
$if=$_POST['if'];
$ipservizio=$_POST['ipservizio'];
$descrizione=$_POST['descrizione'];
$porta=$_POST['porta'];
$registrato="true";
$operazione=$_POST['operazione'];
$eseguito=false;
$trovato=false;
$readonly="";
// --------------------------
// Analisi Input ricevuto
//---------------------------

//--- Registrazione di un nuovo Nodo --------
//
if (!empty($nomenodo) and ($operazione=="Registra")){
//	echo $nomenodo."<br>";
	list ($nomenodo,$ipwifi,$ipman,$registrato) = registrazione_nodo($nomenodo,$ipwifi,$ipman,$if);
	$eseguito=true;
}
elseif ($operazione == "Registra"){
	 $nomenodo="Il Nodo deve avere un Nome";
}
//--- Aggiunta di un nuovo Servizio --------
//
if (!empty($descrizione) and ($operazione=="Aggiungi")){
	list ($ipwifi,$descrizione,$ipservizio,$porta) = aggiungi_servizio($ipwifi,$descrizione,$ipservizio,$porta);
}
elseif ($operazione == "Aggiungi"){
	 $descrizione="Il Servizio deve avere una Nome";
}
//--- Cancellazione di un Nodo (non ancora attiva)--------
//
if (!empty($descrizione) and ($operazione=="Cancella")){
	list ($ipwifi,$descrizione,$ipservizio) =  cancellazione_nodo($nomenodo,$ipwifi,$ipman);
}
elseif ($operazione == "Cancella"){
	 $descrizione="Il Servizio deve avere una Nome";
}
//--- Modifica di un  un Nodo esistente (non ancora attiva)--------
//
if (!empty($nomenodo) and ($operazione=="Modifica")){
	list ($nomenodo,$ipwifi,$ipman) =  modifica_nodo($nomenodo,$ipwifi,$ipman,$if);
	$readonly="readonly";
}
elseif ($operazione == "Modifica"){
	 $descrizione="Il Servizio deve avere una Nome";
}
if (!empty($ipwifi) and ($operazione=="Cerca")){
	list ($nomenodo,$ipwifi,$ipman,$trovato) = cerca_nodo($nomenodo,$ipwifi);
	if ($trovato) $readonly="readonly";
	echo $readonly."<br>";
}
elseif ($operazione =="Cerca"){
	 $ipwifi=" Specificare un indirizzo";
}
?>
<!--Fine Codice PHP -->
<!--      <td style="border: 1px solid black;background-color: rgb(238, 238, 238); height: 200px; width: 700px; vertical-align: top; color: rgb(249, 57, 6);">-->
 <td style="border: 1px solid black;background-image: url(weblink21.gif); height: 200px; width: 700px; vertical-align: top; color: rgb(249, 57, 6);">
<!-- Form di Registrazione dati del Nodo -->
      <form style="text-align: center;" name="Registrazione" action="registrazione.php" method="post">
        <h3>Gestione Nodo</h3>
			<?php
				if ((!$registrato) and ($eseguito)){
					echo "(Registrazione non eseguita) <br>";
				}
			?>
        <hr>
        <h4 style="text-align: left;">&nbsp;Identita'</h4>
 	<span style="color: black;">&nbsp;&nbsp;Nome del Nodo:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<input style="color: black;" name="nomenodo" <?php  echo "value=".'"'.$nomenodo.'"'; ?> type="text" size='30'>
	<br style="color: black;">
   <br style="color: black;">
	<span style="color: black;">&nbsp;&nbsp;IP Antenna WiFi:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<input style="color: black;" name="ipwifi"  <?php  echo "value=".'"'.$ipwifi.'" '.$readonly." "; ?>type="text" size='30'> <br style="color: black;"><br style="color: black;">
	<span style="color: black;">&nbsp;&nbsp;IP Agent SNMP:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<input name="ipman" indirizzo="" ip="" della="" wifi=""  <?php  echo "value=".'"'.$ipman.'"'; ?> type="text" size='30'><br><br>
	<span style="color: black;">&nbsp;&nbsp;Nome Interfaccia:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<select name="if">
		<option value="wlan0">wlan0</option>
		<option value="eth0">eth0</option>
		<option value="ath0" selected>ath0</option>
		<option value="eth1">eth1</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
<!--	<input name="if" indirizzo="" ip="" della="" wifi=""  <?php  echo "value=".'"'.$ipman.'"'; ?> type="text"><br><br> -->
   <hr>
<?php
//	 echo $trovato;
    if (!$trovato) echo '<input name="operazione" value="Registra" type="submit">';
    if (!$trovato) echo ' <input name="operazione" value="Cerca" type="submit">';
    if ($trovato=="trovato") echo ' <input name="operazione" value="Cancella" type="submit">';
    if ($trovato=="trovato") echo '  <input name="operazione" value="Modifica" type="submit">';
?>
   <hr>
   <h4 style="text-align: left;">&nbsp;Servizi Offerti</h4>
	<span style="color: blue;">Descrizione:&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<input style="color: black;" name="descrizione" <?php  echo "value=".'"'.$descrizione.'"'; ?> type="text" size='30'><br>
	<span style="color: blue;">Indirizzo IP:&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<input style="color: black;" name="ipservizio" <?php  echo "value=".'"'.$ipservizio.'"'; ?> type="text" size='30'><br>
	<span style="color: blue;">Porta:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;
	<input style="color: black;" name="porta" <?php echo "value=".'"'.$porta.'"'; ?> type="text" size='30'>
   <hr>
   <input name="operazione" value="Aggiungi" type="submit">
   </form>  <hr>
   </td>
   </tr>
<?php include "footer.html";?>

