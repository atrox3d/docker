#!/bin/bash

[ $# -ge 1 ] || {
	echo "syntax $0 \"comment\""
	exit 1;
}

git add . || {
	echo "error git add .";
	exit 2;
}

git commit -m "$1" || {
	echo "error git commit -m \"$1\"";
	exit 3;
}

git push || {
	echo "error git push";
	exit 4;
}


