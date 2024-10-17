function formatDateTime(cmtTime){
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

function createNotificationToUrl(notification, domain){
    const type = notification.notification_type_id;
    let url = "";

    // instructor dashboard
    if(type==21){ // Course Purchased
        url=`${domain}instructor/statements`;
    }else if(type==24){ // Course Question
        let course_id = JSON.parse(notification.payload).course_id;
        url = `${domain}instructor/questions?course_id=`+course_id;
    }else if(type == 26) {// Course Review
        let course_id = JSON.parse(notification.payload).course_id;
        url = `${domain}instructor/reviews?course_id=`+course_id;
    }else if(type == 41){ // Subscribed
        
    }

    // user application
    if(type==22){ // payment verified
        let course_id = JSON.parse(notification.payload).course_id;
        url=`${domain}courses/`+course_id;
    }else if(type==23){ // payment verification fail
        let course_id = JSON.parse(notification.payload).course_id;
        url=`${domain}courses/`+course_id;
    }else if(type == 25) {// Course answer
        let payload = JSON.parse(notification.payload);
        let course_id = payload.course_id;
        let question_id = payload.question_id;
        url=`${domain}courses/${course_id}/learn?question_id=${question_id}`;
    }else if(type == 27){
        let payload = JSON.parse(notification.payload);
        let course_id = payload.course_id;
        let announcement_id = payload.announcement_id;
        url=`${domain}courses/${course_id}/learn?announcement_id=${announcement_id}`;
    }else if(type == 28){ // add new module
        let course_id = JSON.parse(notification.payload).course_id;
        url=`${domain}courses/`+course_id;
    }else if(type == 29){ // add new lesson
        let course_id = JSON.parse(notification.payload).course_id;
        url=`${domain}courses/`+course_id;
    }else if(type == 42){ // add new blog
        let payload = JSON.parse(notification.payload);
        let blog_id = payload.blog_id;
        let instructor_id = payload.instructor_id;
        url =  `${domain}instructors/${instructor_id}/blogs/${blog_id}`;
    }

    return url;
}


function formatCounting(count,unit){
    count = count*1;
    if(count<=1){
        return count+' '+unit;
    }else if(count>1 && count<1000){
        return count+' '+unit+'s';
    }else if(count>=1000 && count<1000000){
        return Math.floor(count/1000)+'k '+unit+'s';
    }else {
        return Math.floor(count/1000000)+'M '+unit+'s';
    }
}