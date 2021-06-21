#!/bin/bash
docker rm -f getting-started
docker  image rm -f docker/getting-started
docker run -d -p80:80 --name getting-started docker/getting-started
