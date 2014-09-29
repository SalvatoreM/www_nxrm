*Il progetto Ninux Rate Meter*
-----------------------------


nasce sulla esigenza di monitorare il carico di comunicazione
di ogni nodo WiFi della rete Ninux di Firenze. 

Il progetto è basato sulla semplicità di
accesso alle informazioni attraverso il protocollo SNMP.

In ogni antenna ubiquity è attivabile un agent SNMP, così come per i router con OpenWRT.

In questo modo si rendono disponibili tutta una sereie di dati relativi alle interfacce di comunicazione (IF-MIB)

I dati rilevati sono relativi alla sola interfaccia WiFi,
ovvero:

+ Totale Byte di Ingresso
+ Totale Byte di in Uscita 
+ Tempo assoluto in secondi

In questo modo si possono ottenere i valori medi di banda occupata da ciascun nodo nell'arco di tempo
trascorso tra due campionamenti.

La frequenza dei campionamenti non è tenuta elevatain modo da  per mantenere irrilevante il
traffico necessario al monitoraggio ed anche in prospettivia di un numero dei nodi che, in futuro,
 può anche essere elevato.

I dati sono quindi archiviati (MySQL) e condivisi attraverso la rete Ninux.
Si può ottenere una situazione media di traffico presente sulla linea per individuare eventuali sovraccarico di nodi.

**Nessun tipo di rilevazione è effettuata sul tipo di protocolli o sul contenuto dei pacchetti.**

Non si può pretedendere di rilevare valori di picco della banda, per fare questo è necessario effettuare 
un monitoraggio locale.



