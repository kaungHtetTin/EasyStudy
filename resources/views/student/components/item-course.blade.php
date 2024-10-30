<div class="item">
    <div class="fcrse_1 mb-20">
        <a href="{{route('course_detail', ['id' => $course->id])}}" class="fcrse_img">
            <img src="{{asset('storage/'.$course->cover_url)}}" alt="">
            <div class="course-overlay">
                <div class="crse_reviews">
                    <i class='uil uil-star'></i>{{$course->rating}}
                </div>
                <span class="play_btn1"><i class="uil uil-play"></i></span>
                <div class="crse_timer">
                    {{calculateHour($course->duration)}} hours
                </div>
            </div>
        </a>
        <div class="fcrse_content">
            <div class="eps_dots more_dropdown">
                <a href="#"><i class='uil uil-ellipsis-v'></i></a>
                <div class="dropdown-content">
                    <span onclick="copyCourseUrl('{{route('course_detail', ['id' => $course->id])}}','{{$course->id}}')"><i class='uil uil-share-alt'></i>Share</span>
                    <span onclick="addToCart('{{$course->id}}')"><i class="uil uil-shopping-cart-alt"></i>Add to cart</span>
                    <form id="cart_form_{{$course->id}}" action="{{route('cart')}}" method="POST">
                        <input type="hidden" value="{{$course->id}}" name="course_id">
                        @csrf
                    </form>
                    <span onclick="reportCourse({{$course->id}})"><i class="uil uil-windsock"></i>Report</span>
                </div>																											
            </div>
            <div class="vdtodt">
                <span class="vdt14">{{formatCounting($course->preview_count,'view')}}</span>
                <span class="vdt14">{{$course->created_at->diffForHumans()}}</span>
            </div>
            <a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s"> {{$course->title}} </a>
            <a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
                {{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
            </a>
            <div class="auth1lnkprce">
                <p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
                @if ($course->fee > 0)
                    <div class="prce142">{{$course->fee}} <span>MMK</span></div>
                @else
                    <div class="prce142">Free</div>
                @endif
                
                <form action="{{route('cart')}}" method="POST">
                    <input type="hidden" value="{{$course->id}}" name="course_id">
                    @csrf
                    <button type="submit" class="shrt-cart-btn" title="Add to cart"><i class="uil uil-shopping-cart-alt"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function reportCourse(id){
            window.location.href = "{{route('reports.create')}}?id="+id+"&type=1";
        }
    </script>
</div>
