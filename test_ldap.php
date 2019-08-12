<?

$adServer = "ldap://10.19.158.15";
 
$ldap = ldap_connect($adServer) or die("Could not connect to {$adServer}");;
$domain = "@doe.gov.my";
$username = "cemsadmin";
$password = "cems2020";

$ldap_columns = NULL;
$ldap_connection = NULL;

//------------------------------------------------------------------------------
// Connect to the LDAP server.
//------------------------------------------------------------------------------
$ldap_connection = ldap_connect($adServer);
if (FALSE === $ldap_connection){
    die("<p>Failed to connect to the LDAP server: ". $adServer ."</p>");
}

ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

if (TRUE !== ldap_bind($ldap_connection, $username.$domain, $password)){
    //die('<p>Failed to bind to LDAP server.</p>');
}
echo '22';
//------------------------------------------------------------------------------
// Get a list of all Active Directory users.
//------------------------------------------------------------------------------

ldap_unbind($ldap_connection); // Clean up after ourselves.
	?>

