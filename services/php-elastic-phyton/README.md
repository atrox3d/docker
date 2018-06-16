# Docker-compose file yml unico

il file docker-compose.yml dichiara ed istanzia i tre servizi:

* product-service: (python rest api)
* elastisearch: (elasticsearch rest api)
* website (webserver apache-php)

E' sufficiente lanciare ```docker-compose up``` nella directory principale per avviare i 3 servizi.

Una volta partiti è sufficiente collegarsi al servizio website da browser (http://localhost:5000 oppure http://$(docker-machine ip):5000).

website/index.php si collegherà ai due servizi e visualizzerà i json ottenuti.
