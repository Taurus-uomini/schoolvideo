$(document).ready(function()
{
    function tablereful()
    {
        $('tr').attr('style','');
        $('td').attr('style','');
        $('td').attr('valign','');
        $('table').attr('border','');
        $('table').attr('align','');
        $('table').attr('cellpadding','');
        $('table').attr('cellspacing','');
        $('table').attr('frame','');
        $('table').addClass('table table-bordered table-hover');
    }
    tablereful();
    $(this).ajaxStart(function()
    {
        $('.search_wait').css('display','block');
    });
    $('.syy').click(function()
    {
        var year=$(this).attr('data');
        $.post("ajax_syllabus", 
        { 
            "year":year
        },
        function(data)
        {
            $('.search_wait').css('display','none');
            if(data!=-1)
            {
                $('.table').remove();  
                $('.center').append(data); 
                tablereful();
            }
            else
            {
                window.location.href="/public/index.php/index/login/logout";
            }
        });
    });
});