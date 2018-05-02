#!/bin/bash
WEBPORT=8001
IMAGENAME=hellophp
CONTAINERNAME=${IMAGENAME}
docker run -p${WEBPORT}:80 --rm --name hellophp -v $(readlink -e src):/var/www/html/ ${IMAGENAME}

