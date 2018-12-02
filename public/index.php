<?php
ini_set("display_errors", 1);
session_name('user');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
$_SESSION['localhostPath']='';
require_once 'config.php';
require_once '../app/init.php';
require_once '../app/views/modules/modules.php';

try{
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT value FROM config WHERE key_word = 'licencja'";
$query2 = "SELECT value FROM config WHERE key_word = 'nip'";


$stmt1 = $conn->prepare($query);
$error1 = $stmt1->execute();
$stmt2 = $conn->prepare($query2);
$error2 = $stmt2->execute();

$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result1) or !empty($result2)) {
    $licence =$result1[0]['value'];
    $nip =$result2[0]['value'];
}
else{
    echo '0';
}
} catch (Exception $e){
    echo "nie mozna polaczyc sie z baza";
}

function curl_post($url, array $post, array $options = array()) 
{ 
    $defaults = array( 
        CURLOPT_POST => 1, 
        CURLOPT_HEADER => 0, 
        CURLOPT_URL => $url, 
        CURLOPT_FRESH_CONNECT => 1, 
        CURLOPT_RETURNTRANSFER => 1, 
        CURLOPT_FORBID_REUSE => 1, 
        CURLOPT_TIMEOUT => 4, 
        CURLOPT_POSTFIELDS => http_build_query($post) 
    ); 

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
    if( !$result = curl_exec($ch)) 
    { 
        trigger_error(curl_error($ch)); 
    } 
    curl_close($ch);
    return $result;
}

$url = 'api.api.pl/check_license.php';
$post = [
    'license' => $licence,
    'nip' => $nip
];
$curl = curl_post($url, $post);
if($curl === '0'){
    if($_SERVER['REDIRECT_URL']!== '/licencja/blad'){
    Header("Location: /licencja/blad");
    exit();
    }
}
elseif($curl !== '1'){
    if($_SERVER['REDIRECT_URL']!== "/licencja/wygasla/{$curl}"){
    Header("Location: /licencja/wygasla/{$curl}");
    exit();
}}
else{
    if(!empty($_SESSION['id'])){
        if($_SERVER['REDIRECT_URL'] === '/login'){
            Header('Location: /');
            exit();
        }
    }
if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{
    if(substr($_GET['url'],-4,1)!=='.')
    {
       $_SESSION['url']=$_GET['url']; 
    }
    if($_SESSION['status']===2)
    {
        if($_SERVER['REDIRECT_URL']!== '/konto-nieaktywne'){
        header('Location: /konto-nieaktywne');
        exit();
    }
    }
   
}

else{
    if($_SERVER['REDIRECT_URL']!== '/login' && substr($_SERVER['REDIRECT_URL'],0,6)!== '/reset'){
        header('Location: /login');
        exit();
    }
}}
?>

       <?php $app=new App();?>



