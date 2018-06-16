#!/usr/bin/env bash

cp -r ../oracledatabase .

docker image build .  -t "wildfly-oracle-dev"

rm -fr oracledatabase/

