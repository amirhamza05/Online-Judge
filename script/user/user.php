<?php
class User {
   
//starting connection
 public function __construct(){
     
     $this->DB=new Database();
     $this->conn=$this->DB->conn;
 }
 
 public function getUserInfo(){

 	  $sql="select * from users";
 	$data=$this->DB->getData($sql);
 	print_r($data);
 }

 public function getSingleUserInfo($userId){
 	$sql="select * from users where userId=$userId";
 	$data=$this->DB->getData($sql);
 	return $data;
 }

 public function updateProfileInfo($data){
 	if(!$this->DB->isLoggedIn)return;
 	$data['userId']=$this->DB->isLoggedIn;
 	$this->DB->pushData("users","update",$data);
 }

 public function getPageViewList(){
  $sql="select * from page_view ORDER BY pageViewId DESC limit 15";
  $data=$this->DB->getData($sql);
  return $data;
 }

 public function updateUserStatus($info){
 	$userStatusInfo=array();
 	$userStatusInfo=$this->getUserStatus();

 	$viewPageData=array();
 	$viewPageData['userId']=$this->DB->isLoggedIn;
 	$viewPageData['userIp']=$userStatusInfo['ip'];
 	$viewPageData['userBrowserName']=$userStatusInfo['browserName'];
 	$viewPageData['userBrowserVersion']=$userStatusInfo['browserVersion'];
 	$viewPageData['userPlatform']=$userStatusInfo['platform'];
 	$viewPageData['userAgent']=$userStatusInfo['userAgent'];
 	$viewPageData['visitTime']=$userStatusInfo['time'];
 	$viewPageData['visitPageUrl']=$info['url'];
 	if($info['insertPageViewData']){
 		$this->DB->pushData("page_view","insert",$viewPageData);
 	}

 	if(!$this->DB->isLoggedIn)return;
 	
 	$data=array();
 	$data['lastLoginIp']=$userStatusInfo['ip'];
 	$data['lastLoginTime']=$userStatusInfo['time'];
 	$data['userId']=$this->DB->isLoggedIn;
 	$data['lastLoginUrl']=$info['url'];
 	$data['lastLoginBrowser']=$userStatusInfo['browserName'];
 	//print_r($data);
 	$this->DB->pushData("users","update",$data);
 }

 public function getUserStatus(){
 	$info=array();
 	
 	if (!empty($_SERVER['HTTP_CLIENT_IP']))   
    	$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
    	$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
    	$ip_address = $_SERVER['REMOTE_ADDR'];

    $browserInfo=$this->getBrowser();

 	$info['ip']=$ip_address;
 	$info['browserName']=$browserInfo['name'];
 	$info['browserVersion']=$browserInfo['version'];
 	$info['platform']=$browserInfo['platform'];
 	$info['userAgent']=$browserInfo['userAgent'];
 	$info['time']=$this->DB->date();

 	return $info;
 }

 public function getBrowser() { 
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version= "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  }elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }elseif(preg_match('/Firefox/i',$u_agent)){
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  }elseif(preg_match('/OPR/i',$u_agent)){
    $bname = 'Opera';
    $ub = "Opera";
  }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Google Chrome';
    $ub = "Chrome";
  }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Apple Safari';
    $ub = "Safari";
  }elseif(preg_match('/Netscape/i',$u_agent)){
    $bname = 'Netscape';
    $ub = "Netscape";
  }elseif(preg_match('/Edge/i',$u_agent)){
    $bname = 'Edge';
    $ub = "Edge";
  }elseif(preg_match('/Trident/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }
  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
        $version= $matches['version'][0];
    }else {
        $version= $matches['version'][1];
    }
  }else {
    $version= $matches['version'][0];
  }

  // check if we have a number
  if ($version==null || $version=="") {$version="?";}

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'    => $pattern
  );
} 

}
?>