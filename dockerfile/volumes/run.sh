#!/bin/bash
. ../../configure-environment.sh || echo "ERROR configuring environment"

${WINPTY} docker run --rm \
-v ${MOUNT_PREFIX}${PWD}/logs:/logs ubuntu \
$( [ "$WINPTY" = "" ] && echo /bin/bash || echo //bin//bash ) -c \
"ls -l logs/*;rm logs/from-container;ls -l logs/*;touch logs/from-container;ls -l logs/*"
