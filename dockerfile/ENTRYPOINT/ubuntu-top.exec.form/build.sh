#!/bin/bash
. .helpers/.setup.sh || echo "ERROR configuring environment"
set_imagename $1
docker_build

