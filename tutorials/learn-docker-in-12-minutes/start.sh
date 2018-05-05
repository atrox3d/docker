#!/bin/bash
<<<<<<< HEAD
IMAGENAME=hellophp
CONTAINERNAME=${IMAGENAME}
HOSTPORT=80

#Windows/docker-toolbox/gitbash?
which winpty 2> /dev/null && {
	#https://stackoverflow.com/a/39858122
	WINPTY=winpty
	#https://github.com/docker/toolbox/issues/607
	MOUNT_PREFIX=/
} || {
	WINPTY=""
	MOUNT_PREFIX=""
}
=======
WEBPORT=8001
IMAGENAME=hellophp
CONTAINERNAME=${IMAGENAME}
docker run -p${WEBPORT}:80 --rm --name hellophp -v $(readlink -e src):/var/www/html/ ${IMAGENAME}
>>>>>>> 08597e7e5068d4ecb4b99794156a15aa05edb75f

${WINPTY} docker run -d --rm -p${HOSTPORT}:80 -v ${MOUNT_PREFIX}$(readlink -e src):/var/www/html/ hellophp
#docker run -p80:80 hellophp
