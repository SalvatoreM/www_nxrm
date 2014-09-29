<?php include "header.html";?>
<?php @include_once("stat/src/include.php"); ?>
<?php include "libreria.php";?>
<table style="border: 3px solid black;width: 800px; background-image: url(sfondi/nuvole.jpg);" align="center" background="&#8221;nuvole.jpg&#8221;" cellpadding="0" cellspacing="0">
<tr>
<?php include "graph.php";?>
<?php
exec("rm "."*.grf*");
$oggi= explode("-",date("d-M-Y"));
//var_dump($oggi);
$operazione= $_POST['operazione'];
$giorno=$_POST['giorno'];
$mese=$_POST['mese'];
$anno=$_POST['anno'];
$mesi=array("None","Jan","Feb","Mar","Apr","May","Jun","Jul","Sep","Oct","Nov","Dec");
$bin_graph=$_POST['bin'];
$min_bin_graph=$_POST['min_bin'];
$max_bin_graph=$_POST['max_bin'];
$bout_graph=$_POST['bout'];
$min_bout_graph=$_POST['min_bout'];
$max_bout_graph=$_POST['max_bout'];
$opentime=time();
//echo $opentime,"<br>";
//echo $bin_graph."---".$min_bin_graph."---".$max_bin_graph."---".$bout_graph."---".$min_bout_graph."---".$max_bout_graph;
//echo $operazione."<br>";
#---------------------------------------------------------------------------------------
#       Sezione Ricerca Nodi
#---------------------------------------------------------------------------------------
if(($operazione=="Aggiungi") || ($operazione=="")){
	$lista= $_POST['lista'];
	if ($lista){
		$lista=$lista."|".$_POST['grafico'];
	}
	else{
		$lista=$lista.$_POST['grafico'];
	}
	//echo "operazione ".$operazione."<br>";
	$db = new DBclass();
	$db->connetti();
	$nodi = $db->estrai_record("nodi",array ("ID","nome","ip_wifi","ip_man","interface","creato","attivo","registrato"));
	$db->disconnetti();
}
#---------------------------------------------------------------------------------------

#---------------------------------------------------------------------------------------
#       Sezione Tracciamento Grafici
#---------------------------------------------------------------------------------------
if($operazione=="Disegna"){
	$lista= $_POST['lista'];
	$db = new DBclass();
	$db->connetti();
	$nodi = $db->estrai_record("nodi",array ("ID","nome","ip_wifi","ip_man","interface","creato","attivo","registrato"));
	$db->disconnetti();
	$a =explode("|",$lista); //lista dei grafici da tracciare
	//var_dump($a);
//	$giorno="24";
//	$mese="Sep";
//	$anno="2014";
	foreach($a as $l){
//		echo var_dump($l);
		$ll=explode("@",$l);
//		echo $ll[1],"-".$ll[0]."-".$ll[2]."<br>";
		$condizione=sprintf("id_nodo = '%s' and giorno ='%s' group by left(ora,2) order by ID",$ll[2],$giorno);
//		echo $condizione."<br>";
		$valori=array ("id_nodo","min(byte_out_sec)","max(byte_out_sec)","avg(byte_out_sec)");
		$valori= array_merge ($valori,array("min(byte_in_sec)","max(byte_in_sec)","avg(byte_in_sec)","left(ora,2)"));
		$vmedi = $db->estrai_valore_medio("dati",$valori,$condizione);
//		var_dump($vmedi);
		$valori=array();
		$indice=0;
		$xvalues=array();
		if($bin_graph) {
			$valori[$indice][0]="Input ";
			$indice=$indice+1;
		}
		if($bout_graph) {
			$valori[$indice][0]="Output";
			$indice=$indice+1;
		}
		if($max_bout_graph){
			$valori[$indice][0]="Max Output (B/s)";
			$indice=$indice+1;
		}
		if($min_bout_graph){
			$valori[$indice][0]="Min Output (B/s)";
			$indice=$indice+1;
		}
		if($max_bin_graph){
			$valori[$indice][0]="Max Input (B/s)";
			$indice=$indice+1;
		}
		if($min_bin_graph){
			$valori[$indice][0]="Min Input (B/s)";
			$indice=$indice+1;
		}		
		foreach($vmedi as $vm){
			$indice=0;
			if($bin_graph){
				$valori[$indice][]=$vm["avg(byte_in_sec)"];
				$indice=$indice+1;
			}
			if($bout_graph){
				$valori[$indice][]=$vm["avg(byte_out_sec)"];
				$indice=$indice+1;
			}
			if($max_bout_graph){
				$valori[$indice][]=$vm["max(byte_out_sec)"];
				$indice=$indice+1;
			}
			if($min_bout_graph){
				$valori[$indice][]=$vm["min(byte_out_sec)"];
				$indice=$indice+1;
			}
			if($max_bin_graph){
				$valori[$indice][]=$vm["max(byte_in_sec)"];
				$indice=$indice+1;
			}
			if($min_bin_graph) {
				$valori[$indice][]=$vm["min(byte_in_sec)"];
				$indice=$indice+1;
			}
			$titolo='Nodo: '.$ll[0]."-".$ll[1]." del ".$giorno." ".$mese." ".$anno;
			$xvalues[]=$vm["left(ora,2)"];
		}
		$indice=0;
		if($bin_graph) {
			$valori[$indice][0]=$valori[$indice][0].sprintf(" %d ",$vm["avg(byte_in_sec)"])."(B/s)";
			$indice=$indice+1;
		}
		if($bout_graph) {
			$valori[$indice][0]=$valori[$indice][0].sprintf(" %d ",$vm["avg(byte_out_sec)"])."(B/s)";
			$indice=$indice+1;
		}
		if($max_bout_graph){
			$valori[$indice][0]=$valori[$indice][0].sprintf(" %d ",$vm["max(byte_out_sec)"])."(B/s)";;
			$indice=$indice+1;
		}
		if($min_bout_graph){
			$valori[$indice][0]=$valori[$indice][0].sprintf(" %d ",$vm["min(byte_out_sec)"])."(B/s)";
			$indice=$indice+1;
		}
		if($max_bin_graph){
			$valori[$indice][0]=$valori[$indice][0].sprintf(" %d ",$vm["max(byte_in_sec)"])."(B/s)";
			$indice=$indice+1;
		}
		if($min_bin_graph){
			$valori[$indice][0]=$valori[$indice][0].sprintf(" %d ",$vm["min(byte_in_sec)"])."(B/s)";
			$indice=$indice+1;
		}			
		$namegraph=$ll[1].".grf".$opentime;
		$nomegrafico[]=$namegraph;
//		var_dump($nomegrafico);
//		var_dump($xvalues);
//		var_dump($valori);
//		echo "<br>";
		if ($indice) grafico($valori,$namegraph,$titolo,$xvalues);
	}
}
?>
<!--Fine Codice PHP -->
<?php include "menu.html";?>

      <!--      <td style="border: 1px solid black;background-color: rgb(238, 238, 238); height: 200px; width: 700px; vertical-align: top; color: rgb(249, 57, 6);">-->
 <td style="border: 1px solid black;background-image: url(weblink21.gif); height: 200px; width: 700px; vertical-align: top; color: rgb(249, 57, 6);">
<!-- Form  -->
 <form style="text-align: center;" name="graphic" action="grafici.php" method="post">
 <!--  Sezione  di selezione Nodi per rappresentazione grafica  -->
<h2>Rappresentazione Grafica del Traffico sui Nodi<br>
 <?php
#---------------------------------------------------------------------------------------
#       Sezione Compilazione Lista dei Nodi Grafici
#---------------------------------------------------------------------------------------
//	echo $nodi;
	if(($operazione=="Aggiungi") || ($operazione=="")){
		echo '<h4> Scegli quelli che vuoi ispezionare</b><br><br>'	;
		echo '<select name = "grafico" >';
		foreach ($nodi as $nodo){
	//		echo "nodo ".$nodo['nome']."<br>";
			echo '<option value= "'.$nodo['nome']."@".$nodo['ip_wifi']."@".$nodo['ID'].'">'.$nodo['nome']."@".$nodo['ip_wifi'].'</option>';
		}
		echo '</select>';
	}
?>
<!--------------------------------------------------------------------->
<input name="lista" <?php  echo " value=".'"'.$lista.'"'; ?> type="hidden" size='100' readonly>
<!--  Sezione  di Rappresentazione grafica  dei Nodi -->
<?php
#---------------------------------------------------------------------------------------
#       Sezione Presentazione  Grafici (immagini .png)
#       nome immagine IP.wifi.del.nodo.png
#---------------------------------------------------------------------------------------
	if(($operazione=="Aggiungi") || ($operazione==""))
		echo'<input name="operazione" value="Aggiungi" type="submit"><br><hr>';
	if ($operazione=="Disegna") {
			foreach ($nomegrafico as $grafico){
//				echo $grafico."<br>";
				echo '<img  alt="" src="'.$grafico.'"/>';
			}
	}
#---------------------------------------------------------------------------------------
#       Sezione Tselezione periodo di tracciamento Grafici
# 			- Giornaliero
# 			- Mensile 
# 			- Annuale
#---------------------------------------------------------------------------------------
	elseif ($operazione=="Aggiungi"){
		$a =explode("|",$lista);
		foreach($a as $l){
			$l=explode("@",$l);
			echo "&nbsp;&nbsp;&nbsp;&nbsp;". $l[2]." - ".$l[0]." ---> ".$l[1]."<br>";
		}
		echo '<hr><select name = "giorno" >';
		$giorni=array("None","01","02","03","04","05","06","07","08","09","10");
		$giorni=array_merge($giorni,array("11","12","13","14","15","16","17","18","19","20"));
		$giorni=array_merge($giorni,array("21","22","23","24","25","26","27","28","29","30","31"));
		foreach ($giorni as $giorno){
			if ($giorno==$oggi[0]) echo '<option value= "'.$giorno.'"  selected>'.$giorno.'</option>';
			else echo '<option value= "'.$giorno.'">'.$giorno.'</option>';
		}
		echo '</select>';
		echo '<select name = "mese" >';
		$mesi=array("None","Jan","Feb","Mar","Apr","May","Jun","Jul","Sep","Oct","Nov","Dec");
		foreach ($mesi as $mese){
			if ($mese==$oggi[1]) echo '<option value= "'.$mese.' " selected>'.$mese.'</option>';
			else echo '<option value= "'.$mese.'">'.$mese.'</option>';
		}
		echo '</select>';
		echo '<select name = "anno" >';
		$anni=array("2014","2015","2016");
		foreach ($anni as $anno){
			if ($mese==$oggi[3]) echo '<option value= "'.$anno.'"selected>'.$anno.'</option>';
			else echo '<option value= "'.$anno.'">'.$anno.'</option>';
		}
		echo '</select><br>';

		echo '<hr><h6 style="color: blue ;"><input type="checkbox" name="bin" value="True">Rate In (B/s)';
		echo  '<input type="checkbox" name="min_bin" value="True">Min Rate In (B/s)';
		echo  '<input type="checkbox" name="max_bin" value="True">Max Rate In (B/s)<br>';
		echo  '<input type="checkbox" name="bout" value="True">Rate Out (B/s)';
		echo  '<input type="checkbox" name="min_bout" value="True">Min Rate Out (B/s)';
		echo  '<input type="checkbox" name="max_bout" value="True">Max Rate Out (B/s)<br><hr>';

	}
#---------------------------------------------------------------------------------------
#       Sezione Abilitazione Tracciamento Grafici
#---------------------------------------------------------------------------------------
	if ($operazione=="Aggiungi")echo '<input name="operazione" value="Disegna" type="submit">';
?>
<!--------------------------------------------------------------------->
</form>
	</td>
</tr>
<?php include "footer.html";?>



