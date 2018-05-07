#!/bin/bash

#Windows/docker-toolbox/gitbash?
which winpty 2>&1 > /dev/null && {
	_winpty=$(which winpty)
	log "detected $_winpty : setting WINPTY and MOUNT_PREFIX variables"
	#https://stackoverflow.com/a/39858122
	WINPTY=winpty
	#https://github.com/docker/toolbox/issues/607
	MOUNT_PREFIX=/
} || {
	log "no winpty detected"
	WINPTY=""
	MOUNT_PREFIX=""
}
