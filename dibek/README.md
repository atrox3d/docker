# Run elastic search server

Change directory to elasticsearch/
Run: ```startElasticSearch.bat```

# Docker commands

- List active containers : ```docker ps```

- List images: ```docker images```

- Remove container: ```docker rm <hash container>```

- Remove image: ```docker rm <hash_images>```

Is it possible to remove a list of items as well

If there are errors starting a container may be needed to restart the docker application.
A shortcut to docker can be found in the windows tray (on the bottom right the "up"  arrow)

# create and run wildfly image

Change directory to wildfly/
Run the command:

```
docker image build -f dev -t "wildfly-oracle-dev"
```

when completed change to dev/ directory and run

```
docker-compose up
```

after the server start it is possible to copy the war file:

```
docker cp pvreporter-service/build/libs/pvreporterservice.war dev_wildfly_1:/opt/jboss/wildfly/standalone/deployments/
```

# Access the container

```
docker exec -it dev_wildfly_1 bash 
```

