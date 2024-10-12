
@php
    $carts = Auth::user()->carts;
    $total_amount = 0;
@endphp
@extends('student.components.master')


@section('content')

	@auth
	<div class="wrapper">
	@else
	<div style="padding-top:60px;">
	@endauth
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-lg-8">
                        @foreach ($carts as $cart)
                            @php
                                $course= $cart->course;
                                $total_amount+=$course->fee;
                            @endphp
                            <div class="fcrse_1">
                                <a href="{{route('course_detail', ['id' => $course->id])}}" class="hf_img">
                                    <img class="cart_img" src="{{asset('storage/'.$course->cover_url)}}" alt="">
                                </a>
                                <div class="hs_content">
                                    <div class="eps_dots eps_dots10 more_dropdown">
                                       
                                        <form id="delete-form-{{ $cart->id }}" action="{{ route('cart.destroy', $cart->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" onclick="submitForm(event, 'delete-form-{{ $cart->id }}'); return confirm('Are you sure you want to delete this item?');"><i class='uil uil-times'></i></a>																									
                                    </div>
                                    <a href="{{route('course_detail', ['id' => $course->id])}}" class="crse14s title900 pt-2">{{$course->title}}</a>
                                    <a href="{{route('courses')}}?category_id={{$course->category_id}}" class="crse-cate">
                                        {{$course->category->title}} <i class="uil uil-arrow-right"></i> {{$course->sub_category->title}} <i class="uil uil-arrow-right"></i>  {{$course->topic->title}}
                                    </a>
                                    <div class="auth1lnkprce">
                                        <p class="cr1fot">By <a href="{{route('instructor_detail',['id'=>$course->instructor->id])}}">{{$course->instructor->user->name}}</a></p>
                                        <div class="prce142">{{$course->fee}} <span>MMK</span></div>
                                    </div>
                                </div>
                            </div>	
                        @endforeach	

					</div>
					<div class="col-lg-4">
						<div class="membership_chk_bg rght1528">
                            <div class="checkout_title">
                                <h4>Payment Methods</h4>
                                <img src="images/line.svg" alt="">
                            </div>

                            @foreach ($payment_method_types as $payment)
                                <div class="order_title payment_method" style="display: flex;">
                                    <img style="width:25px;height:25px;margin-right:20px;background:#475692;border-radius:3px;" src="{{asset($payment['icon_url'])}}" alt="">
                                    <h6>{{$payment['type']}}</h6>
                                </div>
                            @endforeach

                            <div class="order_dt_section">
                                <div class="order_title">
                                    <h4>Total Amount</h4>
                                    <div class="order_price">{{$total_amount}} <span style="font-size: 14px;">MMK</span></div>
                                </div>
                            </div>
						</div>
					</div>								
				</div>	
			</div>
		</div>
        
        <script>
            function submitForm(event, formId) {
                event.preventDefault();
                document.getElementById(formId).submit();
            }
        </script>
		
@endsection
