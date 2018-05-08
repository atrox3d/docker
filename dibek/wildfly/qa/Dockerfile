FROM jboss/wildfly:10.1.0.Final

ADD pvreporterservice.war /opt/jboss/wildfly/standalone/deployments/
ADD  conf/standalone-custom.xml /opt/jboss/wildfly/standalone/configuration/

ADD oracledatabase /opt/jboss/wildfly/modules/system/layers/base/com/oracledatabase


CMD ["/opt/jboss/wildfly/bin/standalone.sh", "-c", "standalone-custom.xml", "-b", "0.0.0.0", "-bmanagement", "0.0.0.0"]

