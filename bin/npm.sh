#!/bin/bash

if hash yarn 2>/dev/null;
then
    yarn
    yarn upgrade
    yarn dev
else
    npm install
    npm update
    npm run dev
fi