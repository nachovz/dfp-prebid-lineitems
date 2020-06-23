FROM gitpod/workspace-full

USER root

RUN sudo apt-get update -q \
    && sudo apt-get install -yq \
        php-soap \
