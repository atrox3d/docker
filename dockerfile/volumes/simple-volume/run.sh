#!/bin/bash
. ../../../configure-environment.sh || echo "ERROR configuring environment"

HOST_PATH=${PWD}/logs
CONTAINER_PATH=/logs
${WINPTY} docker run --rm \
-v ${MOUNT_PREFIX}${HOST_PATH}:${CONTAINER_PATH} ubuntu \
$( [ "$WINPTY" = "" ] && echo /bin/bash || echo //bin//bash ) -c \
"ls -l logs/*;rm logs/from-container;ls -l logs/*;touch logs/from-container;ls -l logs/*"
