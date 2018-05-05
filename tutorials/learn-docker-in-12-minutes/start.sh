#!/bin/bash
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

${WINPTY} docker run -d --rm -p${HOSTPORT}:80 -v ${MOUNT_PREFIX}$(readlink -e src):/var/www/html/ ${IMAGENAME}
#docker run -p80:80 hellophp
