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