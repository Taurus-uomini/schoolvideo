<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Config;
use think\Db;

class User extends Controller
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
    public function index()
    {
        $userInfo=getUserInfo();
        $menu=config('menu');
        foreach ($menu as $key => $value) 
        {
            if($value['url']=='index')
            {
                $menu[$key]['active']=1;
            }
            if($value['type']==1&&$userInfo['type']==0)
            {
                $menu[$key]['show']=0;
            }
        }
        $this->assign('menu',$menu);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('index');
    }

    public function syllabus()
    {
        $userInfo=getUserInfo();
        $menu=config('menu');
        foreach ($menu as $key => $value) 
        {
            if($value['url']=='syllabus')
            {
                $menu[$key]['active']=1;
            }
            if($value['type']==1&&$userInfo['type']==0)
            {
                $menu[$key]['show']=0;
            }
        }
        $year=intval(date("Y"))-2010;
        $month=intval(date("m"));
        $syy=array();
        $i=0;
        $j=0;
        for($i=0,$j=0;$i<$year-1;++$i)
        {
            $syy[$j]['num']=$j+1;
            $syy[$j++]['xn']=(2010+$i).'-'.(2010+$i+1).'学年第1学期';
            $syy[$j]['num']=$j+1;
            $syy[$j++]['xn']=(2010+$i).'-'.(2010+$i+1).'学年第2学期';
        }
        $syy[$j]['num']=$j+1;
        $syy[$j++]['xn']=(2010+$i).'-'.(2010+$i+1).'学年第1学期';
        if($month<8)
        {
            $syy[$j]['num']=$j+1;
            $syy[$j++]['xn']=(2010+$i).'-'.(2010+$i+1).'学年第2学期';
        }
        $url='http://cityjw.dlut.edu.cn:7001/ACTIONQUERYSTUDENTSCHEDULEBYSELF.APPPROCESS';
        $cookie=Session::get('uid').'/cookie_oschina.txt';
        $post=array('YearTermNO'=>$j);
        $content=get_syllabus($url,$cookie,$post);
        $content=iconv('GBK','utf-8',$content);
        preg_match_all('/<table[^>]+>(.*)<\/table>/isU',$content,$ctable);
        // preg_match_all('/<td[^>]+>(.*)<\/td>/isU',$ctable[0][1],$ctd);
        // print_r($ctd);
        $tablesy=null;
        if(isset($ctable[0][1]))
        {
            $tablesy=$ctable[0][1];
        }
        else
        {
            Session::set('want_go',$_SERVER['REQUEST_URI']);
            $this->redirect("Login/logout");
        }
        $this->assign('syy',$syy);
        $this->assign('syllabus',$tablesy);
        $this->assign('menu',$menu);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('syllabus');
    }

    public function ajax_syllabus()
    {
        $year=input('post.year');
        $url='http://cityjw.dlut.edu.cn:7001/ACTIONQUERYSTUDENTSCHEDULEBYSELF.APPPROCESS';
        $cookie=Session::get('uid').'/cookie_oschina.txt';
        $post=array('YearTermNO'=>$year);
        $content=get_syllabus($url,$cookie,$post);
        $content=iconv('GBK','utf-8',$content);
        preg_match_all('/<table[^>]+>(.*)<\/table>/isU',$content,$ctable);
        $tablesy=null;
        if(isset($ctable[0][1]))
        {
            $tablesy=$ctable[0][1];
        }
        else
        {
            Session::set('want_go',$_SERVER['REQUEST_URI']);
            return -1;
        }
        return $tablesy;
    }

    public function course()
    {
        $userInfo=getUserInfo();
        $menu=config('menu');
        foreach ($menu as $key => $value) 
        {
            if($value['url']=='course')
            {
                $menu[$key]['active']=1;
            }
            if($value['type']==1&&$userInfo['type']==0)
            {
                $menu[$key]['show']=0;
            }
        }
        $this->assign('menu',$menu);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('course');
    }

    public function ajax_addcourse()
    {
       $course_name=input('post.course_name');
       $userInfo=getUserInfo();
       $courseinfo['id']=$userInfo['id'];
       $courseinfo['name']=$course_name;
       $courseinfo['createtime']=date("Y-m-d H:i:s",time());
       $courseinfo['cid']=db('course')->insertGetId($courseinfo);
       return json(['ret'=>1,'cid'=>$courseinfo['cid']]);
    }

    public function ajax_searchcourse()
    {
        $cid=input('post.cid');
        $userInfo=getUserInfo();
        $courseinfo=null;
        if($cid==-1)
        {
           $courseinfo=Db::table('course_detail')->alias('cd')->join('course c','c.cid=cd.cid','RIGHT')->where('id',$userInfo['id'])->select();
        }
        else
        {
            $courseinfo=Db::table('course')->where('id',$userInfo['id'])->where('cid',$cid)->find();
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
        return json(['ret'=>1,'courseinfo'=>$courseinfo]);
    }

    public function ajax_deletecourse()
    {
        $cid=input('post.cid');
        $userInfo=getUserInfo();
        $ret=Db::table('course')->where('id',$userInfo['id'])->where('cid',$cid)->delete();
        return json(['ret'=>$ret]);
    }

    public function ajax_editcourse()
    {
        $userInfo=getUserInfo();
        $cid=input('post.cid');
        $cdid=input('post.cdid');
        $introduce=input('post.introduce');
        $file = request()->file('course_img');
        if($file!=null)
        {
            $info = $file->move(ROOT_PATH . 'public/img/'.$userInfo['uid']);
            if($info)
            {
                $courseinfo['img']='/public/img/'.$userInfo['uid'].'/'.$info->getSaveName(); 
            }
            else
            {
                return json(['ret'=>-1]);
            }
        }
        $courseinfo['introduce']=$introduce;
        if($cdid!=-1)
        {
            Db::table('course_detail')->where('cdid',$cdid)->where('cid',$cid)->update($courseinfo);
        }
        else
        {
            $courseinfo['cid']=$cid;
            Db::table('course_detail')->insert($courseinfo);
        }
        return json(['ret'=>1]);
    }

    public function course_detail()
    {
        $userInfo=getUserInfo();
        $cid=input('get.cid');
        $menu=config('menu');
        foreach ($menu as $key => $value) 
        {
            if($value['url']=='course')
            {
                $menu[$key]['active']=1;
            }
            if($value['type']==1&&$userInfo['type']==0)
            {
                $menu[$key]['show']=0;
            }
        }
        $this->assign('menu',$menu);
        $this->assign('cid',$cid);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('course_detail');
    }
    
    public function ajax_addvideo()
    {
        $userInfo=getUserInfo();
        $cid=input('post.cid');
        $vid=input('post.vid');
        $name=input('post.video_name');
        $introduce=input('post.introduce');
        $file = request()->file('course_videofile');
        if($file!=null)
        {
            $info = $file->move(ROOT_PATH . 'public/video/'.$userInfo['uid']);
            if($info)
            {
                $videoinfo['url']='/public/video/'.$userInfo['uid'].'/'.$info->getSaveName();
                $videoinfo['img']='/public/img/video/'.md5($userInfo['uid'].time()).'.jpg';
                $command = "ffmpeg -v 0 -y -i /var/www/html".$videoinfo['url']." -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 /var/www/html".$videoinfo['img']." ";
                shell_exec( $command );
            }
            else
            {
                return json(['ret'=>-1]);
            }
        }
        $videoinfo['introduce']=$introduce;
        if($vid!=-1)
        {
            Db::table('video')->where('vid',$vid)->where('cid',$cid)->update($videoinfo);
        }
        else if($file!=null)
        {
            $videoinfo['cid']=$cid;
            $videoinfo['name']=$name;
            Db::table('video')->insert($videoinfo);
        }
        else
        {
            return json(['ret'=>-1]);
        }
        return json(['ret'=>1]);
    }

    public function ajax_searchvideo()
    {
        $cid=input('post.cid');
        $vid=input('post.vid');
        $videoinfo=null;
        if($vid==-1)
        {
           $videoinfo=Db::table('video')->where('cid',$cid)->select();
        }
        else
        {
            $videoinfo=Db::table('video')->where('cid',$cid)->where('vid',$vid)->find();
        }
        return json(['ret'=>1,'videoinfo'=>$videoinfo]);
    }

    public function ajax_deletevideo()
    {
        $cid=input('post.cid');
        $vid=input('post.vid');
        $ret=Db::table('video')->where('cid',$cid)->where('vid',$vid)->delete();
        return json(['ret'=>$ret]);
    }

    public function question()
    {
        $userInfo=getUserInfo();
        $vid=input('get.vid');
        $cid=input('get.cid');
        $menu=config('menu');
        foreach ($menu as $key => $value) 
        {
            if($value['url']=='course')
            {
                $menu[$key]['active']=1;
            }
            if($value['type']==1&&$userInfo['type']==0)
            {
                $menu[$key]['show']=0;
            }
        }
        $this->assign('menu',$menu);
        $this->assign('vid',$vid);
        $this->assign('cid',$cid);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('question');
    }

    public function ajax_addquestion()
    {
        $vid=input('post.vid');
        $checkboxs=input('post.checkboxs/a');
        $radios=input('post.radios/a');
        db('question')->where('vid',$vid)->where('used',1)->update(['used'=>0]);
        foreach ($checkboxs as $key => $value) 
        {
            unset($questioninfo);
            $questioninfo['vid']=$vid;
            $questioninfo['question']=$value['title'];
            $questioninfo['used']=1;
            $questioninfo['type']=1;
            $questioninfo['qid']=db('question')->insertGetId($questioninfo);
            foreach ($value['op'] as $k => $v) 
            {
                unset($optioninfo);
                $optioninfo['qid']=$questioninfo['qid'];
                $optioninfo['option']=$v['title'];
                $optioninfo['choice']=$v['check']=='true'?1:0;
                db('option')->insert($optioninfo);
            }
        }
        foreach ($radios as $key => $value) 
        {
            unset($questioninfo);
            $questioninfo['vid']=$vid;
            $questioninfo['question']=$value['title'];
            $questioninfo['used']=1;
            $questioninfo['type']=2;
            $questioninfo['qid']=db('question')->insertGetId($questioninfo);
            foreach ($value['op'] as $k => $v) 
            {
                unset($optioninfo);
                $optioninfo['qid']=$questioninfo['qid'];
                $optioninfo['option']=$v['title'];
                $optioninfo['choice']=$v['check']=='true'?1:0;
                db('option')->insert($optioninfo);
            }
        }
        return json(['ret'=>1]);
    }

    public function mycourse()
    {
        $userInfo=getUserInfo();
        $menu=config('menu');
        foreach ($menu as $key => $value) 
        {
            if($value['url']=='mycourse')
            {
                $menu[$key]['active']=1;
            }
            if($value['type']==1&&$userInfo['type']==0)
            {
                $menu[$key]['show']=0;
            }
        }
        $this->assign('menu',$menu);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('mycourse');
    }

    public function ajax_searchmycourse()
    {
        $userInfo=getUserInfo();
        $courseinfo=null;
        $user_selective_course=getUser_selective_course();
        $user_selective_courseid=Array();
        foreach ($user_selective_course as $key => $value) 
        {
            $user_selective_courseid[$key]=$value['cid'];
        }
        $courseinfo=Db::table('course_detail')->alias('cd')->join('course c','c.cid=cd.cid','RIGHT')->where('c.cid','in',$user_selective_courseid)->select();
        return json(['ret'=>1,'courseinfo'=>$courseinfo]);
    }
}
