$(document).ready(function(){

    $('#loader').show().css('display','grid');

    var userData=[];
    var name_format = /^[a-zA-Z ]*$/;
    var mobile_format = /^\d{10}$/;

    var entry_count = [];

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


    $.ajax({
        url:'php_script/fetch_entries.php',
        type:'POST',
        data:{dob:dob,gender:gender,caste:caste,qualification:qualification,stream:stream},
        success:function(data)
        {
            let response = $.parseJSON(data);

            if(response['error']===false)
            {
                userData = response['userData'];

                let entries_count = response['entries'].length;
                let entry = '';

                if(entries_count>0)
                {
                    if(entries_count>1)
                    {
                        entry = entries_count+' entries';
                    }
                    else
                    {
                        entry = entries_count+' entry';
                    }

                    $('#head .container div').append('<p id="info">You are eligible for total '+entry+' in Indian Defence Forces</p>').hide().fadeIn();

                    response['category'].forEach(element => {

                        display_category(element);

                        entry_count[element]=0;
                    });

                    display_entries(response['entries']);

                    // used to display the count of entries in every category
                    response['category'].forEach(element => {

                        category =  element.replace(' ','_');

                        if(entry_count[element]>1)
                        {
                            entry = entry_count[element]+' entries';
                        }
                        else
                        {
                            entry = entry_count[element]+' entry';
                        }

                        $('#'+category+' .category').append('<p>'+entry+' in Indian '+element+'</p>');
                    });
                    //

                    $('#Army .container-fluid #type_list div:first').children('#entry_list').children('#entry_item:first').children('#entry_item_body').css('display','grid').siblings('#entry_item_foot').children('#enquire_btn').hide().siblings('#call').css('display','grid');

                                       
                    $('#loader').fadeOut('fast').remove();

                    $('#category_list').fadeIn('fast').css('display','grid');

                    let head_ht = $('#head').outerHeight();

                    $('.category').css('top',head_ht+'px');

                    let category_ht = $('.category').outerHeight();

                    let type_ht =  head_ht + category_ht;

                    $('.type_head').css('top',type_ht+'px');

                }
                else
                {
                    let no_entry = "<div id='no_entry'>"+
                        "<img src='images/crusier.svg' alt=''>"+
                        "<p>Oops! No entries found</p>"+
                        "<a id='search_btn'>Search Again</a>"+
                    "</div>";

                    $('#loader').fadeOut('fast').remove();

                    $('#category_list').append(no_entry);

                    $('#category_list').fadeIn('fast').css('display','grid');

                }
            }
            
        },
        error:function(e)
        {
            let no_entry = "<div id='no_entry'>"+
                "<img src='images/crusier.svg' alt=''>"+
                "<p>Oops! No entries found</p>"+
                "<a id='search_btn'>Search Again</a>"+
            "</div>";

            $('#loader').fadeOut('fast').remove();
            $('#category_list').append(no_entry);

            $('#category_list').fadeIn('fast').css('display','grid');
        }
    });

    $(window).scroll(function(){
        
        if($(window).scrollTop()>100)
        {
            if($('#info').is(':visible')==true)
            {
                $('#info').hide();

                let head_ht = $('#head').outerHeight();

                $('.category').css('top',head_ht+'px');

                let category_ht = $('.category').outerHeight();

                let type_ht =  head_ht + category_ht;

                $('.type_head').css('top',type_ht+'px');
            }
        }
        else
        {
            if($('#info').is(':visible')==false)
            {
                $('#info').show();

                let head_ht = $('#head').outerHeight();

                $('.category').css('top',head_ht+'px');

                let category_ht = $('.category').outerHeight();

                let type_ht =  head_ht + category_ht;

                $('.type_head').css('top',type_ht+'px');
            }
        }
    });

    $(document).on('click','#search_btn',function(){

        window.location = 'index';
    });
    
    $(document).on('click','#clos', function(){
    
        $('#overlay').attr('class','animated fadeOutDown faster');
    });
    
    $(document).on('click','#close_overlay', function(){
    
        $('#overlay').attr('class','animated fadeOutDown faster');
    });

    $(document).on('click','#enquire_btn',function(){
    
        $(this).hide().siblings('#call').css('display','grid').parent().siblings('#entry_item_body').css('display','grid').parent().siblings().children('#entry_item_body').hide().siblings('#entry_item_foot').children('#call').hide().siblings('#enquire_btn').show();
    
    });
    
    $(document).on('click','#close_drop',function(){
    
        $(this).parent().hide().siblings('#enquire_btn').show().parent().siblings('#entry_item_body').hide();
    });


    $(document).on('click','#claim_button',function(){

        $('#overlay_body').empty();

        let lang_disp = "";

        lang_disp = "<option value=''>Select Language</option>"+
        "<option value='English'>English</option>"+
        "<option value='Hindi'>Hindi</option>"+
        "<option value='Marathi'>Marathi</option>"+
        "<option value='Gujrati'>Gujrati</option>";

        let input_form = "<div id='title'>"+
            "<h3>Claim your Demo Now?</h3>"+
            "<p>Fill in the form & our counsellor will contact you within 24 hours</p>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-user'></i>&nbsp;&nbsp;Name</label>"+
            "<input type='text' id='user_name' name='user_name' value='"+user_name+"'>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-phone-alt'></i>&nbsp;&nbsp;Contact Number</label>"+
            "<input type='text' id='contact_number' name='contact_number'>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-clock'></i>&nbsp;&nbsp;Preferred time to contact you</label>"+
            "<div id='time'>"+
                "<div id='from'>"+
                    "<label>From</label>"+
                    "<input type='time' id='preferred_time_from' name='preferred_time_from'>"+
                "</div>"+
                "<div id='to'>"+
                    "<label>To</label>"+
                    "<input type='time' id='preferred_time_to' name='preferred_time_to'>"+
                "</div>"+
            "</div>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-language'></i>&nbsp;&nbsp;Preferred Language on Call</label>"+
            "<select id='preferred_language' name='preferred_language'>"+lang_disp+"</select>"+
        "</div>"+
        "<input type='hidden' id='entry_id' name='entry_id' value=''>"+
        "<input type='hidden' id='message' name='message' value='For Training Demo'>"+
        "<div id='group'>"+
            "<a id='submit_btn'><i class='fas fa-paper-plane'></i>&nbsp;&nbsp;Send</a>"+    
        "</div>";

        $('#overlay_body').append(input_form);

        $('#overlay').attr('class','animated fadeInUp faster').css('display','grid');
    });

    $(document).on('click','#get_call',function(){

        let entry_id = $(this).data('id');

        $('#overlay_body').empty();

        let type = $(this).parent().parent().parent().parent().parent().attr('class');

        let lang_disp = "";

        if(type==='commission')
        {
            lang_disp = "<option value=''>Select Language</option>"+
            "<option value='English'>English</option>"+
            "<option value='Hindi'>Hindi</option>"+
            "<option value='Marathi'>Marathi</option>"+
            "<option value='Gujrati'>Gujrati</option>";
        }
        else if(type==='non_commission')
        {
            lang_disp = "<option value=''>Select Language</option>"+
            "<option value='Marathi'>Marathi</option>"+
            "<option value='Hindi'>Hindi</option>"+
            "<option value='English'>English</option>"+            
            "<option value='Gujrati'>Gujrati</option>";
        }

        let input_form = "<div id='title'>"+
            "<h3>Interested in the course?</h3>"+
            "<p>Fill in the form & our counsellor will contact you within 24 hours</p>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-user'></i>&nbsp;&nbsp;Name</label>"+
            "<input type='text' id='user_name' name='user_name' value='"+user_name+"'>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-phone-alt'></i>&nbsp;&nbsp;Contact Number</label>"+
            "<input type='text' id='contact_number' name='contact_number'>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-clock'></i>&nbsp;&nbsp;Preferred time to contact you</label>"+
            "<div id='time'>"+
                "<div id='from'>"+
                    "<label>From</label>"+
                    "<input type='time' id='preferred_time_from' name='preferred_time_from'>"+
                "</div>"+
                "<div id='to'>"+
                    "<label>To</label>"+
                    "<input type='time' id='preferred_time_to' name='preferred_time_to'>"+
                "</div>"+
            "</div>"+
        "</div>"+
        "<div id='group'>"+
            "<label for=''><i class='fas fa-language'></i>&nbsp;&nbsp;Preferred Language on Call</label>"+
            "<select id='preferred_language' name='preferred_language'>"+lang_disp+"</select>"+
        "</div>"+
        "<input type='hidden' id='entry_id' name='entry_id' value='"+entry_id+"'>"+
        "<input type='hidden' id='message' name='message' value=''>"+
        "<div id='group'>"+
            "<a id='submit_btn'><i class='fas fa-paper-plane'></i>&nbsp;&nbsp;Send</a>"+    
        "</div>";

        $('#overlay_body').append(input_form);

        $('#overlay').attr('class','animated fadeInUp faster').css('display','grid');
    });

    $(document).on('click','#submit_btn',function(){

        let user_name = $('#user_name').val();
        let contact_number = $('#contact_number').val();
        let preferred_time_from = $('#preferred_time_from').val();
        let preferred_time_to = $('#preferred_time_to').val();
        let preferred_language = $('#preferred_language').val();
        let entry_id = $('#entry_id').val();
        let msg = $('#message').val();

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
        

        if(contact_number!=="")
        {
            if(mobile_format.test(contact_number)===false||contact_number.length!==10)
            {
                let scrollDiv = $('#contact_number').parent().offset().top;

                window.scrollTo({
                    top:scrollDiv-100,
                    behavior: 'smooth'
                });

                $('#contact_number').notify(
                    'Enter valid 10 digit landline/mobile number',
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
            if(contact_number==="")
            {
                let scrollDiv = $('#contact_number').parent().offset().top;

                window.scrollTo({
                    top:scrollDiv-100,
                    behavior: 'smooth'
                });

                $('#contact_number').notify(
                    'Enter Your Contact Number',
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
        
        if(preferred_time_from==='')
        {
            $('#preferred_time_from').notify(
                'Select time',
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

        if(preferred_time_to==='')
        {
            $('#preferred_time_to').notify(
                'Select time',
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

        if(preferred_language==='')
        {
            $('#preferred_language').notify(
                'Select language',
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

        if(check===true)
        {
            let formData = new FormData

            formData.append('user_name',user_name);
            formData.append('contact_number',contact_number);
            formData.append('preferred_time_from',preferred_time_from);
            formData.append('preferred_time_to',preferred_time_to);
            formData.append('preferred_language',preferred_language);
            formData.append('entry_id',entry_id);
            formData.append('dob',userData['dob']);
            formData.append('gender',userData['gender']);
            formData.append('caste',userData['caste']);
            formData.append('qualification',userData['qualification']);
            formData.append('stream',userData['stream']);
            formData.append('message',msg);

            
            $.ajax({
                url:'php_script/store_enquiry.php',
                type:'POST',
                contentType:false,
                processData:false,
                data:formData,
                success:function(data)
                {
                    response = $.parseJSON(data);
                    if(response['error']!==true)
                    {
                        let message = "<div id='acknowledgement'>"+
                            "<div id='acknowledgement_head' class='animated fadeInUp faster'>"+
                                "<h2 id='success'><i class='fas fa-check-circle'></i>&nbsp;&nbsp;Thank You</h2>"+
                            "</div>"+
                            "<div id='acknowledgement_body' class='animated fadeInUp faster'>"+response['message']+"</div>"+
                            "<div id='acknowledgement_foot' class='animated zoomIn faster'>"+
                                "<a href='https://www.centrefordefencecareers.co.in/courses-offered-by-centre-for-defence-careers/'>Explore Courses</a>"+
                                "<a href='https://www.centrefordefencecareers.co.in/why-is-cdc-best-institute-for-nda-cds-ota-afcat-ta-training/'>Explore Training</a>"+
                            "</div>"+
                        "</div>";

                        $('#overlay_body').empty();
                        
                        $('#overlay_body').append(message);
                        
                        const date = new Date();

                        const formatteddate = date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear();
                        
                        let formGoogleSheetData = new FormData

                        formGoogleSheetData.append('date',formatteddate);
                        formGoogleSheetData.append('name',user_name);
                        formGoogleSheetData.append('mobile',contact_number);
                        formGoogleSheetData.append('email','-');
                        formGoogleSheetData.append('location',"-");
                        formGoogleSheetData.append('generated_by',"Eligibility");

                        fetch('https://script.google.com/macros/s/AKfycbyri45Ekk9Ky2JinaNzbxdLPEWSDW0jJFEeX9leDWvnlNQVNtKLIap-eMWT77EPXGi4KQ/exec',{
                            method: "POST",
                            body: formGoogleSheetData,
                        });

                    }
                    else
                    {
                        let message = "<div id='acknowledgement'>"+
                            "<div id='acknowledgement_head' class='animated fadeInUp faster'>"+
                                "<h2 id='error'><i class='fas fa-exclamation-circle'></i>&nbsp;&nbsp;Oops!</h2>"+
                            "</div>"+
                            "<div id='acknowledgement_body' class='animated fadeInUp faster'>"+response['message']+"</div>"+
                            "<div id='acknowledgement_foot' class='animated zoomIn faster'>"+
                                "<a id='close_overlay'>Close</a>"+
                            "</div>"+
                        "</div>";

                        $('#overlay_body').empty();
                        
                        $('#overlay_body').append(message);
                    }
                },
                error:function(e)
                {
                    let message = "<div id='acknowledgement'>"+
                        "<div id='acknowledgement_head' class='animated fadeInUp faster'>"+
                            "<h2 id='error'><i class='fas fa-exclamation-circle'></i>&nbsp;&nbsp;Oops!</h2>"+
                        "</div>"+
                        "<div id='acknowledgement_body' class='animated fadeInUp faster'>"+
                        "<p>We are currently unable to send the details.</p>"+
                        "<p>You can call us at <a href='telephone:9320704957'>9320704957</a> for further enquiry</p>"+
                        "</div>"+
                        "<div id='acknowledgement_foot' class='animated zoomIn faster'>"+
                            "<a id='close_overlay'>Close</a>"+
                        "</div>"+
                    "</div>";

                    $('#overlay_body').empty();
                    
                    $('#overlay_body').append(message);
                }
            });
        }
        
    });


    function display_category(category)
    {
        category_space =  category.replace(' ','_');

        let ad_claim_disp = "<div id='claim' class='claim_bg_1'>"+
            "<div class='containr'>"+
                "<div></div>"+
                "<div id='claim_left'>"+
                    "<div id='claim_head'>"+
                        "<h3>CLAIM YOUR<br>FREE<br>PHYSICAL<br>TRAINING<br>DEMO</h3>"+
                    "</div>"+
                    "<div id='claim_body'>"+
                        "<button id='claim_button'>CLAIM NOW</button>"+
                    "</div>"+
                "</div>"+
            "</div>"+
        "</div>";

        $('#category_list').append(ad_claim_disp);

        let entry_disp = "<div class='entry' id='"+category_space+"'>"+
            "<div class='container-fluid'>"+    
                "<div class='category'>"+
                    "<h6>"+category+"</h6>"+
                "</div>"+
                "<div id='type_list'>"+   
                
                "</div>"+
            "</div>"+
        "</div>";

        $('#category_list').append(entry_disp);  

        let explore_disp = "<div id='explore' class='explore_bg_1'>"+
            "<div class='container-fluid'>"+
                "<div id='explore_head'>"+
                    "<h3>Checkout our courses and training for these entries now</h3>"+
                "</div>"+
                "<div id='explore_body'>"+
                    "<a href='https://www.centrefordefencecareers.co.in/courses-offered-by-centre-for-defence-careers/'>Explore Courses</a>"+
                    "<a href='https://www.centrefordefencecareers.co.in/why-is-cdc-best-institute-for-nda-cds-ota-afcat-ta-training/'>Explore Training</a>"+
                "</div>"+
            "</div>"+
        "</div>";

        $('#category_list').append(explore_disp);

    }


    function display_entries(array)
    {
        let height_male = '';
        let height_female = '';
        let percentage = '';

        array.forEach(element => {
            
            if(element.type==="Commission")
            {   
                category = element.category;

                entry_count[category] = entry_count[category]+1;

                category =  category.replace(' ','_');

                if($('#'+category+' #type_list .commission').length===0)
                {
                    let type_disp = "<div id='type' class='commission'>"+
                        "<div class='type_head'>"+
                            "<p>Commissioned (Officer) Entries</p>"+
                        "</div>"+
                        "<div id='entry_list'>"+

                        "</div>"+
                    "</div>";

                    
                    $('#'+category+' .container-fluid #type_list').append(type_disp);
                }


                if(element.height_male!==null)
                {
                    height_male = element.height_male+"cm & above"
                }
                else
                {
                    height_male = '-';
                }

                if(element.height_female!==null)
                {
                    height_female = element.height_female+"cm & above"
                }
                else
                {
                    height_female = '-';
                }

                if(element.percentage!==null)
                {
                    percentage = element.percentage+" % & above"
                }
                else
                {
                    percentage = '35 % & above';
                }

                
                let entry = "<div id='entry_item'>"+
                    "<div id='entry_item_head'>"+
                        "<h4>"+element.entries+"</h4>"+
                    "</div>"+
                    "<div id='entry_item_body'>"+
                        "<div id='group' class='animated zoomIn fast'>"+
                            "<p>Gender</p>"+
                            "<h6>"+element.gender+"</h6>"+
                        "</div>"+
                        "<div id='group' class='animated zoomIn fast'>"+
                            "<p>Age Limit</p>"+
                            "<h6>"+element.age+"</h6>"+
                        "</div>"+
                        "<div id='group' class='height animated zoomIn fast'>"+
                            "<p>Height</p>"+
                            "<h6><span><i class='fas fa-male'></i>&nbsp;"+height_male+"</span>&nbsp;&nbsp;<span><i class='fas fa-female'></i>&nbsp;"+height_female+"</span></h6>"+
                        "</div>"+
                        "<div id='group' class='animated zoomIn fast'>"+
                            "<p>Qualification</p>"+
                            "<h6>"+element.qualification+"</h6>"+
                        "</div>"+
                        "<div id='group' class='animated zoomIn fast'>"+
                            "<p>Percentage</p>"+
                            "<h6>"+percentage+"</h6>"+
                        "</div>"+
                    "</div>"+
                    "<div id='entry_item_foot'>"+
                        "<a id='enquire_btn' class='animated slideInUp faster'>Know More&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>"+
                        "<div id='call'>"+
                            "<a id='close_drop' class='animated slideInLeft faster'><i class='fas fa-times'></i></a>"+
                            "<a id='get_call' data-id='"+element.entry_id+"' class='animated slideInRight fast'>Get free counselling&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>"+
                        "</div>"+
                    "</div>"+
                "</div>";


                $('#'+category+' .container-fluid  #type_list .commission #entry_list').append(entry);
            }

        });


        array.forEach(element => {
            
            
            if(element.type==="Non Commission")
            {
                category = element.category;
                entry_count[category] = entry_count[category]+1;
                category =  category.replace(' ','_');

                if($('#'+category+' #type_list .non_commission').length===0)
                {
                    let type_disp = "<div id='type' class='non_commission'>"+
                        "<div class='type_head'>"+
                            "<p>Non-Commissioned Entries</p>"+
                        "</div>"+
                        "<div id='entry_list'>"+

                        "</div>"+
                    "</div>";

                    $('#'+category+' .container-fluid  #type_list').append(type_disp);
                }

                if(element.height_male!==null)
                {
                    height_male = element.height_male+" & above"
                }
                else
                {
                    height_male = '-';
                }

                if(element.height_female!==null)
                {
                    height_female = element.height_female+" & above"
                }
                else
                {
                    height_female = '-';
                }

                if(element.percentage!==null)
                {
                    percentage = element.percentage+" % & above"
                }
                else
                {
                    percentage = '-';
                }


                let entry = "<div id='entry_item'>"+
                    "<div id='entry_item_head'>"+
                        "<h4>"+element.entries+"</h4>"+
                    "</div>"+
                    "<div id='entry_item_body'>"+
                        "<div id='group'>"+
                            "<p>Gender</p>"+
                            "<h6>"+element.gender+"</h6>"+
                        "</div>"+
                        "<div id='group'>"+
                            "<p>Age Limit</p>"+
                            "<h6>"+element.age+"</h6>"+
                        "</div>"+
                        "<div id='group' class='height'>"+
                            "<p>Height</p>"+
                            "<h6><span><i class='fas fa-male'></i>&nbsp;"+height_male+"</span>&nbsp;&nbsp;<span><i class='fas fa-female'></i>&nbsp;"+height_female+"</span></h6>"+
                        "</div>"+
                        "<div id='group'>"+
                            "<p>Qualification</p>"+
                            "<h6>"+element.qualification+"</h6>"+
                        "</div>"+
                        "<div id='group'>"+
                            "<p>Percentage</p>"+
                            "<h6>"+percentage+"</h6>"+
                        "</div>"+
                    "</div>"+
                    "<div id='entry_item_foot'>"+
                        "<a id='enquire_btn' class='animated slideInUp fast'>Know More&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>"+
                        "<div id='call'>"+
                            "<a id='close_drop' class='animated slideInLeft fast'><i class='fas fa-times'></i></a>"+
                            "<a id='get_call' data-id='"+element.entry_id+"' class='animated slideInRight fast'>Get free counselling now&nbsp;&nbsp;<i class='fas fa-arrow-right'></i></a>"+
                        "</div>"+
                    "</div>"+
                "</div>";


                
                $('#'+category+' .container-fluid #type_list .non_commission #entry_list').append(entry);
            }
        });

        return true;
    }

});

