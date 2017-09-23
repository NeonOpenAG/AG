#!/bin/bash

curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.4/install.sh | bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
nvm install 8.5.0
nvm alias default 8.5.0
npm install -g npm@3.5.2
ln -s /root/.nvm/versions/node/v8.5.0/bin/npm /usr/local/bin/npm
