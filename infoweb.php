<?php


$blue = "\e[34m";
$lblue = "\e[36m";
$red = "\e[31m";
$green = "\e[92m";
$fgreen = "\e[32m";
$yellow = "\e[1;33m";
$bold = "\e[1m";
echo $red."";
system(" toilet INFO WEB");
system("sh logo.sh ");
$ip = readline("\e[1;33m"."WEBSITE WITHOUT (https://www.):");

//IP of site
echo $yellow."";
system(" toilet IP Info");
//IP Of Site
  $wip = gethostbyname($ip);
echo"\n$green"."[+] IP Of Website: ";
echo "$yellow";
echo $wip ."";

//check cloudflare protection

  echo"\n$blue"."[+] Cloudflare Protection: ";
  $urlhh= "http://api.hackertarget.com/httpheaders/?q=". $ip;
  $resulthh = file_get_contents ($urlhh);
  if (strpos($resulthh,'cloudflare') !== false){
    echo "\e[32mDetected\n\e[0m";
  }
  else {
    echo "\e[31mNot Detected\n\e[0m";
  }

//Check Robot Catcher

  echo"$blue"."[+] Robots Catcher: ";
  $rbturl =$ip."/robots.txt";
  $rbthandle = curl_init($rbturl);
  curl_setopt($rbthandle, CURLOPT_RETURNTRANSFER, TRUE);
  $rbtresponse = curl_exec($rbthandle);
  $rbthttpCode = curl_getinfo($rbthandle, CURLINFO_HTTP_CODE);
  if($rbthttpCode == 200) {
    $rbtcontent = file_get_contents($rbturl);
    if ($rbtcontent == ""){
      echo "Found But Empty!";
    }
    else{
      echo $green."Found A Catcher";
      echo $blue ."{}{}{}{}{}{Codes}{}{}{}{}{}";
      echo $rbtcontent;
      echo "{}{}{}{}{}{That's All}{}{}{}{}{}";
    }
  }
  else
  {
      echo $green."No Robot Catcher!";
    }

echo "";
//Start Of Info Scan

//Whois Scan
echo $yellow."";
system(" toilet whois ");
    $urlwhois= "http://api.hackertarget.com/whois/?q=". $ip;
    $resultwhois = file_get_contents ($urlwhois);
    echo$yellow."";
    echo $resultwhois ;
echo "";
//Geo IP Scan

system(" toilet GOE IP ");
    $urlgip= "http://api.hackertarget.com/geoip/?q=". $ip;
    $resultgip = file_get_contents ($urlgip);
echo $red."";    
echo $resultgip ;
echo "";

//HTTP HEADER
 
system(" toilet HTTP ");
    echo"\n\n$green";
    echo $resulthh ;
echo "";

//Scan DNS INFO

system("toilet DNS INFO ");
    echo $yellow."";
    $urldlup= "http://api.hackertarget.com/dnslookup/?q=". $ip;
    $resultdlup = file_get_contents ($urldlup);
    echo $resultdlup ;
echo "";

//Calculate SUBNET

system(" toilet Subnet ");
echo $blue."";
    $urlscal= "http://api.hackertarget.com/subnetcalc/?q=". $ip;
    $resultscal = file_get_contents ($urlscal);
    echo $resultscal ;
echo "";

//Nmap Port Scan

system(" toilet Nmap ");
    echo"\n\n$green";
    $urlnmap= "http://api.hackertarget.com/nmap/?q=". $ip;
    $resultnmap = file_get_contents ($urlnmap);
    echo $resultnmap ;
echo "";

//Sub Domains Scan

system(" toilet Sub Domains ");
  $urlsd= "http://api.hackertarget.com/hostsearch/?q=". $ip;
  $resultsd = file_get_contents ($urlsd);
  $subdomains = explode("\n", $resultsd);
  $sdcount = count($subdomains);
  $sdcount = $sdcount - 1;
  echo "\n$blue"."[i] Total Subdomains Found :$cln ".$green .$sdcount."\n\n$cln";
  foreach ($subdomains as $subdomain) {
    //echo ;
    echo "[+] Subdomain:$cln $fgreen".(str_replace(",","\n\e[0m[-] IP:$cln $fgreen",$subdomain));
    echo "\n\n$cln";
  }
  echo "\n\n";

//Sql Vul Scanner

echo "\n\n";
system("sh sql.sh");

  $pre = "http://www.";
  $lulzurl =$pre.$ip;
  $html = file_get_contents($lulzurl);
  $dom = new DOMDocument;
  @$dom->loadHTML($html);
  $links = $dom->getElementsByTagName('a');
  $vlnk = 0;
  foreach ($links as $link){
    $lol= $link->getAttribute('href');
    if( strpos( $lol, '?' ) !== false ){
      echo"\n$green [#] ".$yellow .$lol ."\n$cln";
      echo$red." [-] Searching For SQL Errors: ";
      $sqllist = file_get_contents('sqlerror.h');
      $sqlist = explode(',', $sqllist);
      if (strpos($lol, '://') !== false){
        $sqlurl = $lol ."'";
      }
      else{
        $sqlurl = $ipsl.$ip."/".$lol."'";
      }
      $sqlsc = file_get_contents($sqlurl);
      $sqlvn = "$green Not Found";
      foreach($sqlist as $sqli){
        if (strpos($sqlsc, $sqli) !== false) $sqlvn ="$red Found!";
      }
      echo $sqlvn;
      echo"\n$cln";
      echo "\n";
      $vlnk++ ;
    }
  }
  echo"\n\n$blue [+] URL(s) With Parameter(s):".$green.$vlnk;
  echo"\n\n";

?>
