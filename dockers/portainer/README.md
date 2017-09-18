    docker \
        run -d \
        --restart unless-stopped \
        -p 9000:9000 \
        -v /usr/local/lib/openag/portainer:/data \
        -v /var/run/docker.sock:/var/run/docker.sock \
        --name openag_portainer \
        portainer/portainer

