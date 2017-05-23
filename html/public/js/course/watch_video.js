var qcid=-1;
var qvid=-1;
var courseinfo=null;
var videoinfo=null;
var questioninfo=null;
$(document).ready(function()
{
    $("#jquery_jplayer_1").jPlayer({
	    swfPath: "js",
	    supplied: "m4v",
	    size: {
	        width: "570px",
	        height: "340px",
	        cssClass: "jp-video-360p"
	    }
	});
    $(".jp-video-360p").css('display','block');
    $("#btn_question_ans").click(function()
    {
        $(".wrong").remove();
        $(questioninfo).each(function(index,element)
        {
            var option=element.optioninfos;
            var option_div=$("#option"+element.qid);
            var istrue=true;
            $(option).each(function(ind,e)
            {
                if($("#option"+e.oid).is(":checked"))
                {
                    if(e.choice=="0")
                    {
                        istrue=false;
                    }
                }
                else
                {
                    if(e.choice=="1")
                    {
                        istrue=false;
                    }
                }
            });
            if(istrue==false)
            {
                option_div.before("<h5 class='wrong' style='color:red;display:inline;margin-left:10px;'>X</h5>");
            }
        });
    });
});
function load(cid,vid)
{
    qcid=cid;
    qvid=vid;
    $.post("ajax_searchcourse", 
    { 
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            courseinfo=data.courseinfo;
            get_videoinfo();
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function get_videoinfo()
{
    $.post("ajax_searchvideo", 
    { 
        "cid":qcid,
        "vid":qvid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            videoinfo=data.videoinfo;
            $('.panel-heading .panel-title').html(courseinfo.name+" <small style='color:darkgray;'>"+videoinfo.name+"</small>");
            $("#jquery_jplayer_1").jPlayer( "clearMedia" );
	        $("#jquery_jplayer_1").jPlayer("setMedia", {
	                m4v: videoinfo.url,
                    poster: videoinfo.img
	        });
            $("#jquery_jplayer_1").bind($.jPlayer.event.ended + ".jp-repeat", function(event) 
            {
                if(videoinfo['num']>videoinfo['schedule'])
                {
                    $.post("ajax_finishvideo", 
                    { 
                        "cid":qcid
                    },
                    function(data)
                    {
                        $('.update_wait').css('display','none');
                        if(data.ret!=-1)
                        {
                            alert("观看结束！");
                        }
                        else    
                        {
                            alert("未知错误！");
                        }
                    }, "json");
                }
                $.post("ajax_getquestion", 
                { 
                    "vid":qvid
                },
                function(data)
                {
                    $('.update_wait').css('display','none');
                    if(data.ret!=-1)
                    {
                        questioninfo=data.questioninfo;
                        if(questioninfo!=null)
                        {
                            var question_div=$("#question_div");
                            question_div.empty();
                            $(questioninfo).each(function(index,element)
                            {
                                question_div.append("<div class='control-group component'><label class='control-label leipiplugins-orgname'>"+element.question+"</label><div class='controls leipiplugins-orgvalue' id='option"+element.qid+"'></div></div>");
                                var option=element.optioninfos;
                                var option_div=$("#option"+element.qid);
                                $(option).each(function(ind,e)
                                {
                                    if(element.type==1)
                                    {
                                        option_div.append("<label class='checkbox'><input type='checkbox' onclick='cbchecked(this);' id='option"+e.oid+"' name='optionc"+index+"ckb' value='"+ind+"' class='leipiplugins'>"+(ind+1)+"."+e.option+"</label>");
                                    }
                                    else
                                    {
                                        option_div.append("<label class='radio'><input type='radio' onclick='rdchecked(this);' id='option"+e.oid+"' name='optionr"+index+"radio' value='"+ind+"' class='leipiplugins'>"+(ind+1)+"."+e.option+"</label>");
                                    }       
                                });
                            });
                            $("#question_ans").modal('show');
                        }   
                    }
                    else
                    {
                        alert("未知错误！");
                    }
                }, "json");
            });
            if(videoinfo['num']>videoinfo['schedule'])
            {
                $(".jp-seek-bar").unbind("click.jPlayer");
	            $(".jp-play-bar").unbind("click.jPlayer");  
            }
            else
            {
                $('.panel-heading .panel-title').append("(已完成)");
            }
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function cbchecked(that)
{
    
}
function rdchecked(that)
{
    
}