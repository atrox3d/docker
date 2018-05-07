#!/bin/bash
winpty docker run -v //c/Users/lombardo/Dropbox/dev/github/atrox3d/docker/dockerfile/volumes/logs:/logs ubuntu //bin//bash -c "ls -l logs/*;rm logs/from-container;ls -l logs/*;touch logs/from-container;ls -l logs/*"
