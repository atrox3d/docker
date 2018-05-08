_Run elastic search server_

Change directory to elasticsearch/
Run: 
startElasticSearch.bat


_Docker commands_

List active containers : _docker ps_

List images: _docker images_

Remove container: _docker rm <hash container>_

Remove image: _docker rm <hash_images>_

Is it possible to remove a list of items as well

If there are errors starting a container may be needed to restart the docker application.
A shortcut to docker can be found in the windows tray (on the bottom right the "up"  arrow)

_create and run wildfly image_

Change directory to /wildfly
Run the command:

docker image build -f dev -t "wildfly-oracle-dev"

when completed change to dev/ directory and run

docker-compose up

after the server start it is possible to copy the war file:

docker cp pvreporter-service/build/libs/pvreporterservice.war dev_wildfly_1:/opt/jboss/wildfly/standalone/deployments/

_Access the container_

docker exec -it dev_wildfly_1 bash 
