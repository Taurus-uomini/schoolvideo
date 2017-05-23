<?php

use think\Session;
use think\Db;

function login_getcookie($url, $cookie) 
{ 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);  
    curl_exec($curl); 
    curl_close($curl); 
} 

function login_getverifyCode($url, $verifyCodefile ,$cookie) 
{ 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $img = curl_exec($curl);
    curl_close($curl);
    file_put_contents($verifyCodefile,$img);
} 

function login_post($url, $cookie, $post) 
{ 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);  
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_exec($curl); 
    curl_close($curl); 
} 

function get_content($url, $cookie) 
{ 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    $rs = curl_exec($ch); 
    curl_close($ch); 
    return $rs; 
} 

function get_syllabus($url, $cookie, $post)
{
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $rs = curl_exec($ch); 
    curl_close($ch); 
    return $rs; 
}
function getUserInfo()
{
    $uid=Session::get('uid');
    $UserInfo=Db::table('users')->alias('u')->join('cmis cm','u.cmid=cm.cmid')->join('specialty sp','cm.spid=sp.spid')->join('faculty f','sp.fid=f.fid')->where('uid',$uid)->find();
    $UserInfo['id_card']='**************';
    $UserInfo['birthday']='**************';
    $UserInfo['political_status']='**************';
    $UserInfo['nation']='**************';
    $UserInfo['test_number']='**************';
    return $UserInfo;
}

function getUser_selective_course()
{
    $UserInfo=getUserInfo();
    $id=$UserInfo['id'];
    $selective_courseinfo=Db::table('selective_course')->where('id',$id)->select();
    $selective_course=null;
    $i=0;
    if($selective_courseinfo!=null)
    {
        foreach ($selective_courseinfo as $key => $value) 
        {
            $selective_course[$i]['cid']=$value['cid'];
            $selective_course[$i++]['schedule']=$value['schedule'];
        }
    }
    return $selective_course;
}

function getClientIP()  
{  
    $ip=null;  
    if (getenv("HTTP_CLIENT_IP"))  
        $ip = getenv("HTTP_CLIENT_IP");  
    else if(getenv("HTTP_X_FORWARDED_FOR"))  
        $ip = getenv("HTTP_X_FORWARDED_FOR");  
    else if(getenv("REMOTE_ADDR"))  
        $ip = getenv("REMOTE_ADDR");  
    else $ip = "Unknow";  
    return $ip;  
}  

function create_live_channel($name)
{
    $appkey="11bc95fc21e5484cae8e32a8de6c5820";
    $appsecret="dfdd5703c618462cad2ef6eafcb8a3c0";
    $nonce=strval(rand(2000,10000));
    $curtime=time();
    $checksum=sha1($appsecret.$nonce.$curtime);
    $url="https://vcloud.163.com/app/channel/create";
    $header=array
    (
        "AppKey:".$appkey,
        "Nonce:".$nonce,
        "CurTime:".$curtime,
        "CheckSum:".$checksum,
        "Content-type:application/json;charset=utf-8"
    );
    $post="{'name':".$name.",'type':1}";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $rs = curl_exec($ch); 
    curl_close($ch); 
    return $rs;
}
?>