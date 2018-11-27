<?php

if ( ENVIRONMENT === 'production' ) {
	$amu_ldap_config = array(
		'ldaphost' => 'ldaps://authorise.is.ed.ac.uk',
		'ldapport' => 389,
		'dn'       => 'ou=people,ou=central,dc=authorise,dc=ed,dc=ac,dc=uk',
	);
} else {
	$amu_ldap_config = array(
		'ldaphost' => 'ldaps://authorise-test.is.ed.ac.uk',
		'ldapport' => 389,
		'dn'       => 'ou=people,ou=central,dc=authorise-test,dc=ed,dc=ac,dc=uk',
	);
}
