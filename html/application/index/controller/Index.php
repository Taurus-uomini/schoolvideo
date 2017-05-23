<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;

class Index extends Controller
{
    public function _initialize()
    {
        if(!Session::has('uid'))
        {
            Session::set('want_go',$_SERVER['REQUEST_URI']);
            $this->redirect("Login/login");
        }
    }
    public function index()
    {
        $userInfo=getUserInfo();
        $this->assign('userInfo',$userInfo);
        return $this->fetch('index');
    }

    public function ajax_searchcourse()
    {
        $user_selective_course=getUser_selective_course();
        $cid=input('post.cid');
        $courseinfo=null;
        if($cid==-1)
        {
           $courseinfo=Db::table('course_detail')->alias('cd')->join('course c','c.cid=cd.cid','RIGHT')->order('createtime desc')->select();
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

    public function ajax_addto_mycourse()
    {
        $cid=input('post.cid');
        $userInfo=getUserInfo();
        $user_selective_course=getUser_selective_course();
        if($user_selective_course!=null)
        {
            foreach ($user_selective_course as $key => $value) 
            {
                if($value==$cid)
                {
                    return json(['ret'=>-1]);
                }
            }
        }
        $selective_course['id']=$userInfo['id'];
        $selective_course['cid']=$cid;
        $selective_course['schedule']=0;
        Db::table('selective_course')->insert($selective_course);
        return json(['ret'=>1]);
    }
}
