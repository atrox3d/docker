#!/bin/bash
docker run -p80:80 -v $(readlink -e src):/var/www/html/ hellophp
#docker run -p80:80 hellophp

