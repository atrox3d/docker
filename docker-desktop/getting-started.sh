#!/bin/bash
docker ps | grep -q 'docker/getting-started' && {
	echo "INFO| docker/getting-started is running"
	echo "INFO| closing..."
	docker rm -f getting-started
}

[ "${1:-UNSET}" == "--reset" ] && {
	echo "INFO| remove image..."
	docker  image rm -f docker/getting-started
}

HOSTPORT=80
echo "INFO| docker run -d -p${HOSTPORT}:80 --name getting-started docker/getting-started"
docker run -d -p${HOSTPORT}:80 --name getting-started docker/getting-started
echo "getting-started listening on localhost:$HOSTPORT"

