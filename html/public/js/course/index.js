var qcid=-1;
var has=false;
var schedule=0;
function load(cid)
{
    qcid=cid;
    $.post("ajax_searchcourse", 
    { 
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            var courseinfo=data.courseinfo;
            var user_selective_course=data.user_selective_course;
            if(courseinfo.img==null||courseinfo.img=='')
            {
                courseinfo.img="/public/img/tp.jpg";
            }
            $('.media-left .media-object').attr('src',courseinfo.img);
            $('.media-body .media-heading').text(courseinfo.name);
            $('.media-body p').text(courseinfo.introduce);
			if(user_selective_course!=null)
			{
				user_selective_course.forEach(function(e)
				{
					if(e.cid==qcid)
					{
						has=true;
                        schedule=parseInt(e.schedule);
					}
				}, this);
			}
            if(!has)
            {
                $('.media-body').append("<button type='button' onclick='addto_mycourse(this);' class='btn btn-default' data='"+qcid+"' role='button'>加入我的课程</button>");
            }
            add_videodiv(qcid,-1);
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function add_videodiv(cid,vid)
{
    $.post("ajax_searchvideo", 
    { 
        "cid":cid,
        "vid":vid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            var videoinfo=data.videoinfo;
            $('#video_info').empty();
            var i=0;
            videoinfo.forEach(function(element) 
            {
                if(element.introduce==null)
                {
                    element.introduce="暂无介绍";
                }
                if(has&&i<=schedule)
                {
                    $('#video_info').append("<div id='vinfo"+element.vid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><img src='"+element.img+"' alt='image'><div class='caption'><h3>"+element.name+"</h3><p id='introduce'>"+element.introduce+"</p><p><button type='button' class='btn btn-primary' data-toggle='modal' onclick='watch_video(this);' data='"+element.vid+"' role='button'>观看</button></p></div></div>");
                }
                else
                {
                    $('#video_info').append("<div id='vinfo"+element.vid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><img src='"+element.img+"' alt='image'><div class='caption'><h3>"+element.name+"</h3><p id='introduce'>"+element.introduce+"</p><p></p></div></div>");
                }
                ++i;
            }, this);
            if(has)
            {
                var progress=schedule/i*100;
                $('.media').append("<div style='width:70%;margin: 0 auto;'>进度：<div class='progress'><div class='progress-bar' role='progressbar' aria-valuenow='"+progress+"' aria-valuemin='0' aria-valuemax='100' style='min-width: 2em;width: "+progress+"%;'>"+progress+"%</div></div></div>");
            }
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function addto_mycourse(that)
{
	var cid=$(that).attr('data');
    $.post("/public/index.php/index/index/ajax_addto_mycourse", 
    { 
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret>0)
        {
            alert("加入成功！");
            history.go(0);
        }
        else
        {
            alert("加入失败！");
        }
    }, "json");
}
function watch_video(that)
{
    var vid=$(that).attr('data');
    window.location.href="/public/index.php/index/course/watch_video?cid="+qcid+"&vid="+vid;
}