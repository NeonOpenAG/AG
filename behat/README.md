    sudo apt-get install chromium-chromedriver
    wget https://github.com/mozilla/geckodriver/releases/download/v0.13.0/geckodriver-v0.13.0-linux64.tar.gz
    tar -xvzf geckodriver*
    sudo mv geckodriver /usr/local/bin/
    sudo chmod +x /usr/local/bin/geckodriver

    wget http://selenium-release.storage.googleapis.com/3.4/selenium-java-3.4.0.zip
    java -jar -Dwebdriver.chrome.driver="/usr/lib/chromium-browser/chromedriver" -Dwebdriver.gecko.driver="/usr/local/bin/geckodriver" /home/tobias/Downloads/selenium-server-standalone-3.4.0.jar
