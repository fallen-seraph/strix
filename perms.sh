#!/bin/bash

sudo chown -R fallen:www-data *
sudo chmod -R 775 *
git add .
git commit -m "adding files"
