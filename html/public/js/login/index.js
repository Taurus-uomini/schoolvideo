$(document).ready(function()
{
    $.post("getverifyCode", 
    { 

    },
    function(data)
    {
        if(data.ret==1)
        {
            $('#imgyzm').attr('src',"/public/"+data.imgsrc);
            $('#imgsrc').val(data.imgsrc);
            // $('#imgyzm').css('display','none');
            // $('#yzm').css('display','none');
            // $('#yzm').val("none");
        }
        else
        {
            alert("fail");
        }
    }, "json");
    $(this).ajaxStart(function()
    {
        $('.login_wait').css('display','block');
    });
    $('#btn_dl').click(function()
    {
        var uid=$('#uid').val();
        var password=$('#password').val();
        var yzm=$('#yzm').val();
        var imgsrc=$('#imgsrc').val();
        $.post("ajax_login", 
        { 
            "uid": uid,
            "password": password,
            "yzm": yzm,
            "imgsrc": imgsrc
        },
        function(data)
        {
            $('.login_wait').css('display','none');
            if(data.ret==1)
            {
                alert("登陆成功");
                window.location.href=data.want_go;
            }
            else
            {
                if(data.ret==-1)
                {
                    // alert("密码错误");
                    $('#imgyzm').css('display','inline-block');
                    $('#yzm').css('display','inline-block');
                    $('#yzm').val("");
                    alert("请输入验证码");
                }
                else if(data.ret==-2)
                {
                    $('#imgyzm').css('display','inline-block');
                    $('#yzm').css('display','inline-block');
                    $('#yzm').val("");
                    alert("请输入验证码");
                }
                else if(data.ret==0)
                {
                    alert("登陆失败");
                    $.post("getverifyCode", 
                    { 

                    },
                    function(data)
                    {
                        if(data.ret==1)
                        {
                            $('#imgyzm').attr('src',"/public/"+data.imgsrc);
                            $('#imgsrc').val(data.imgsrc);
                        }
                        else
                        {
                            alert("fail");
                        }
                    }, "json");
                }
            }
        }, "json");
    });
});