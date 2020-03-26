@extends('layouts.header')


@section('content')

<!--Content Row-->
<div class="row">
	@section('title')
	<h1>Tank</h1>
	@stop

@include('partials.message')


<div class="col-sm-12">

	<form novalidat class="needs-validation user" method="POST" action="{{ route('tanks.update', $tank->id ?? '') }}" >
		@method('PUT')
		@csrf

	  	  <div class="form-group">
	  	    <input type="text" class="form-control form-control-user {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Tank Name" name="name" value="{{ $tank->name ?? '' }}">
	  	    @if($errors->has('name'))
	              <div class="invalid-feedback">{{ $errors->first('name') }}</div>
	          @endif
	  	  </div>

	  	  <div class="form-group">
	  	    <input type="text" class="form-control form-control-user {{ $errors->has('volume') ? ' is-invalid' : '' }}" id="volume" placeholder="Tank Volume" name="volume" value="{{ $tank->volume ?? ''}}">
	  	    @if($errors->has('volume'))
	  	          <div class="invalid-feedback">{{ $errors->first('volume') }}</div>
	  	      @endif
	  	  </div>


	  	  <div class="form-group">
	  	    <select class="form-control select {{ $errors->has('location_id') ? ' is-invalid' : '' }}" name="location_id">
	  	    	<option value="">Select Location</option>
	  	    	@if(count($locations) > 0)
	  	    		@foreach($locations as $location)
	  	    			<option value="{{ $location->id }}" {{ $tank->location_id == $location->id ? 'selected="selected"' : '' }}>{{ $location->name }}</option>
	  	    		@endforeach
	  	    	@else
	  	    		<option value="">Add Sector from the menu, Sector is empty</option>
	  	    	@endif
	  	    	
	  	    </select>
	  	    @if($errors->has('location_id'))
	              <span class="invalid-feedback">{{ $errors->first('location_id') }}</span>
	          @endif
	  	  </div>


	  <hr>
	  <div class="form-group">
	    <input type="submit" class="btn btn-primary" id="submit" name="submitUser" value="Update Tank">
	  </div>
	</form>
</div>

</div>

@stop

@section('scripts')
     <script type="text/javascript">
     	
     	
     </script>
 @stop