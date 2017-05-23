<?php
namespace app\index\controller;
use think\Db;
use think\Session;

class Login
{
    public function login()
    {
        return view('login');
    }
    public function logout()
    {
        $cookie=Session::get('uid').'/cookie_oschina.txt';
        @ unlink($cookie);
        Session::delete('uid');
        return view('login');
    }
    public function getverifyCode()
    {
        $ip=getClientIP();
        $url='http://cityjw.dlut.edu.cn:7001/ACTIONLOGON.APPPROCESS';
        $cookie='cookie_oschina'.md5(time().$ip).'.txt';
        Session::set('cookiefile',$cookie);
        login_getcookie($url, $cookie);
        $url='http://cityjw.dlut.edu.cn:7001/ACTIONVALIDATERANDOMPICTURE.APPPROCESS';
        $verifyCodefile='yzm/verifyCode'.md5(time().$ip).'.jpg';
        login_getverifyCode($url, $verifyCodefile ,$cookie);
        return json(['ret'=>1,'imgsrc'=>$verifyCodefile]);
        return json(['ret'=>1]);
    }
    public function ajax_login()
    {
        $uid=input('post.uid');
        $password=input('post.password');
        $yzm=input('post.yzm');
        $imgsrc=input('post.imgsrc');
        if($yzm!="none")
        {
            $post=array
            (
                'WebUserNO'=>$uid,
                'Password'=>$password,
                'Agnomen'=>$yzm
            );
            $url='http://cityjw.dlut.edu.cn:7001/ACTIONLOGON.APPPROCESS';
            $cookie=Session::get('cookiefile');
            login_post($url, $cookie, $post);
            $url='http://cityjw.dlut.edu.cn:7001/ACTIONFINDSTUDENTINFO.APPPROCESS?mode=1&showMsg=';
            $content = get_content($url, $cookie); 
            @ unlink($imgsrc);
            $content=iconv('GBK','utf-8',$content);
            preg_match_all('/<table[^>]+>(.*)<\/table>/isU',$content,$ctable);
            preg_match_all('/<td[^>]+>(.*)<\/td>/isU',$ctable[1][0],$ctd);
            $student=array();
            $infos=array
            (
                'uid'=>"学号",
                'uname'=>"姓名",
                'sex'=>"性别",
                'nation'=>"民族",
                'political_status'=>"政治面貌",
                'birthday'=>"生日",
                'id_card'=>"身份证",
                'faculty'=>"院系",
                'start_school'=>"入学年",
                'specialty'=>"专业",
                'attend_school_year'=>"修学年限",
                'class'=>"班级",
                'grade'=>"年级",
                'is_inschool'=>"在校",
                'test_number'=>"考号"
            );
            foreach ($ctd[1] as $key => $value) 
            {
                preg_match_all('/<span[^>]+>(.*)<\/span>/isU',$value,$v);
                if(isset($v[1][0]))
                {
                    foreach ($infos as $key2 => $value2) 
                    {
                        if($value2==$v[1][0])
                        {
                            $ctd[1][$key+1]=str_replace("&nbsp;","",$ctd[1][$key+1]);
                            $student[$key2]=$ctd[1][$key+1];
                            break;
                        }
                    }
                }
            }
            if($student['uid']!="")
            {
                $facultyinfo['fname']=$student['faculty'];
                $result=db('faculty')->where('fname',$facultyinfo['fname'])->find();
                if($result!=null)
                {
                    $facultyinfo['fid']=$result['fid'];
                }
                else
                {
                    $facultyinfo['fid']=db('faculty')->insertGetId($facultyinfo);
                }
                $specialtyinfo['spname']=$student['specialty'];
                $specialtyinfo['fid']=$facultyinfo['fid'];
                $result=db('specialty')->where('spname',$specialtyinfo['spname'])->where('fid',$specialtyinfo['fid'])->find();
                if($result!=null)
                {
                    $specialtyinfo['spid']=$result['spid'];
                }
                else
                {
                    $specialtyinfo['spid']=db('specialty')->insertGetId($specialtyinfo);
                }
                $cmisinfo['spid']=$specialtyinfo['spid'];
                $cmisinfo['start_school']=$student['start_school'];
                $cmisinfo['attend_school_year']=$student['attend_school_year'];
                $cmisinfo['class']=$student['class'];
                $cmisinfo['grade']=$student['grade'];
                $cmisinfo['is_inschool']=$student['is_inschool']=="是"?1:0;
                $cmisinfo['test_number']=$student['test_number'];
                $result=db('cmis')->where('spid',$cmisinfo['spid'])->where('test_number',$cmisinfo['test_number'])->find();
                if($result!=null)
                {
                    db('cmis')->where('spid',$cmisinfo['spid'])->where('test_number',$cmisinfo['test_number'])->update($cmisinfo);
                    $cmisinfo['cmid']=$result['cmid'];
                }
                else
                {
                    $cmisinfo['cmid']=db('cmis')->insertGetId($cmisinfo);
                }
                $studentinfo['uid']=$student['uid'];
                $studentinfo['password']=md5($password.$uid);
                $studentinfo['uname']=$student['uname'];
                $studentinfo['sex']=$student['sex']=='男'?0:1;
                $studentinfo['nation']=$student['nation'];
                $studentinfo['political_status']=$student['political_status'];
                $studentinfo['birthday']=$student['birthday'];
                $studentinfo['id_card']=$student['id_card'];
                $studentinfo['cmid']=$cmisinfo['cmid'];
                $result=db('users')->where('uid',$studentinfo['uid'])->find();
                if($result!=null)
                {
                    db('users')->where('uid',$studentinfo['uid'])->update($studentinfo);
                }
                else
                {
                    $studentinfo['type']=0;
                    db('users')->insert($studentinfo);
                }
                if(!file_exists($uid))
                {
                    mkdir($uid);
                }
                $filedb=file_get_contents($cookie);
                file_put_contents($uid.'/cookie_oschina.txt',$filedb);
                @ unlink($cookie);
                Session::delete('cookiefile');
                Session::set('uid',$studentinfo['uid']);
                $want_go=!Session::has('want_go')?"/public/index.php/index/index":Session::get('want_go');
                return json(['ret'=>1,'want_go'=>$want_go]);
            }
            else
            {
                return json(['ret'=>0]);
            }
        }
        else
        {
            $result=db('users')->where('uid',$uid)->find();
            if($result!=null)
            {
                if($result['password']==md5($password.$uid))
                {
                    Session::set('uid',$uid);
                    $want_go=!Session::has('want_go')?"/public/index.php/index/index":Session::get('want_go');
                    return json(['ret'=>1,'want_go'=>$want_go]);
                }
                else
                {
                    return json(['ret'=>-1]);
                }
            }
            else
            {
                return json(['ret'=>-2]);
            }
        }
    }
}
