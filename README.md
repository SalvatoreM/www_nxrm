Ninux_rate_meter
================

**Sistema di Monitoraggio dei Nodi della Rete Ninux tramite il protocollo SNMP**

Il progetto si compone di Moduli Indipendenti che fanno riferimento allo stesso
Data Base le cui queries di generazione sono indicate nel file "SQL_query.mysql"
 
 - Modulo per la generazione dei dati di traffico:

	I file di questo gruppo risiedono nella cartella "engine" e sono degli script 
	Python. ("nxrm.py")
	Il file è eseguibile e non necessita di altro che di esser configirato per
	l'accesso al DataBase.(variabile DatBaseHost='xxx.xxx.xxx.xxx'

 - Progetto per la rappresentazione dei dati WEB based
 	
	I files di questo gruppo risiedono nella cartela WWW e sono degli script in PHP
	e codice HTML. In questa cartella sono anche presenti due pacchetti 
	per la generazione dei grafici e un altro per la statistica delle visite al sito.
 	Ambedue i progetti sono Open source e liberamente scaricabili da  
	[http://en.christosoft.de/ ](http://en.christosoft.de/) e [http://naku.dohcrew.com/libchart/pages/introduction/ ](http://naku.dohcrew.com/libchart/pages/introduction/).
	La serie dei file consente al piena gestione del sito.
	La sola configurazione richiesta per rendere operativo il sito  è quella per 
	aggiornare nel file "libreria.php" l'indirizzo dello host su cui risiede MySQL server.
 	
	
	    
