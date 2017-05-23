$(document).ready(function()
{
    add_coursediv(-1);
    $(this).ajaxStart(function()
    {
        $('.update_wait').css('display','block');
    });
    $('#course_imgsrc').click(function()
    {
        $("#course_img").trigger("click");
    });
    $('#btn_addcourse').click(function()
    {
        var course_name=$('#course_name').val();
        $.post("ajax_addcourse", 
        { 
            "course_name":course_name
        },
        function(data)
        {
            $('.update_wait').css('display','none');
            if(data.ret!=-1)
            {
                alert("添加成功！");
                add_coursediv(-1);
                $("#btn_addcourse_close").trigger("click");
                edit_course(null,data.cid);
            }
            else
            {
                alert("添加失败！");
            }
        }, "json");
    });
    $("#course_img").change(function()
	{
		var file=$(this);
		var fileObj=file[0];
		var windowURL=window.URL||window.webkitURL;
		var dataURL;
		var img=$("#course_imgsrc");
		if(fileObj&&fileObj.files&&fileObj.files[0])
		{	
			dataURL=windowURL.createObjectURL(fileObj.files[0]);
			img.attr('src',dataURL);	
		}
		else
		{
			alert("图片获取错误！");
		}
	});
    $('#btn_editcourse').click(function()
    {
        var course_cid=$('#course_cid').val();
        var course_cdid=$('#course_cdid').val();
        var course_introduce=$('#course_introduce').val();
        if(course_introduce.length>200)
        {
            alert("介绍字数太多！");
            return 0;
        }
        $.ajaxFileUpload
        ({
        	url: 'ajax_editcourse', 
         type: 'post',
         data: { cid: course_cid,cdid: course_cdid,introduce: course_introduce }, 
         secureuri: false, 
         fileElementId: 'course_img', 
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
                $('#course_info').append("<div id='cinfo"+element.cid+"' class='col-xs-6 col-md-3'><div class='thumbnail'><a href='course_detail?cid="+element.cid+"'><img src='"+element.img+"' style='width:300px;height:200px;'  alt='image'></a><div class='caption'><h4>"+element.name+"</h4><small style='color:darkgray;font-size:xx-small;'>"+element.createtime+"<small><p id='introduce'>"+element.introduce+"</p><p><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editcourse' onclick='edit_course(this,null);' data='"+element.cid+"' role='button'>编辑</button> <button type='button' onclick='delete_course(this);' class='btn btn-default' data='"+element.cid+"' role='button'>删除</button></p></div></div>");
            }, this);
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}
function delete_course(that)
{
    var cid=$(that).attr('data');
    $.post("ajax_deletecourse", 
    { 
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret>0)
        {
            alert("删除成功！");
            add_coursediv(-1);
        }
        else
        {
            alert("删除失败！");
        }
    }, "json");
}
function edit_course(that,cid)
{
    if(cid==null)
    {
        cid=$(that).attr('data');
    }
    else
    {
        $('#editcourse').modal('show');
    }
    $.post("ajax_searchcourse", 
    { 
        "cid":cid
    },
    function(data)
    {
        $('.update_wait').css('display','none');
        if(data.ret!=-1)
        {
            $('#edit_course_name').val(data.courseinfo.name);
            $('#course_cid').val(data.courseinfo.cid);
            $('#course_cdid').val(data.courseinfo.cdid);
            if(data.courseinfo.img==null||data.courseinfo.img=='')
            {
                    data.courseinfo.img="/public/img/tp.jpg";
            }
            $('#course_imgsrc').attr('src',data.courseinfo.img);
            if(data.courseinfo.introduce!=null)
            {
                $('#course_introduce').html(data.courseinfo.introduce);
            }      
        }
        else
        {
            alert("未知错误！");
        }
    }, "json");
}