<?
error_reporting(0);
$domain 	= "@doe.gov.my";
$username 	= isset($_POST['username']) && $_POST['username'] ? $_POST['username'] : '';
$password 	= isset($_POST['password']) && $_POST['password'] ? $_POST['password'] : '';

if($username=='' || $password=='') {
	echo "FALSE";
	exit;
}

$adServer 	= "ldap://10.19.158.15";
$ldap 		= ldap_connect($adServer) or die("Could not connect to {$adServer}");
$ldap_columns = NULL;
$ldap_connection = NULL;

//------------------------------------------------------------------------------
// Connect to the LDAP server.
//------------------------------------------------------------------------------
try {
	$ldap_connection = ldap_connect($adServer);
	if (FALSE === $ldap_connection){
		echo 'FALSE';
	}
	ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
	ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

	if (TRUE == ldap_bind($ldap_connection, $username.$domain, $password)){
		echo 'TRUE';
	}
	ldap_unbind($ldap_connection); // Clean up after ourselves.
} catch (Exception $e){
	echo 'FALSE';
}
?>

