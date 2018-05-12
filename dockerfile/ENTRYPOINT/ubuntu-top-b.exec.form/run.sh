#!/bin/bash
. .helpers/.setup.sh || echo "ERROR configuring environment"

set_imagename $1
CONTAINERNAME=${IMAGENAME}
_BASH="$( [ "$WINPTY" = "" ] && echo /bin/bash || echo //bin//bash )"

cat <<EOF
# esecuzione con parametri CMD ed ENTRYPOINT da dockerfile
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} ${IMAGENAME}

# esecuzione con override ENTRYPOINT e parametri CMD
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} --entrypoint ${_BASH} ${IMAGENAME}
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} --entrypoint ${_BASH} ${IMAGENAME} -c "ls -l"

# esecuzione con override parametri CMD
${WINPTY} docker run -it --rm <NOMEIMMAGINE> ""

EOF