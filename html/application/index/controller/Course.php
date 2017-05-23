<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Config;
use think\Db;

class Course extends Controller
{
    public function _initialize()
    {
        if(!Session::has('uid'))
        {
            Session::set('want_go',$_SERVER['REQUEST_URI']);
            $this->redirect("Login/login");
        }
        Config::load(APP_PATH.'menu.php');
    }
    public function show()
    {
        $cid=input('get.cid');
        $userInfo=getUserInfo();
        $this->assign('userInfo',$userInfo);
        $this->assign('cid',$cid);
        return $this->fetch('show');
    }

    public function ajax_searchcourse()
    {
        $user_selective_course=getUser_selective_course();
        $cid=input('post.cid');
        $courseinfo=null;
        if($cid==-1)
        {
           $courseinfo=Db::table('course_detail')->alias('cd')->join('course c','c.cid=cd.cid','RIGHT')->select();
        }
        else
        {
            $courseinfo=Db::table('course')->where('cid',$cid)->find();
            $cdetilinfo=Db::table('course_detail')->where('cid',$cid)->find();
            if($cdetilinfo==null)
            {
                $cdetilinfo['img']="/public/img/tp.jpg";
                $cdetilinfo['introduce']="";
                $cdetilinfo['cdid']=-1;
            }
            $courseinfo['img']=$cdetilinfo['img'];
            $courseinfo['introduce']=$cdetilinfo['introduce'];
            $courseinfo['cdid']=$cdetilinfo['cdid'];
        }
        return json(['ret'=>1,'courseinfo'=>$courseinfo,'user_selective_course'=>$user_selective_course]);
    }

    public function ajax_searchvideo()
    {
        $user_selective_course=getUser_selective_course();
        $cid=input('post.cid');
        $vid=input('post.vid');
        $videoinfo=null;
        $videoinfos=Db::table('video')->where('cid',$cid)->select();
        if($vid!=-1)
        {
            $videoinfo=Db::table('video')->where('cid',$cid)->where('vid',$vid)->find();
            $i=1;
            foreach ($videoinfos as $key => $value) 
            {
                if($value['vid']==$videoinfo['vid'])
                {
                    $videoinfo['num']=$i;
                    break;
                }
                ++$i;
            }
            foreach ($user_selective_course as $key => $value) 
            {
                if($value['cid']==$videoinfo['cid'])
                {
                    $videoinfo['schedule']=intval($value['schedule']);
                    break;
                }
            }
            return json(['ret'=>1,'videoinfo'=>$videoinfo]);
        }
        else
        {
            return json(['ret'=>1,'videoinfo'=>$videoinfos]);
        }
    }

    public function watch_video()
    {
        $cid=input('get.cid');
        $vid=input('get.vid');
        $userInfo=getUserInfo();
        $this->assign('userInfo',$userInfo);
        $this->assign('cid',$cid);
        $this->assign('vid',$vid);
        return $this->fetch('watch_video');
    }

    public function ajax_finishvideo()
    {
        $userInfo=getUserInfo();
        $cid=input('post.cid');
        $ret=Db::table('selective_course')->where('cid',$cid)->where('id',$userInfo['id'])->setInc('schedule');
        return json(['ret'=>$ret]);
    }

    public function ajax_getquestion()
    {
        $vid=input('post.vid');
        $questioninfos=null;
        $questioninfos=Db::table('question')->where('vid',$vid)->where('used',1)->select();
        foreach ($questioninfos as $key => $questioninfo) 
        {
            $questioninfos[$key]['optioninfos']=Db::table('option')->where('qid',$questioninfo['qid'])->select();
        }
        return json(['ret'=>1,'questioninfo'=>$questioninfos==null?null:$questioninfos]);
    }
}