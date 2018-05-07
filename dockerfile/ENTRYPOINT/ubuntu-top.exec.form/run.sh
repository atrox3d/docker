#!/bin/bash
. ../../../configure-environment.sh || echo "ERROR configuring environment"
. "${DOCKER_HELPERS}"/setimagename.sh
#IMAGENAME=ubuntutop-exec
CONTAINERNAME=${IMAGENAME}

cat <<EOF
# esecuzione con parametri CMD ed ENTRYPOINT da dockerfile
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} ${IMAGENAME}

# esecuzione con override ENTRYPOINT e parametri CMD
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} --entrypoint ${BASH} ${IMAGENAME}
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} --entrypoint ${BASH} ${IMAGENAME} -c "ls -l"

# esecuzione con override parametri CMD
${WINPTY} docker run -it --rm ${IMAGENAME} ""

EOF

