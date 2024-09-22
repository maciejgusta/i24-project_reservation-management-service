#!/bin/bash

git pull origin master
sudo systemctl restart apache2.service

