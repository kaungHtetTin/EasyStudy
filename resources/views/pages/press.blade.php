@extends('pages.master')

@section('content') 
    <div class="wrapper _bg4586 _new89">		
        @include('pages.components.about-navbar')
        <div class="_205ef5">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-5">
						<div class="fcrse_3 mt-50">
							<ul class="blogleft12">
								<li>
									<div class="socl148">
										<button class="twiter158" data-href="#" onclick="sharingPopup(this);" id="twitter-share"><i class="uil uil-twitter ic45"></i>Follow</button>
										<button class="facebook158" data-href="#" onclick="sharingPopup(this);" id="facebook-share"><i class="uil uil-facebook ic45"></i>Follow</button>
									</div>
								</li>
								<li>
									<div class="help_link">
										<p>Learn More</p>
										<a href="#">Cursus Help Center</a>
									</div>
								</li>
							</ul>
						</div>
					</div>					
					<div class="col-lg-9 col-md-7">
						<div class="press_news">
							<h2>Cursus in the News</h2>
							<p>For media interviews and inquiries, please send an email to <a href="#">press@cursus.com</a></p>
							<div class="press_item mt-35">
								<div class="vdtopress">March 10, 2020</div>
								<h4>Press News Title</h4>
								<p class="blog_des">Donec eget arcu vel mauris lacinia vestibulum id eu elit. Nam metus odio, iaculis eu nunc et, interdum mollis arcu. Pellentesque viverra faucibus diam. In sit amet laoreet dolor, vitae fringilla quam...</p>
								<a href="#" class="press_dt_view">Read More<i class="uil uil-angle-double-right"></i></a>
							</div>
							<div class="press_item mt-30">
								<div class="vdtopress">March 10, 2020</div>
								<h4>Press News Title</h4>
								<p class="blog_des">Donec eget arcu vel mauris lacinia vestibulum id eu elit. Nam metus odio, iaculis eu nunc et, interdum mollis arcu. Pellentesque viverra faucibus diam. In sit amet laoreet dolor, vitae fringilla quam...</p>
								<a href="#" class="press_dt_view">Read More<i class="uil uil-angle-double-right"></i></a>
							</div>
							<div class="press_item mt-30">
								<div class="vdtopress">March 10, 2020</div>
								<h4>Press News Title</h4>
								<p class="blog_des">Donec eget arcu vel mauris lacinia vestibulum id eu elit. Nam metus odio, iaculis eu nunc et, interdum mollis arcu. Pellentesque viverra faucibus diam. In sit amet laoreet dolor, vitae fringilla quam...</p>
								<a href="#" class="press_dt_view">Read More<i class="uil uil-angle-double-right"></i></a>
							</div>
							<a href="#" class="allnews_btn">See More News</a>
						</div>
						
						<div class="press_news mb-50">
							<h2>Press Releases</h2>
							<p>For Release from Cursus </p>
							<div class="press_item mt-35">
								<div class="vdtopress">March 10, 2020</div>
								<a href="#" class="press_title">Press Release Title</a>
							</div>
							<div class="press_item mt-20">
								<div class="vdtopress">March 10, 2020</div>
								<a href="#" class="press_title mb-0">Press Release Title</a>
							</div>
							<div class="press_item mt-20">
								<div class="vdtopress">March 10, 2020</div>
								<a href="#" class="press_title mb-0">Press Release Title</a>
							</div>
							<div class="press_item mt-20">
								<div class="vdtopress">March 10, 2020</div>
								<a href="#" class="press_title mb-0">Press Release Title</a>
							</div>
							<div class="press_item mt-20">
								<div class="vdtopress">March 10, 2020</div>
								<a href="#" class="press_title mb-0">Press Release Title</a>
							</div>
							<a href="#" class="allnews_btn">See More Press Releases</a>
						</div>
					</div>					
				</div>
			</div>
		</div>	
        @include('pages.components.footer')
    </div>
@endsection