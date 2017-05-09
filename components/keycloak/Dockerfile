FROM jboss/keycloak-postgres:3.1.0.Final

USER root

USER jboss
COPY conf.cli /opt/jboss/keycloak/conf.cli
RUN /opt/jboss/keycloak/bin/jboss-cli.sh --file=/opt/jboss/keycloak/conf.cli &&\
    rm -rf /opt/jboss/keycloak/standalone/configuration/standalone_xml_history/current

ENTRYPOINT ["/opt/jboss/docker-entrypoint.sh"]
