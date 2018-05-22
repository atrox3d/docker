#!/bin/bash
find . \( -path ./.git -prune -and -type f \) -o -type f -and -exec bash -c "xxd {} | grep -q 0d && dos2unix {}" \;
