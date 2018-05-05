#!/bin/bash
IMAGENAME=ubuntutop-exec
CONTAINERNAME=${IMAGENAME}
which winpty 2> /dev/null && {
	WINPTY=winpty
	BASH=//bin//bash
} || {
	WINPTY=""
	BASH=/bin/bash
}

cat <<EOF
# esecuzione con parametri CMD ed ENTRYPOINT da dockerfile
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} ${IMAGENAME}

# esecuzione con override ENTRYPOINT e parametri CMD
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} --entrypoint ${BASH} ${IMAGENAME}
${WINPTY} docker run -it --rm --name ${CONTAINERNAME} --entrypoint ${BASH} ${IMAGENAME} -c "ls -l"

# esecuzione con override parametri CMD
${WINPTY} docker run -it --rm ${IMAGENAME} ""

EOF
