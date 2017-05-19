**repository content based on https://github.com/cyclone-project/cyclone-federation-provider**

# fed-id

A federated identity portal for authenticating users within SixSq's brokerage service, Nuvla. This feature comes as a requirement and added-value for multiple European funded projects.

# Architecture
![arch](docs/Drawing.png)

# User Guide

When authenticating with Nuvla, users will be redirected to https://fed-id.nuv.la/auth/admin/master/console/

![auth](docs/auth-screen.png)

Users can either login with a local account, social providers or any other identity providers belonging to external federations. When authenticating with an identity federation, users will be prompted with a list of IdPs (like the following figure for eduGAIN)

![idps](docs/idps-screen.png)

Users should choose a provider for which they have valid credentials, login and finally they'll be redirected back to Nuvla.


# Technical Guide

**NOTE**: this guide is intended for CentOS environments. Tested with CentOS7

To instatiate a new fed-id portal, here are the steps to be followed:

update your system:
```bash
yum update -y
yum install -y epel-release
```

install requirements:
```bash
yum install -y fail2ban git yum-utils

# Install Docker-ce and docker-compose
yum-config-manager \
    --add-repo \
    https://download.docker.com/linux/centos/docker-ce.repo

yum makecache fast
yum install docker-ce -y

systemctl start docker
systemctl enable fail2ban

curl -L https://github.com/docker/compose/releases/download/1.12.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
```

clone this repository
```bash
git clone https://github.com/SixSq/fed-id.git
GIT_DIR=$(pwd)/fed-id
```

setup the working environment
```bash
DOCKER_COMPOSE_FILE=$GIT_DIR/docker-compose-import.yml

HOSTNAME=`hostname -f`  # example myfedid.com

KEYCLOAK_USER=admin
KEYCLOAK_PASSWORD=admin

POSTGRES_USER=admin
POSTGRES_PASSWORD=admin

SAMLBRIDGE_PASSWORD=admin
SAMLBRIDGE_SALT=0123456789abcdefghijklmnopqrstuvwxyz
```

populate _.env_ which will be automatically picked by docker-compose
```bash
sed -i "s/%FP_BASEURL%/https:\/\/${HOSTNAME}/" ${GIT_DIR}/.env

sed -i -e "s/%KEYCLOAK_USER%/${KEYCLOAK_USER}/" \
        -e "s/%KEYCLOAK_PASSWORD%/${KEYCLOAK_PASSWORD}/" \
        ${GIT_DIR}/.env

sed -i -e "s/%POSTGRES_USER%/${POSTGRES_USER}/" \
        -e "s/%POSTGRES_PASSWORD%/${POSTGRES_PASSWORD}/" \
        ${GIT_DIR}/.env

sed -i -e "s/%SAMLBRIDGE_PASSWORD%/${SAMLBRIDGE_PASSWORD}/" \
        -e "s/%SAMLBRIDGE_SALT%/${SAMLBRIDGE_SALT}/" \
        ${GIT_DIR}/.env
```

create a self-signed certificate for the samlbridge
```bash
openssl req \
    -new \
    -x509 \
    -days 3652 \
    -nodes \
    -subj "/C=CH/ST=Meyrin/L=Geneva/O=SixSq/CN=${HOSTNAME}" \
    -out ${GIT_DIR}/components/samlbridge/samlbridge-cert/server.crt \
    -keyout ${GIT_DIR}/components/samlbridge/samlbridge-cert/server.pem

SSP_CERT=`openssl x509 -in ${GIT_DIR}/components/samlbridge/samlbridge-cert/server.crt | tail -n +2 | head -n -1 | tr -d '\n' | sed 's/\//\\\//g'`

sed "s/%SSP_URL%/http:\/\/${HOSTNAME}\/samlbridge/g; s/%SSP_ALIAS%/eduGAIN/g; s/%SSP_CERT%/${SSP_CERT}/g" \
    ${GIT_DIR}/default/kcexport_template.json > ${GIT_DIR}/default/kcexport.json
```


launch the portal
```bash
cd $GIT_DIR
docker-compose -f $DOCKER_COMPOSE_FILE up --build -d
```

---
if fail2ban is required:
```bash
cat << EOF > /etc/fail2ban/jail.local
[DEFAULT]
# Ban hosts for one hour:
bantime = 3600

# Override /etc/fail2ban/jail.d/00-firewalld.conf:
banaction = iptables-multiport

[sshd]
enabled = true

ignoreip = 127.0.0.1/8
EOF

systemctl restart fail2ban
```

---

The portal will finally be at:
https://yourhostname

Traefik redirects this request to the Keycloak interface automatically at https://yourhostname/auth

The SAMLbridge is also available at https://yourhostname/samlbridge

Traefik also provides a dashboard at http://yourhostname:8080
