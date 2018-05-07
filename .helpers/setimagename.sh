#!/bin/bash
log "check for build.properties..."
[ -s build.properties ] && {
	log "list build properties:"
	
	while read _line
	do
		log "$_line"
	done < build.properties
	
	log "sourcing build.properties"
	. ./build.properties
} || log "[WARNING] file build.properties not found or empty"

[ $# -ge 1 ] && {
	log "setting IMAGENAME from argument '$1'"
	IMAGENAME="${1}"
}

[ ${IMAGENAME:-ERR_DOCKER_IMAGENAME_UNSET} = ERR_DOCKER_IMAGENAME_UNSET ] && {
	log "[ERROR] variable IMAGENAME is unset"
	log "[ERROR] check file build.properties or pass IMAGENAME value as argument \$1"
	exit 1
}

