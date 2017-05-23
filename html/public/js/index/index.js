function onmover(that)
{
	that.getElementsByTagName('ul')[0].style.display="block";
}
function onmout(that)
{
	that.getElementsByTagName('ul')[0].style.display="none";
}
$(document).ready(function()
{
	add_coursediv(-1);
});
function add_coursediv(cid)
{
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
            $('#course_info').empty();
            var count=0;
            courseinfo.forEach(function(element) 
            {
                if(element.img==null||element.img=='')
                {
                    element.img="/public/img/tp.jpg";
                }
                if(element.introduce==null)
                {
                    element.introduce="暂无介绍";
                }
                if(count<4)
                {
                    $("#new_course_list").append("<a href='/public/index.php/index/course/show?cid="+element.cid+"' class='list-group-item'><h4 class='list-group-item-heading'>"+element.name+"</h4><small style='color:darkgray;font-size:xx-small;'>"+element.createtime+"<small><p class='list-group-item-text' style='overflow: hidden;text-overflow: ellipsis;'>"+element.introduce+"</p></a>");
                    count++;
                }
				var has=false;
				if(user_selective_course!=null)
				{
					user_selective_course.forEach(function(e)
					{
						if(e.cid==element.cid)
						{
							has=true;
						}
					}, this);
				}
				if(has)
				{
					$('#course_info').append("<div id='cinfo"+element.cid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><img src='"+element.img+"' style='width:300px;height:200px;' alt='image'><div class='caption'><h4>"+element.name+"</h4><small style='color:darkgray;font-size:xx-small;'>"+element.createtime+"<small><p id='introduce'>"+element.introduce+"</p><p><button type='button' class='btn btn-primary' onclick='show_course(this);' data='"+element.cid+"' role='button'>详情</button> </p></div></div>");
				}
                else
				{
					$('#course_info').append("<div id='cinfo"+element.cid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><img src='"+element.img+"' style='width:300px;height:200px;'  alt='image'><div class='caption'><h4>"+element.name+"</h4><small style='color:darkgray;font-size:xx-small;'>"+element.createtime+"<small><p id='introduce'>"+element.introduce+"</p><p><button type='button' class='btn btn-primary' onclick='show_course(this);' data='"+element.cid+"' role='button'>详情</button> <button type='button' onclick='addto_mycourse(this);' class='btn btn-default' data='"+element.cid+"' role='button'>加入我的课程</button></p></div></div>");
				}
            }, this);
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
    $.post("ajax_addto_mycourse", 
    { 
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret>0)
        {
            alert("加入成功！");
            add_coursediv(-1);
        }
        else
        {
            alert("加入失败！");
        }
    }, "json");
}
function show_course(that)
{
	var cid=$(that).attr('data');
	window.location.href="/public/index.php/index/course/show?cid="+cid;
}