<? 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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
    die('<p>Failed to bind to LDAP server.</p>');
}

//------------------------------------------------------------------------------
// Get a list of all Active Directory users.
//------------------------------------------------------------------------------
$ldap_base_dn = 'DC=DOE,DC=GOV,DC=MY';
//$search_filter = "(&(objectCategory=person))";
//$result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
$dn        = 'dc=doe,dc=gov,dc=my';
$filter    = "(&(objectClass=user)(objectCategory=person)(sn=*))";
$justthese = array();

// enable pagination with a page size of 100.
$pageSize = 100;

$cookie = '';

do {
	ldap_control_paged_result($ldap_connection, $pageSize, true, $cookie);

	$result  = ldap_search($ldap_connection, $dn, $filter, $justthese);
	$entries = ldap_get_entries($ldap_connection, $result);

	if(!empty($entries)){
		for ($i = 0; $i < $entries["count"]; $i++) {
			if (isset($entries[$i]["description"][0]) and isset($entries[$i]["mail"][0]) and isset($entries[$i]["mailnickname"][0])) {
				$data['data'][] = array(
						'username' => $entries[$i]["mailnickname"][0],
						'name' => $entries[$i]["cn"][0],						
						'position' => $entries[$i]["description"][0],
						'email' => $entries[$i]["userprincipalname"][0]
				);
			}
		}
	}
	ldap_control_paged_result_response($ldap_connection, $result, $cookie);

} while($cookie !== null && $cookie != '');

$myJSON = json_encode($data);

echo $myJSON;

ldap_unbind($ldap_connection); // Clean up after ourselves.
?>

