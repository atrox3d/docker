#!/bin/bash

# gli script di build eseguono il source di questo script di configurazione automatica
# non è necessario chiamarlo direttamente

BASE_PATH="$(cd $(dirname $BASH_SOURCE);pwd)"
DOCKER_HELPERS="${BASE_PATH}/.helpers"

function log()
{
	echo "[$(basename $0)] ${@}"
}

log "------------------------------------------------------------------------------------"
log "[$(basename $BASH_SOURCE)] BASE_PATH='$BASE_PATH'"
log "[$(basename $BASH_SOURCE)] DOCKER_HELPERS='$DOCKER_HELPERS'"
log "[$(basename $BASH_SOURCE)] PWD='$PWD'"
. "${DOCKER_HELPERS}"/detectenv.sh 2>&1 > /dev/null
log "[$(basename $BASH_SOURCE)] WINPTY='$WINPTY'"
log "[$(basename $BASH_SOURCE)] MOUNT_PREFIX='$MOUNT_PREFIX'"
log "------------------------------------------------------------------------------------"
