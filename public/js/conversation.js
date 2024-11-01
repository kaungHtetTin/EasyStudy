let is_fetching = false;
let arr = [];
let fetch_url = `${root_dir}api/chatrooms?page=1`

$(document).ready(()=>{

    fetchConversation();

    $(window).scroll(()=>{
        if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
            if(!is_fetching){
                fetchConversation();
            }
        }
    });

    $('#input_search').on('keyup',(x)=>{
        const search_str = $('#input_search').val();
        if(x.key === "Enter" || x.key === " " || search_str==="" ){
            fetch_url = `${root_dir}api/chatrooms/search?q=${search_str}`
            if(search_str==""){
                fetch_url = `${root_dir}api/chatrooms?page=1`
            }
            arr = [];
            $('#shimmer').show();
            fetchConversation(true);
        }
    });
})

function fetchConversation(search = false){
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
                if(fetch_url !=null) fetch_url+= "&q="+$('#input_search').val();
                let conversations = res.data;
                if(search) $('#conversation_container').html("");
                setConversation(conversations);
                
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', status, error);
        }
    });
}

function setConversation(conversations){
    $('#shimmer').hide();
    conversations.map((conversation,index)=>{
        arr.push(conversation);	
        $('#conversation_container').append(conversationComponent(conversation));
    })

    if(arr.length==0){
        $('#conversation_container').html(`
            <div style="text-align: center;color:#888">
                <br><br><br><br><br>
                <i style="font-size:80px;" class="uil uil-comments"></i><br><br>
                    <span style="font-size: 20px;">No message here</span>
                <br><br><br><br><br>
            </div>
        `)
    }
}

function conversationComponent(conversation){
    let message = conversation.message
    let active = "";
    if(conversation.seen==0){
        active = "active";
        message = `<strong>${message}</strong>`;
    }
    
    let new_message = conversation.new_message_count==0?'':`<div class="msg__badge">${conversation.new_message_count}</div>`;
    return `
        <a href="${target_dir}chatrooms/${conversation.id}">
            <div class="chat__message__dt ${active}">
                <div class="user-status">											
                    <div class="user-avatar">
                        <img src="${root_dir}storage/${conversation.user.image_url}" alt="">
                        ${new_message}
                    </div>
                    <p class="user-status-title"><span class="bold">${conversation.user.name}</span></p>
                    <p class="user-status-text">${message}</p>
                    <p class="user-status-time floaty">${formatDateTime(new Date(conversation.updated_at))}</p>
                </div>
            </div>
        </a>
    `;
}
 