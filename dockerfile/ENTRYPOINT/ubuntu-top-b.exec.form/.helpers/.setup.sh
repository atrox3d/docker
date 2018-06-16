#!/bin/bash

# gli script di build eseguono il source di questo script di configurazione automatica
# non è necessario chiamarlo direttamente


function log()
{
	#echo "[$(basename $0)/$(basename $BASH_SOURCE)/${FUNCNAME[1]/source/main}] ${@}"
	echo "[$(basename $0)/$(printf "%-15.15s" ${FUNCNAME[1]/source/main})] ${@}"
}

function set_imagename()
{
	local BUILDPROPERTIES="${SCRIPT_PATH}/build.properties"
	
	log "check for build.properties..."
	[ -s "${BUILDPROPERTIES}" ] && {
		log "[FOUND] list build properties:"
		
		while read _line
		do
			log "$_line"
		done < build.properties
		
		log "sourcing build.properties"
		. "${BUILDPROPERTIES}"
	} || log "[WARNING] file build.properties not found or empty"

	[ $# -ge 1 ] && {
		log "setting IMAGENAME from argument '$1'"
		IMAGENAME="${1}"
	}

	[ ${IMAGENAME:-ERR_DOCKER_IMAGENAME_UNSET} = ERR_DOCKER_IMAGENAME_UNSET ] && {
		log "[ERROR] variable IMAGENAME is unset"
		log "[ERROR] check file build.properties or pass IMAGENAME value as argument \$1"
		return 1
	}

}

function docker_build()
{
	_cmdline="docker build -t ${IMAGENAME} ."
	log "$_cmdline"
	docker build -t ${IMAGENAME} . && {
		log "[SUCCESS] image ${IMAGENAME} built succesfully"
	} || {
		log "[FAIL] error building image ${IMAGENAME}"
	}
}


function detect_environment()
{
	which winpty 2>&1 > /dev/null && {
		_winpty=$(which winpty)
		log "detected $_winpty [docker-toolbox/windows 7]: setting WINPTY and MOUNT_PREFIX variables"
		#https://stackoverflow.com/a/39858122
		WINPTY=winpty
		#https://github.com/docker/toolbox/issues/607
		MOUNT_PREFIX=/
	} || {
		log "no winpty detected [linux/windows 10]"
		WINPTY=""
		MOUNT_PREFIX=""
	}
}

SCRIPT_PATH="$(cd $(dirname $BASH_SOURCE)/..;pwd)"
DOCKER_HELPERS="${SCRIPT_PATH}/.helpers"
IMAGENAME=""
WINPTY=""
MOUNT_PREFIX=""

detect_environment

log "------------------------------------------------------------------------------------"
log "SCRIPT_PATH='$SCRIPT_PATH'"
log "DOCKER_HELPERS='$DOCKER_HELPERS'"
log "PWD='$PWD'"
log "WINPTY='$WINPTY'"
log "MOUNT_PREFIX='$MOUNT_PREFIX'"
log "------------------------------------------------------------------------------------"
