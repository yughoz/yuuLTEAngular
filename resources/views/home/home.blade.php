<section class="content-header" ui-view="header">
<h1>@{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-maroon"><i class="fa fa-legal"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Licence</span><span class="info-box-number">Free</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">AdminLTE version</span><span class="info-box-number">2.3.1</span>
				</div>
			</div>
		</div>
		<div class="clearfix visible-sm-block"></div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Users</span><span class="info-box-number">{{ $userCount}}</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-shield"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Security groups</span><span class="info-box-number">{{ $groupCount}}</span>
				</div>
			</div>
		</div>
	</div>
    <p>You are logged in!</p>
    <hr>
	<div class="alert alert-danger">
		{{ Session::get('dataAPL.email')}}
	</div>

<!-- Content Header (Page header) -->

</section>
