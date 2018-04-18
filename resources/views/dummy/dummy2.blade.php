<section class="content-header" ui-view="header">
<h1>@{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">

    <p>You are logged in!</p>
    <hr>
	<div class="alert alert-danger">
		{{ Session::get('dataAPL.email')}}
	</div>

</section>
