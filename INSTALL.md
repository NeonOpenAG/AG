Installing AG Dockers
=====================

Ubuntu
------

    sudo apt-get install apt-transport-https
    sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys E3F59070
    echo "deb https://openag.neontribe.org/dists/stable/main/binary /" | sudo tee -a /etc/apt/sources.list
    sudo apt-get update
    sudo apt-get install openag


Other UNIX including Macintosh
------------------------------

You will need docker and tmux installed then it's just a shell script.

    wget https://raw.githubusercontent.com/neontribe/AG/develop/bin/openag | sudo tee -a /usr/local/bin/openag
    wget https://raw.githubusercontent.com/neontribe/AG/develop/bin/openag.functions.sh | sudo tee -a /usr/local/bin/openag.functions.sh

You won't get a launcher so you will need to start it from a terminal and you'll need to run the command again to get updates.

Windows
-------

**TODO**
