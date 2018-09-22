<!DOCTYPE html>
<html>
<head>
	<title>Add Product</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<form action="{{asset('products/add')}}" method="POST" role="form">
			@csrf
			@foreach( $atts as $att)
				<div class="form-group">
					<label for="">{{$att->column}}</label>
					<input type="text" class="form-control" id="{{$att->column}}" placeholder="{{$att->column}}" name="{{$att->column}}">
				</div>	
			@endforeach

			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</body>
</html>