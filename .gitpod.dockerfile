FROM gitpod/workspace-full

USER root

RUN add-apt-repository ppa:ondrej/php && apt-get update && apt-get && apt install php7.1-soap
