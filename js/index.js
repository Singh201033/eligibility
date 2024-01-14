$(document).ready(function(){

    var highest_qualification='';
    var qualification_status='';

    var name_format = /^[a-zA-Z ]*$/;

    $.notify.addStyle('notification_style', {
        html: "<div id='notification_container'><span data-notify-text/></div>",
        classes: {
          error: {
            'color': '#721c24',
            'background-color': '#f8d7da',
            'border-color': '#f5c6cb',
            'font-family': '"Poppins", sans-serif',
            'font-size': 'small',
            'padding':'0.5em 1em',
          },
          success: {
            'color': '#155724',
            'background-color': '#d4edda',
            'border-color': '#c3e6cb',
            'font-family': '"Poppins", sans-serif',
            'font-size': 'small',
            'padding':'0.5em 1em',
          }
        }
    });

    let datefield = document.getElementById('dob');

    if (datefield.type!="date")
    { //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"><\/script>\n') 
    }        
    
    if (datefield.type != "date")
    { //if browser doesn't support input type="date", initialize date picker widget:
        $(document).ready(function() {
            $('#dob').datepicker();
        }); 
    } 
    
    // Function to select gender
    $(document).on('click','#gender_item',function(){

        $(this).addClass('gender_active').siblings().removeClass('gender_active');
        
        let gen = $(this).data('id');

        $('#gender').val(gen);

    });

    $(document).on('change','#caste',function(){

        let caste = $(this).val();

        $('.stream').remove();
        $('.check_btn').remove();
        
        if(caste==='')
        {
            $('#caste').notify(
                'Please select caste',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'notification_style',
                    className:'error',
                    gap: 2
                },
            );
        }
               
    });

    $(document).on('change','#qualification',function(){

        highest_qualification = $(this).val();
       
        $('.stream, .check_btn').remove();
        
        $.ajax({
            url:'php_script/fetch_interaction.php',
            type:'POST',
            data:{highest_qualification:highest_qualification},
            success:function(data)
            {
                let response = $.parseJSON(data);

                if(response['error']!==true)
                {   
                    if(response['stream_option']!==false)
                    {
                        
                        let streams = stream_append(response['streams']);

                        let stream_display = "<div id='group' class='stream'>"+
                            "<label for=''>Stream</label>"+
                            "<select id='stream' name='stream'>"+
                                "<option value='' selected>Select Stream</option>"+streams+"</select>"+
                        "</div>";

                        $('#search').append(stream_display);
                        
                    }
                    else
                    {
                        let check_btn = "<div id='group' class='check_btn'>"+
                            "<a id='check_btn'>Check&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>"+
                        "</div>";

                        $('#search').append(check_btn);
                    }
                }
            }
        });
        

    });

    
    $(document).on('change','#stream',function(){

        let stream = $(this).val();

        $('.check_btn').remove();

        if(stream!=='')
        {
            let check_btn = "<div id='group' class='check_btn'>"+
                "<a id='check_btn'>Check&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>"+
            "</div>";

            $('#search').append(check_btn);
        }
        else
        {
            $('#stream').notify(
                'Please select stream',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'notification_style',
                    className:'error',
                    gap: 2
                },
            );
        }
    });


    $(document).on('click','#check_btn',function(){

        let user_name = $('#user_name').val();
        let dob = $('#dob').val();
        let gender = $('#gender').val();
        let caste = $('#caste').val();
        let qualification = $('#qualification').val();
        let stream = $('#stream').val();

        let check = true;

        if(user_name!=="")
        {
            if(name_format.test(user_name)===false)
            {
                let scrollDiv = $('#user_name').parent().offset().top;

                window.scrollTo({
                    top:scrollDiv-100,
                    behavior: 'smooth'
                });

                $('#user_name').notify(
                    'Enter Your Name with characters and white space only',
                    {
                        autoHide: true,
                        autoHideDelay: 3000,
                        position: 'bottom left',
                        style:'notification_style',
                        className:'error',
                    }
                );

                check =false;

                return false;
            }
        }
        else
        {
            if(user_name==="")
            {
                let scrollDiv = $('#user_name').parent().offset().top;

                window.scrollTo({
                    top:scrollDiv-100,
                    behavior: 'smooth'
                });

                $('#user_name').notify(
                    'Enter Your Name',
                    {
                        autoHide: true,
                        autoHideDelay: 3000,
                        position: 'bottom left',
                        style:'notification_style',
                        className:'error',
                    }
                );

                check =false;

                return false;
            }
        }

        if(dob==='')
        {
            $('#dob').notify(
                'Please select date of birth',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'bootstrap',
                    className:'error',
                    gap: 2
                },
            );

            check = false;

            return false;
        }

        if(gender==='')
        {
            $('#gender').notify(
                'Please select gender',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'notification_style',
                    className:'error',
                    gap: 2
                },
            );

            check = false;

            return false;
        }

        if(caste==='')
        {
            $('#caste').notify(
                'Please select caste',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'notification_style',
                    className:'error',
                    gap: 2
                },
            );

            check = false;

            return false;
        }

        if(qualification==='')
        {
            $('#qualification').notify(
                'Please select qualification',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'notification_style',
                    className:'error',
                    gap: 2
                },
            );

            check = false;

            return false;
        }

        if(stream==='')
        {
            $('#stream').notify(
                'Please select stream',
                {
                    autoHide:true,
                    autoHideDelay: 3000,
                    position:'bottom left',
                    style:'notification_style',
                    className:'error',
                    gap: 2
                },
            );

            check = false;

            return false;
        }

        if(check===true)
        {
            $('#user_name').val('');
            $('#dob').val('');
            $('#gender').val('');
            $('#caste').val('');
            $('#qualification').val('');
            $('#stream').val('');

            window.location = encodeURI("entries.php?u_name="+user_name+"&dob="+dob+"&gender="+gender+"&caste="+caste+"&qualification="+qualification+"&stream="+stream);
        }


    });

});


function stream_append(array)
{
    let stre = "";

    array.forEach(element => {

        stre+= "<option value='"+element+"'>"+element+"</option>";
    });

    return stre;
}