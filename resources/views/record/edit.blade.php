@extends('layouts.header')


@section('content')

<!--Content Row-->
<div class="container-fluid">
	@section('title')
	<h1>Edit Record</h1>
	@stop

  <!-- Page Heading -->
  @include('partials.message')


  <form novalidat class="needs-validation user" method="POST" action="{{ route('transfers.update', $record->id ?? '') }}" >
    @method('PUT')
    @csrf

    <div class="form-group">
      <select class="form-control select {{ $errors->has('tank_id_from') ? ' is-invalid' : '' }}" name="tank_id_from">
        <option value="">Select Location</option>
        @if(count($tanks) > 0)
          @foreach($tanks as $tank)
            <option value="{{ $tank->id }}" {{ $record->tank_id_from == $tank->id ? 'selected="selected"' : '' }}>{{ $tank->name }} - {{ $tank->location->name }}</option>

          @endforeach
        @else
          <option value="">Add Sector from the menu, Sector is empty</option>
        @endif
        
      </select>
      @if($errors->has('tank_id_from'))
            <span class="invalid-feedback">{{ $errors->first('tank_id_from') }}</span>
        @endif
    </div>

    <div class="form-group">
      <select class="form-control select {{ $errors->has('tank_id_to') ? ' is-invalid' : '' }}" name="tank_id_to">
        <option value="">Select Location</option>
        @if(count($tanks) > 0)
          @foreach($tanks as $tank)
            <option value="{{ $tank->id }}" {{ $record->tank_id_to == $tank->id ? 'selected="selected"' : '' }}>{{ $tank->name }} - {{ $tank->location->name }}</option>
          @endforeach
        @else
          <option value="">Add Sector from the menu, Sector is empty</option>
        @endif
        
      </select>
      @if($errors->has('tank_id_to'))
            <span class="invalid-feedback">{{ $errors->first('tank_id_to') }}</span>
        @endif
    </div>

    <div class="form-group">
      <input type="text" class="form-control form-control-user {{ $errors->has('volume') ? ' is-invalid' : '' }}" id="volume" placeholder="Transfer Volume" name="volume" value="{{ $record->volume ?? '' }}">
      @if($errors->has('volume'))
            <div class="invalid-feedback">{{ $errors->first('volume') }}</div>
        @endif
    </div>


    <hr>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" id="submit" name="submitLocation" value="Update Record">
    </div>
  </form>

  

</div>
<!-- /.container-fluid -->

@stop

@section('scripts')
     <script type="text/javascript">
     	
     	
     </script>
 @stop