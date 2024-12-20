@extends('pages.master')

@section('content') 
    <div class="wrapper _bg4586 _new89">		
            @include('pages.components.about-navbar')
        <div class="_215td5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="title589 text-center">
							<h2>Our Features</h2>
							<p>On Cursus, you have access to:</p>
							<img class="line-title" src="images/line.svg" alt="">
						</div>
					</div>
					<div class="col-lg-3  col-sm-6">
						<div class="feature125">
							<i class="uil uil-mobile-android-alt"></i>
							<h4>Mobile learning</h4>
							<p>Quisque nec volutpat sem. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
						</div>
					</div>
					<div class="col-lg-3  col-sm-6">
						<div class="feature125">
							<i class="uil uil-users-alt"></i>
							<h4>Academic & Technical Support</h4>
							<p>Quisque nec volutpat sem. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
						</div>
					</div>
					<div class="col-lg-3  col-sm-6">
						<div class="feature125">
							<i class="uil uil-award"></i>
							<h4>Sharable Certificates</h4>
							<p>Quisque nec volutpat sem. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
						</div>
					</div>
					<div class="col-lg-3  col-sm-6">
						<div class="feature125">
							<i class="uil uil-globe"></i>
							<h4>An Inclusive Experience</h4>
							<p>Quisque nec volutpat sem. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="_215zd5">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="title478">
							<h2>Our Story</h2>
							<img class="line-title" src="images/line.svg" alt="">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur vel dolor id ultrices. Proin a magna at mi pretium pulvinar in eu enim. Nulla vel lacus lectus. Donec at venenatis augue. Nam vitae purus placerat, hendrerit nisl id, finibus magna. Etiam pharetra gravida ornare. Donec sagittis, ipsum in egestas egestas, dui lorem sollicitudin justo, ut ullamcorper velit neque eu velit. Ut et fringilla elit. Mauris augue augue, auctor a blandit ac, convallis eget neque. Curabitur in ante ante. Nullam laoreet tempus erat at ornare. In nisl nisi, dapibus eget facilisis sit amet, commodo quis nibh.</p >
						</div>
					</div>
					<div class="col-md-6">
						<div class="story125">
							<img src="images/about/stroy_img.png" alt="">
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="_215td5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="title589 text-center">
							<h2>Our Global Reach</h2>
							<p>Cursus is the leading global marketplace for teaching and learning, connecting millions of students to the skills they need to succeed.</p >
							<img class="line-title" src="images/line.svg" alt="">
						</div>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<div class="p__metric">
							25k
							<span>Instructors</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<div class="p__metric">
							95k
							<span>Courses</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<div class="p__metric">
							40M
							<span>Course enrollments</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<div class="p__metric">
							50+
							<span>Languages</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<div class="p__metric">
							595+
							<span>Membership Partners</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<div class="p__metric">
							295
							<span>Countries</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="_215xd5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="title589 text-center">
							<h2>Meet Our Team</h2>
							<p>A perfect blend of creativity and technical wizardry. The best people formula for great websites!</p>
							<img class="line-title" src="images/line.svg" alt="">
						</div>						
					</div>
					<div class="col-lg-6">
						<div class="jmio125">
							<p>Morbi eget elit eget turpis varius mollis eget vel massa. Donec porttitor, sapien eget commodo vulputate, erat felis aliquam dolor, non condimentum libero dolor vel ipsum. Sed porttitor nisi eget nulla ullamcorper eleifend. Fusce tristique sapien nisi, vel feugiat neque luctus sit amet. Quisque consequat quis turpis in mattis. Maecenas eget mollis nisl. Cras porta dapibus est, quis malesuada ex iaculis at. Vestibulum egestas tortor in urna tempor, in fermentum lectus bibendum. In leo leo, bibendum at pharetra at, tincidunt in nulla. In vel malesuada nulla, sed tincidunt neque. Phasellus at massa vel sem aliquet sodales non in magna. Ut tempus ipsum sagittis neque cursus euismod. Vivamus luctus elementum tortor, ac aliquet dolor vehicula et.</p>
							<a href="#" class="crer_btn_link">Join Our Team</a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="jmio125">
							<img src="images/about/team.jpg" alt="">
						</div>
					</div>					
				</div>
			</div>
		</div>
        @include('pages.components.footer')
    </div>
@endsection