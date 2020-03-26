@extends('layouts.header')


@section('content')

<!--Content Row-->

@section('title')
<h1>Location</h1>
@stop

@include('partials.message')


<div class="col-sm-12">

	<form novalidat class="needs-validation user" method="POST" action="{{ route('locations.update', $location->id ?? '') }}" >
		@method('PUT')
		@csrf

	  	  <div class="form-group">
	  	    <input type="text" class="form-control form-control-user {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Location Name" name="name" value="{{ $location->name ?? '' }}">
	  	    @if($errors->has('name'))
	              <div class="invalid-feedback">{{ $errors->first('name') }}</div>
	          @endif
	  	  </div>


	  <hr>
	  <div class="form-group">
	    <input type="submit" class="btn btn-primary" id="submit" name="submitUser" value="Update Location">
	  </div>
	</form>
</div>


@stop

@section('scripts')
     <script type="text/javascript">
     	
     	
     </script>
 @stop