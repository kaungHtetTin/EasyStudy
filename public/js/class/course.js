class CourseComponent{
    course;
    csrf;
    view;
    apiToken;
    Context;
 
    constructor(Context,course){
        this.Context = Context;
        this.course = course;
        this.view = this.createView();
    }

    initializeCallback(){
        $(`#btn_share_${this.course.id}`).click(()=>{
            this.share(this.course.id);
        });

        $(`#btn_add_to_cart_${this.course.id}`).click(()=>{
            document.getElementById('cart_form_'+this.course.id).submit();
        });
    }

    createView(){
        let price = `<div class="prce142">${this.course.fee} <span>MMK</span></div>`;
        if(this.course.fee == 0) price = `<div class="prce142">Free</div>`;
        return `
            <div class="fcrse_1 mt-30">
                <a href="${this.Context.rootDir}courses/${this.course.id}" class="fcrse_img">
                    <img src="${this.Context.rootDir}storage/${this.course.cover_url}" alt="">
                    <div class="course-overlay">
                        <div class="badge_seller">Bestseller</div>
                        <div class="crse_reviews">
                            <i class="uil uil-star"></i>${this.course.rating}
                        </div>
                        <span class="play_btn1"><i class="uil uil-play"></i></span>
                        <div class="crse_timer">
                            ${this.calculateDuration(this.course.duration)}
                        </div>
                    </div>
                </a>
                <div class="fcrse_content">
                    <div class="eps_dots more_dropdown">
                        <a href="#"><i class="uil uil-ellipsis-v"></i></a>
                        <div class="dropdown-content">
                            <span id="btn_share_${this.course.id}"><i class='uil uil-share-alt'></i>Share</span>
                            <span id="btn_add_to_cart_${this.course.id}"> <i class="uil uil-shopping-cart-alt"></i>Add to cart</span>
                            <form id="cart_form_${this.course.id}" action="/cart" method="POST">
                                <input type="hidden" value="${this.course.id}" name="course_id">
                                ${this.Context.csrf}
                            </form>
                            <span><i class="uil uil-windsock"></i>Report</span>
                        </div>																									
                    </div>
                    <div class="vdtodt">
                        <span class="vdt14">${this.formatCounting(this.course.preview_count,'view')}</span>
                        <span class="vdt14">${this.formatDateTime(new Date(this.course.created_at))} </span>
                    </div>
                    <a href="course_detail_view.html" class="crse14s">${this.course.title}</a>
                    
                    ${this.course.category.title} <i class="uil uil-arrow-right"></i>  
                    ${this.course.sub_category.title} <i class="uil uil-arrow-right"></i>
                    ${this.course.topic.title}
                    
                    <div class="auth1lnkprce">
                        <p class="cr1fot">By <a href="/instructors/${this.course.instructor_id}">${this.course.instructor.user.name}</a></p>
                        ${price}
                        <button class="shrt-cart-btn" title="cart"><i class="uil uil-shopping-cart-alt"></i></button>
                    </div>
                </div>
            </div>
        `;
    }


    share(id){
			
        // Create a temporary input element to hold the URL
        let url = `${this.Context.rootDir}courses/${id}`;
        const tempInput = document.createElement('input');
        tempInput.value =url;
        document.body.appendChild(tempInput);

        // Select the input element's value
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the input element
        document.execCommand('copy');

        // Remove the temporary input element
        document.body.removeChild(tempInput);

        // Optionally, alert the user that the URL has been copied

        alert('URL copied to clipboard: ' +url);

        $.ajax({
            url: `${this.Context.rootDir}api/courses/share/${id}`, // Replace with your API endpoint
            type: 'POST', // or 'GET' depending on your request
            headers: {
                'Authorization': 'Bearer '+this.Context.apiToken // Example for Authorization header
            },
            success: function(response) {
                console.log('Success:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });

    }


    calculateDuration(min){
        let result = Math.floor(min/60);

        if(result>1){
            return result + " hours";
        }else{
            return result + " hour";
        }
    }

    formatCounting(count,unit){
        if(count<=1){
            return count+' '+unit;
        }else if(count>1 && count<1000){
            return Math.floor(count/1000)+' '+unit+'s';
        }else if(count>=1000 && count<1000000){
            return Math.floor(count/1000)+'k '+unit+'s';
        }else {
            return Math.floor(count/1000000)+'M '+unit+'s';
        }
    }

    formatDateTime(cmtTime){
        var currentTime = Date.now();
        var min=60;
        var h=min*60;
        var day=h*24;

        var diff =currentTime-cmtTime
        diff=diff/1000;
        
        if(diff<day*3){
            if(diff<min){
                return "a few second ago";
            }else if(diff>=min&&diff<h){
                return Math.floor(diff/min)+'min ago';
            }else if(diff>=h&&diff<day){
                return Math.floor(diff/h)+'h ago';
            }else{
                return Math.floor(diff/day)+'d ago';
            }
        }else{
            var date = new Date(Number(cmtTime));
            return date.toLocaleDateString("en-GB");
        }
    }
}