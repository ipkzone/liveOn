<?php
// Author: Iddant ID
// Note: Sewaktu waktu bisa saya hapus jika ada user nakal ini hanya mengandalkan api server ya
class liveon
{
    public function __construct()
    {
    }

    public static function get_otp($nomor)
    {
        $data = file_get_contents("https://ipkzone.my.id/liveon/otp.php?nomor=" . $nomor . "");
        return $data;
    }

    public static function verify_number($auth, $otp)
    {
        $data = file_get_contents("https://ipkzone.my.id/liveon/verify.php?auth_id=" . $auth . "&_otp=" . $otp . "");
        return $data;
    }

    public static function get_profile($token)
    {
        $data = file_get_contents("https://ipkzone.my.id/liveon/profile.php?_token=" . $token . "");
        return $data;
    }

    public static function get_details($token, $service)
    {
        $data = file_get_contents("https://ipkzone.my.id/liveon/deatail.php?_token=" . $token . "&_service=" . $service . "");
        return $data;
    }

    public static function get_order($token, $service)
    {
        $data = file_get_contents("https://ipkzone.my.id/liveon/buy.php?_token=" . $token . "&_service=" . $service . "");
        return $data;
    }
}
error_reporting(0);

$Yellow = "\e[33m";
$Green = "\e[92m";
$White = "\e[0m";
$blue = "\e[34m";
$Red = "\e[31m";

$tex = "{$Yellow}➤{$White} {$Yellow}Tembak Package & Masa Aktif{$White}";
$text = "{$Green}{{$White}Author: Iddant ID{$Green}}{$White}";
echo "{$Green}
       __   _           ____     
      / /  (_)  _____  / __ \___ 
     / /__/ / |/ / -_)/ /_/ / _ \ {$Yellow}➤{$White} Author: {$Yellow}Iddant ID{$White}{$Green}
    /____/_/|___/\__(_)____/_//_/ {$Yellow}➤{$White} Tembak Package {$Yellow}v3.0{$White}
    {$White}                
\n";

echo " {$Yellow}➤{$White} Mobile: ";
$nomor = trim(fgets(STDIN));
$send = liveon::get_otp($nomor);
$json = json_decode($send, true);
$authID = $json["data"][0]["auth_id"];
$msg = $json["message"];
echo " {$Yellow}➤{$White} {$Yellow}$msg{$White}\n";

echo " {$Yellow}➤{$White} Otp: ";
$otp = trim(fgets(STDIN));
$verifyCode = liveon::verify_number($authID, $otp);
$json = json_decode($verifyCode, true);
$tokens = $json["data"][0]["auth_token"];

$profile = liveon::get_profile($tokens);
$json = json_decode($profile, true);
$service = $json["data"][0]["service"];
$account_stat = $json["data"][0]["status_account"];
$name = $json["data"][0]["nama"];
echo " {$Yellow}➤{$White} Hai, {$Yellow}$name{$White} - {$Green}$account_stat{$White}\n";

$getDetails = liveon::get_details($tokens, $service);
$json = json_decode($getDetails, true);
$masif = $json["data"][0]["info_masif"];
$exp = $json["data"][0]["info_exp"];
$quota = $json["data"][0]["info_data"];
$quota_roll = $json["data"][0]["info_roll"];

echo " {$Yellow}➤{$White} {$Yellow}$masif{$White}\n";
echo " {$Yellow}➤{$White} {$Yellow}$exp{$White}\n";
echo " +--------------------------------------------------------------+\n";
echo " {$Yellow}➤{$White} {$Yellow}$quota{$White}\n";
echo " {$Yellow}➤{$White} {$Yellow}$quota_roll{$White}\n";
echo " +--------------------------------------------------------------+\n\n";

$getBuy = liveon::get_order($tokens, $service);
$json = json_decode($getBuy, true);
$product_price = $json["data"][0]["product_price"];
$url_pay = $json["data"][0]["payment_url"];

echo " {$Yellow}➤{$White} $product_price\n";
echo " {$Yellow}➤{$White} {$Green}$url_pay{$White}\n";
