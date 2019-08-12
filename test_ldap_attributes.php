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
    die('<p>Failed to bind to LDAP server.</p>');
}

//------------------------------------------------------------------------------
// Get a list of all Active Directory users.
//------------------------------------------------------------------------------
$ldap_base_dn = 'DC=DOE,DC=GOV,DC=MY';
$search_filter = "(&(objectCategory=person))";
$result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
if (FALSE !== $result){
    $entries = ldap_get_entries($ldap_connection, $result);
    if ($entries['count'] > 0){
        $odd = 0;
        foreach ($entries[0] AS $key => $value){
            if (0 === $odd%2){
                $ldap_columns[] = $key;
            }
            $odd++;
        }
        echo '<table border=1 class="data">';
        echo '<tr>';
        $header_count = 0;
        foreach ($ldap_columns AS $col_name){
            if (0 === $header_count++){
                echo '<th class="ul">';
            }else if (count($ldap_columns) === $header_count){
                echo '<th class="ur">';
            }else{
                echo '<th class="u">';
            }
            echo $col_name .'</th>';
        }
        echo '</tr>';
        for ($i = 0; $i < $entries['count']; $i++){
            echo '<tr>';
            $td_count = 0;
            foreach ($ldap_columns AS $col_name){
                if (0 === $td_count++){
                    echo '<td class="l">';
                }else{
                    echo '<td>';
                }
                if (isset($entries[$i][$col_name])){
                    $output = NULL;
                    if ('lastlogon' === $col_name || 'lastlogontimestamp' === $col_name){
                        $output = date('D M d, Y @ H:i:s', ($entries[$i][$col_name][0] / 10000000) - 11676009600);
                    }else{
                        $output = $entries[$i][$col_name][0];
                    }
                    echo $output .'</td>';
                }
            }
            echo '</tr>';
        }
        echo '</table>';
    }
}
ldap_unbind($ldap_connection); // Clean up after ourselves.
?>

