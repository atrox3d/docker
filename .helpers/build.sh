#!/bin/bash
. $(cd $(dirname $BASH_SOURCE);pwd)/../configure-environment.sh || echo "ERROR configuring environment"
. "${DOCKER_HELPERS}"/setimagename.sh

_cmdline="docker build -t ${IMAGENAME} ."
log "$_cmdline"
docker build -t ${IMAGENAME} . && {
	log "[SUCCESS] image ${IMAGENAME} built succesfully"
} || {
	log "[FAIL] error building image ${IMAGENAME}"
}
