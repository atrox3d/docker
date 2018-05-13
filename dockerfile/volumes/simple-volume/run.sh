#!/bin/bash
. .helpers/.setup.sh || echo "ERROR configuring environment"

HOST_PATH=${PWD}/logs
CONTAINER_PATH=/logs
IMAGENAME=ubuntu
_BASH="$( [ "$WINPTY" = "" ] && echo /bin/bash || echo //bin//bash )"
_BASH_OPTIONS="-c"
CMDLINE="ls -l logs/*;rm logs/from-container;ls -l logs/*;touch logs/from-container;ls -l logs/*"

log "running: ${WINPTY} docker run --rm -v \"${MOUNT_PREFIX}${HOST_PATH}\":\"${CONTAINER_PATH}\" \"${IMAGENAME}\" \"${_BASH}\" \"${_BASH_OPTIONS}\"  \"${CMDLINE}\""
${WINPTY} docker run --rm -v "${MOUNT_PREFIX}${HOST_PATH}":"${CONTAINER_PATH}" "${IMAGENAME}" "${_BASH}" "${_BASH_OPTIONS}" "${CMDLINE}"

