var qcid=-1;
$(document).ready(function()
{
    $(this).ajaxStart(function()
    {
        $('.update_wait').css('display','block');
    });
    $("#course_videofile").change(function()
	{
		var file=$(this);
		var fileObj=file[0];
		var windowURL=window.URL||window.webkitURL;
		var dataURL;
		if(fileObj&&fileObj.files&&fileObj.files[0])
		{	
			dataURL=windowURL.createObjectURL(fileObj.files[0]);
            $("#jquery_jplayer_1").jPlayer( "clearMedia" );
	        $("#jquery_jplayer_1").jPlayer("setMedia", {
	            m4v: dataURL,
	        });
            $(".jp-controls-holder .jp-full-screen").css('display','none');
            $("#course_videofile").css('display','none');
            $(".jp-video-360p").css('display','block');
		}
		else
		{
			alert("视频获取错误！");
		}
	});
    $('#btn_addvideo').click(function()
    {
        var cid=$('#cid').val();
        var vid=$('#vid').val();
        if(vid==''||vid==null)
        {
            vid=-1;
        }
        var video_name=$('#video_name').val();
        var video_introduce=$('#video_introduce').val();
        if(video_introduce.length>200)
        {
            alert("介绍字数太多！");
            return 0;
        }
        $.ajaxFileUpload
        ({
        	url: 'ajax_addvideo', 
         type: 'post',
         data: { cid: cid,vid: vid,video_name: video_name,introduce: video_introduce }, 
         secureuri: false, 
         fileElementId: 'course_videofile', 
         dataType: 'json', 
         success: function (data, status)  
            {
                $('.update_wait').css('display','none');
        	 	if(data.ret==1)
        	 	{
        	 		// add_coursediv(-1);
                     history.go(0);
        	 	}
        	 	else
        	 	{
        	 		alert("修改失败！");
        	 	}
            },
         error: function (data, status, e)
            {
                $('.update_wait').css('display','none');
        	 	if(data.ret==1)
        	 	{
        	 		// add_coursediv(-1);
                     history.go(0);
        	 	}
        	 	else
        	 	{
        	 		alert("修改失败！");
        	 	}
            }
        });
    });
});
function load(cid)
{
    qcid=cid;
    add_videodiv(qcid,-1);
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
            if(courseinfo.img==null||courseinfo.img=='')
            {
                courseinfo.img="/public/img/tp.jpg";
            }
            $('.media-left .media-object').attr('src',courseinfo.img);
            $('.media-body .media-heading').text(courseinfo.name);
            $('.media-body p').text(courseinfo.introduce);
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
    $("#jquery_jplayer_1").jPlayer({
	    swfPath: "js",
	    supplied: "m4v",
	    size: {
	        width: "570px",
	        height: "340px",
	        cssClass: "jp-video-360p"
	    }
	});	
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
            videoinfo.forEach(function(element) 
            {
                if(element.introduce==null)
                {
                    element.introduce="暂无介绍";
                }
                $('#video_info').append("<div id='vinfo"+element.vid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><img src='"+element.img+"' alt='image'><div class='caption'><h3>"+element.name+"</h3><p id='introduce'>"+element.introduce+"</p><p><button type='button' class='btn btn-primary' data-toggle='modal' onclick='edit_video(this);' data='"+element.vid+"' role='button'>编辑</button> <button type='button' onclick='delete_video(this);' class='btn btn-default' data='"+element.vid+"' role='button'>删除</button><a href='question?vid="+element.vid+"&cid="+qcid+"' class='btn btn-success'>题目</a></p></div></div>");
            }, this);
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function delete_video(that)
{
    var vid=$(that).attr('data');
    $.post("ajax_deletevideo", 
    { 
        "cid":qcid,
        "vid":vid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret>0)
        {
            alert("删除成功！");
            add_videodiv(qcid,-1);
        }
        else
        {
            alert("删除失败！");
        }
    }, "json");
}

function edit_video(that)
{
    var vid=$(that).attr('data');
    $('#addvideo').modal('show');
    $.post("ajax_searchvideo", 
    { 
        "cid":qcid,
        "vid":vid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            $('#video_name').val(data.videoinfo.name);
            $('#cid').val(data.videoinfo.cid);
            $('#vid').val(data.videoinfo.vid);
            $('#btn_addvideo').text("修改");
            $('#addvideoLabel').text("修改视频");
            if(data.videoinfo.introduce!=null)
            {
                $('#video_introduce').html(data.videoinfo.introduce);
            }
            $("#jquery_jplayer_1").jPlayer( "clearMedia" );
	        $("#jquery_jplayer_1").jPlayer("setMedia", {
	                m4v: data.videoinfo.url,
                    poster: data.videoinfo.img
	        });
            $(".jp-controls-holder .jp-full-screen").css('display','none');
            $("#jquery_jplayer_1").jPlayer( "load" );
            $("#course_videofile").css('display','none');
            $(".jp-video-360p").css('display','block');      
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function click_btn_addvideo()
{
    $('#btn_addvideo').text("添加");
    $('#addvideoLabel').text("添加视频");
    $("#jquery_jplayer_1").jPlayer( "clearMedia" );
    $("#course_videofile").css('display','block');
    $(".jp-video-360p").css('display','none');
    $('#video_name').val('');
    $('#cid').val(qcid);
    $('#vid').val('');
    $('#course_videofile').val('');
    $('#video_introduce').html('');
}