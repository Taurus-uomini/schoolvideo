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
    $.post("ajax_searchmycourse", 
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            var courseinfo=data.courseinfo;
            $('#course_info').empty();
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
				$('#course_info').append("<div id='cinfo"+element.cid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><img src='"+element.img+"' style='width:300px;height:200px;' alt='image'><div class='caption'><h4>"+element.name+"&nbsp;<small style='color:darkgray;font-size:xx-small;'>"+element.createtime+"<small></h4><p id='introduce'>"+element.introduce+"</p><p><button type='button' class='btn btn-primary' onclick='show_course(this);' data='"+element.cid+"' role='button'>详情</button> </p></div></div>");
            }, this);
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function show_course(that)
{
	var cid=$(that).attr('data');
	window.location.href="/public/index.php/index/course/show?cid="+cid;
}