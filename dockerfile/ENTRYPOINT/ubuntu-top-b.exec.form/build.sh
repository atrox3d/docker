#!/bin/bash
. ../../../configure-environment.sh || echo "ERROR configuring environment"
. "${DOCKER_HELPERS}"/build.sh "$@"

