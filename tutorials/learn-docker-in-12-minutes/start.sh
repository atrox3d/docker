#!/bin/bash
IMAGENAME=hellophp
CONTAINERNAME=${IMAGENAME}
HOSTPORT=80

#Windows/docker-toolbox/gitbash?
which winpty 2>&1 > /dev/null && {
	_winpty=$(which winpty)
	echo "detected $_winpty : setting WINPTY and MOUNT_PREFIX variables"
	#https://stackoverflow.com/a/39858122
	WINPTY=winpty
	#https://github.com/docker/toolbox/issues/607
	MOUNT_PREFIX=/
} || {
	WINPTY=""
	MOUNT_PREFIX=""
}
_cmdline="${WINPTY} docker run -d --rm -p${HOSTPORT}:80 -v ${MOUNT_PREFIX}$(readlink -e src):/var/www/html/ ${IMAGENAME}"
echo "[RUNNING] :"
echo "-------------------------------------------------------------------------"
echo "${_cmdline}"
echo "-------------------------------------------------------------------------"

${_cmdline} && {
	echo "[SUCCESS]"
	ID=$(docker ps -lq)
	echo "stop   : docker stop $ID"
	echo "attach : docker attach $ID"
	echo "logs   : docker logs $ID"
	
	which docker-machine 2>&1 > /dev/null && {
		echo "URL    : http://$(docker-machine ip):${HOSTPORT}"
	} || {
		echo $IP=$(ip route get 8.8.8.8 | tr -s ' ' | cut -d' ' -f7)
		echo "URL    : http://${IP}:${HOSTPORT}"
	}

} || {
	echo "[FAILURE ] with exit code $?"
}
#docker run -p80:80 hellophp
