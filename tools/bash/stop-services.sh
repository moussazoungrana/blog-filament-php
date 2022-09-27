#!/usr/bin/env bash

systemctl is-active --quiet mysql && systemctl stop mysql
systemctl is-active --quiet redis && systemctl stop redis

which valet &>/dev/null && valet stop &>/dev/null

systemctl is-active --quiet nginx && systemctl stop nginx
systemctl is-active --quiet httpd && systemctl stop httpd
systemctl is-active --quiet apache2 && systemctl stop apache2
systemctl start docker
