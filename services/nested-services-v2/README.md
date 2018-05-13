# Docker-compose files yaml annidati (version '2')

Questo progetto è composto da un docker-compose.yml **master** che usa la proprietà extends (non più valida nella versione 3) per "includere" i docker-compose.yml dei sottoprogetti.

In questo modo ogni progetto è autonomo ed autoconsistente, quindi riutilizzabile separatamente.

La struttura risultante è la seguente:


* ```./docker-compose.yml```
	* ```./elasticsearch/docker-compose.yml```
	* ```./product/docker-compose.yml```
	* ```./website/docker-compose.yml```

E' sufficiente lanciare ```docker-compose up``` nella directory principale per avviare i 3 servizi.

il file docker-compose.yml dichiara ed istanzia i tre servizi:

* product-service: (python rest api)
* elastisearch: (elasticsearch rest api)
* website (webserver apache-php)

Una volta partiti è sufficiente collegarsi al servizio website da browser (http://localhost:5000 oppure http://$(docker-machine ip):5000).

website/index.php si collegherà ai due servizi e visualizzerà i json ottenuti.
