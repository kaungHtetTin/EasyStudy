let message_arr = [];
let is_fetching = false;
let no_more_message = false;
let fetch_url = `${root_dir}api/messages?other_id=${other.id}`
let selectedImageFile = null;

$(document).ready(()=>{
        
    $('#btn_sent_message').click(()=>{
        let validateResult = validateMessageInput();
        if(validateResult){
            $('#input_message_text').val(""); 
            sendMessage(validateResult);
        }
    });
    fetchMessage();

    $('#scroll_warpper').scroll(()=>{
        let offset = $('#scroll_warpper').scrollTop();
        if(offset<200 && $('#scroll_warpper').height()>200){
            if(!is_fetching && !no_more_message){
                 fetchMessage(true);
            }
        }
        
    })

    $('#input_message_text').on('keyup',(x)=>{
        if(x.key === "Enter"){
            let validateResult = validateMessageInput();
            if(validateResult){
                $('#input_message_text').val(""); 
                sendMessage(validateResult);
            }
        }
    })

    let offline = isOffline(new Date(other.updated_at));
    if(!offline){
        $('#user_status').html(`<p class="user-status-tag online">Online</p>`);
    }else{
        $('#user_status').html(`<span class="offline-status">${offline}</span>`);
    }

    $('#btn_select_image').click(()=>{
        $('#input_image').click();
    });

    $('#input_image').change(()=>{
        let files =  $('#input_image').prop('files');
        let file = files[0];
        selectedImageFile = file;
        let reader = new FileReader();
        reader.onload = (e)=>{
            let imgSrc = e.target.result;
            $('#img_display').attr('src', imgSrc);
           
            $('#img_box').show();
        }
        reader.readAsDataURL(file)
    })

    $('#img_cancel').click(()=>{
        selectedImageFile = null;
         $('#img_box').hide();
    });

    autoRefresh();
});

function fetchMessage(previousLoading = false){
    is_fetching = true;
    $('#shimmer').show();
    if(fetch_url==null){
        $('#shimmer').hide();
        return;
    }
    $.ajax({
        url: fetch_url,
        type: 'GET', // or 'GET' depending on your request
        headers: {
            'Authorization': 'Bearer '+apiToken // Example for Authorization header
        },
        success: function(res) {
            is_fetching=false;
            if(res){
                fetch_url = res.next_page_url;
                if(fetch_url !=null){
                    fetch_url += "&other_id="+other.id;
                }else{
                    no_more_message = true;
                }
                let messages = res.data;
                setMessage(messages,previousLoading);
                
            }
        },
        error: function(xhr, status, error) {
          //  console.error('Error:', status, error);
        }
    });
}

function setMessage(messages,previousLoading){
    $('#shimmer').hide();
    for(let i = 0;i<messages.length;i++){
        let msg = messages[i];
            
        message_arr.unshift(msg);
        if(msg.sender_id == user.id){
            $('#message_container').prepend(myMessage(msg));
        }else{
            $('#message_container').prepend(otherMessage(msg));
        }
    }

    if(message_arr.length == 0){
        $('#msg_profile').show();
    }

    if(!previousLoading)scrollToBottom();

}

function sendMessage(formData){
    $('#msg_profile').hide();
    var msg_id = Date.now();
    $('#img_cancel').click();
    $('#message_container').append(sendingMessage(formData,msg_id));
    scrollToBottom();
    var ajax=new XMLHttpRequest();
    ajax.onload =function(){
        if(ajax.status==200 || ajax.readyState==4){
            let response = JSON.parse(ajax.responseText);
            
            $(`#id_${msg_id}`).remove();
            $('#message_container').append(myMessage(response));
            message_arr.push(response);
        }else{
          //  console.log(ajax.responseText);
            
        }
    };
    ajax.open("post",`${root_dir}api/messages`,true);
    ajax.setRequestHeader('Authorization','Bearer '+apiToken);
    ajax.setRequestHeader('Accept','application/json');
    ajax.send(formData);
}

function validateMessageInput(){
    let validate = false;
    const message = $('#input_message_text').val();
    let formData = new FormData();
    formData.append('other_id',other.id);
    if(message!=""){
        validate = true;
        formData.append('message',message);
    }

    if(selectedImageFile != null){
        validate = true;
        formData.append('image',selectedImageFile);
    }

    if(validate) return formData;
    else false;
}

function sendingMessage(formData,msg_id){
    return `
        <div id="id_${msg_id}" class="main-message-box ta-right">
            <div class="message-dt" style="width:100%;">
                <div class="message-inner-dt" style="float:right;">
                    <p>${formData.get('message')}</p>
                </div><!--message-inner-dt end-->
                <span id="status_${msg_id}" style="text-align:right;">Sending ...</span>
            </div><!--message-dt end-->
        </div><!--main-message-box end-->
    `;
}

function myMessage(message){
    let image = ``;
    if(message.image_url){
        image = `<span><img class="message-image" src="${root_dir}storage/${message.image_url}"/></span>`;
    }
    let message_section = `<div class="message-inner-dt" style="float:right;"><p>${message.message}</p></div>`;
    if(!message.message) message_section ="";
    return `
        <div id="msg_${message.id}" class="main-message-box" style="padding-right:20px;">
            <div class="message-dt" style="width:100%;">
                ${message_section}
                ${image}
                <span style="text-align:right;">
                    ${formatDateTime(new Date(message.created_at))} ${message.seen == 1?' . seen':''}
                </span>
               
            </div><!--message-dt end-->
           
             
        </div><!--main-message-box end-->
       
    `;
}

function otherMessage(message){
    let image = ``;
    if(message.image_url){
        image = `<img src="${root_dir}storage/${message.image_url}" class="message-image" style="float:left;display:block" />`;
    }
    let message_section = `<div class="message-inner-dt"><p>${message.message}</p></div><br>`;
    if(!message.message) message_section ="";
    return `
        <div class="main-message-box st3">
            <div style="display: flex"> 
                <div class="user-avatar" style="margin-left:20px;">
                    <a href="${root_dir}users/${message.user.id}">
                        <img src="${root_dir}storage/${message.user.image_url}" style="width:40px;height:40px;" alt="">
                    </a>
                </div>
                <div class="message-dt st3" style="padding-left:0px;margin-right:20px;">
                    ${message_section}
                    ${image}
                    <span>${formatDateTime(new Date(message.created_at))}</span>
                </div>
            </div><!--message-dt end-->
        </div><!--main-message-box end-->
    `;
}

function scrollToBottom() {
    let element = document.getElementById('scroll_warpper');
    $('#scroll_warpper').scrollTop(element.scrollHeight);
    //console.log($('#scroll_warpper').scrollTop(),' Vs ',$('#message_container').height() );

    setTimeout(() => {
        //element.scrollTop= element.scrollHeight;
        
    }, 1000);
}


function autoRefresh(){
    setInterval(() => {
            
        if(message_arr.length>0){
            let last_message = message_arr[message_arr.length-1];
            refreshMessage(last_message.id);
        }
        
    }, 5000);
}

function refreshMessage(last_message_id){
    console.log('last id', last_message_id);
    
    let refresh_url = `${root_dir}api/messages/refresh?other_id=${other.id}&last_message_id=${last_message_id}`;
    $.ajax({
        url: refresh_url,
        type: 'GET', // or 'GET' depending on your request
        headers: {
            'Authorization': 'Bearer '+apiToken // Example for Authorization header
        },
        success: function(res) {
            if(res){
                let messages = res;
                setNewMessage(messages);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', status, error);
        }
    });
}

function setNewMessage(messages){
    for(let i = 0;i<messages.length;i++){
        let msg = messages[i];
        message_arr.push(msg);
        if(msg.sender_id == user.id){
            $('#message_container').append(myMessage(msg));
        }else{
            $('#message_container').append(otherMessage(msg));
        }
        scrollToBottom();
    }

}

function isOffline(cmtTime){
    var currentTime = Date.now();
    var min=60;
    var h=min*60;
    var day=h*24;

    var diff =currentTime-cmtTime
    diff=diff/1000;
    
    if(diff<min*2){
        return false;
    }else if(diff>=min&&diff<h){
        return Math.floor(diff/min)+'min ago';
    }else if(diff>=h&&diff<day){
        return Math.floor(diff/h)+'h ago';
    }else{
        return Math.floor(diff/day)+'d ago';
    }
}