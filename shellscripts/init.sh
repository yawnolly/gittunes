#!/bin/bash

path="./wp-content/themes/blankslate-child/projects/$1";
cd $path;
git init;
git add .;
git commit -m "$2";

