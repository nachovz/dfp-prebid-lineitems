FROM gitpod/workspace-full

USER root

RUN add-apt-repository ppa:ondrej/php \ 
  && apt-get update \ 
  && apt-get install php7.0-soap
