<div class="fcrse_1">
    <a href="{{route('course_detail', ['id' => $course->id])}}" class="hf_img">
        <img src="{{asset('storage/'.$course->cover_url)}}" alt="">
        <div class="course-overlay">
            <div class="badge_seller">Bestseller</div>
            <div class="crse_reviews">
                <i class="uil uil-star"></i>{{$course->rating}}
            </div>
            <span class="play_btn1"><i class="uil uil-play"></i></span>
            <div class="crse_timer">
                {{calculateHour($course->duration)}} Hours
            </div>
        </div>
    </a>
    <div class="hs_content">
        
        <div class="vdtodt">
            @if ($myCourse->verified == 0)
                <div style="background:rgb(239, 239, 0);border-radius:50px;width:15px;height:15px;position: absolute;right:15px;top:15px;"></div>
            @endif
            <span class="vdt14">109k views</span>
            <span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
        </div>
        <a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s title900">{{$course->title}}</a>
        <a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
            {{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
        </a>
        <div class="auth1lnkprce">
            <p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
        </div>
    </div>
</div>