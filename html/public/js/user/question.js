var qvid=-1;
var qcid=-1;
var radios=Array();
var checkboxs=Array();
$(document).ready(function()
{
    $(this).ajaxStart(function()
    {
        $('.update_wait').css('display','block');
    });
    function getoo()
    {
        var oo=new Object;
        oo.title="";
        oo.op=Array();
        return oo;
    }
    function getoop()
    {
        var oop=new Object;
        oop.title="";
        oop.check=false;
        return oop;
    }
    $("#question_check").click(function()
    {
        var source=$("#target").find(".control-group.component");
        var i=0;
        var j=0;
        source.each(function(index,element)
        {
            if($(element).find(":checkbox").length>0)
            {
                checkboxs[i]=getoo();
                checkboxs[i].title=$(element).find("label.control-label.leipiplugins-orgname").text();
                var k=0;
                $(element).find("label.checkbox").each(function(ind,e)
                {
                    checkboxs[i].op[k]=getoop();
                    checkboxs[i].op[k++].title=$(e).text();
                });
                ++i;
            }
            else
            {
                radios[j]=getoo();
                radios[j].title=$(element).find("label.control-label.leipiplugins-orgname").text();
                var k=0;
                $(element).find("label.radio").each(function(ind,e)
                {
                    radios[j].op[k]=getoop();
                    radios[j].op[k++].title=$(e).text();
                });
                ++j;
            }
        });
        var question_div=$("#question_div");
        question_div.empty();
        $(checkboxs).each(function(index,element)
        {
            question_div.append("<div class='control-group component'><label class='control-label leipiplugins-orgname'>"+element.title+"</label><div class='controls leipiplugins-orgvalue' id='optionc"+index+"'></div></div>");
            var option=element.op;
            var option_div=$("#optionc"+index);
            $(option).each(function(ind,e)
            {
                option_div.append("<label class='checkbox'><input type='checkbox' onclick='cbchecked(this);' data-q='"+index+"' data-o='"+ind+"' name='optionc"+index+"ckb' value='"+ind+"' class='leipiplugins'>"+e.title+"</label>");
            });
        });
        $(radios).each(function(index,element)
        {
            question_div.append("<div class='control-group component'><label class='control-label leipiplugins-orgname'>"+element.title+"</label><div class='controls leipiplugins-orgvalue' id='optionr"+index+"'></div></div>");
            var option=element.op;
            var option_div=$("#optionr"+index);
            $(option).each(function(ind,e)
            {
                option_div.append("<label class='radio'><input type='radio' onclick='rdchecked(this);' data-q='"+index+"' data-o='"+ind+"' name='optionr"+index+"radio' value='"+ind+"' class='leipiplugins'>"+e.title+"</label>");
            });
        });
        $("#question_set").modal('show');
    });
    $("#btn_question_set").click(function()
    {
        $.post("ajax_addquestion", 
        {
            "vid":qvid, 
            "checkboxs":checkboxs,
            "radios":radios
        },
        function(data)
        {
            $('.update_wait').css('display','none');
            if(data.ret!=-1)
            {
                location.href="course_detail?cid="+qcid;
            }
            else
            {
                alert("未知错误！");
            }
        }, "json");
    });
});
function cbchecked(that)
{
    var q=$(that).attr("data-q");
    var o=$(that).attr("data-o");
    checkboxs[q].op[o].check=checkboxs[q].op[o].check?false:true;
}
function rdchecked(that)
{
    var q=$(that).attr("data-q");
    var o=$(that).attr("data-o");
    $(radios[q].op).each(function(index,element)
    {
        radios[q].op[index].check=false;
    });
    radios[q].op[o].check=radios[q].op[o].check?false:true;
}
function load(vid,cid)
{
    qvid=vid;
    qcid=cid;
    $.post("ajax_searchvideo", 
    { 
        "vid":vid,
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            var videoinfo=data.videoinfo;
            $('.media-left .media-object').attr('src',videoinfo.img);
            $('.media-body .media-heading').text(videoinfo.name);
            $('.media-body p').text(videoinfo.introduce);
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}