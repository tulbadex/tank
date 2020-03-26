@extends('layouts.header')


@section('content')

<!--Content Row-->
<div class="container-fluid">
	@section('title')
	<h1>Tank</h1>
	@stop

  <!-- Page Heading -->

  @include('partials.message')


  <form novalidat class="needs-validation user" method="POST" action="{{ route('tanks.store') }}" >
    @csrf

    <div class="form-group">
      <input type="text" class="form-control form-control-user {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Tank Name" name="name" value="{{ old('name') }}">
      @if($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>

    <div class="form-group">
      <input type="text" class="form-control form-control-user {{ $errors->has('volume') ? ' is-invalid' : '' }}" id="volume" placeholder="Tank Volume" name="volume" value="{{ old('volume') }}">
      @if($errors->has('volume'))
            <div class="invalid-feedback">{{ $errors->first('volume') }}</div>
        @endif
    </div>

    <div class="form-group">
      <select class="form-control select {{ $errors->has('location_id') ? ' is-invalid' : '' }}" name="location_id">
        <option value="">Select Location</option>
        @if(count($locations) > 0)
          @foreach($locations as $location)
            <option value="{{ $location->id }}" {{ old('location_id')== $location->id ? 'selected="selected"' : '' }}>{{ $location->name }}</option>
          @endforeach
        @else
          <option value="">Add Location from the menu, Location is empty</option>
        @endif
        
      </select>
      @if($errors->has('location_id'))
            <span class="invalid-feedback">{{ $errors->first('location_id') }}</span>
        @endif
    </div>


    <hr>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" id="submit" name="submitLocation" value="Add Tank">
    </div>
  </form>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tank Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Volume</th>
              <th>Location</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
              <th>Name</th>
              <th>Volume</th>
              <th>Location</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </tfoot>

          <tbody>
          	
            @if($tanks)
              @foreach($tanks as $tank)
              <tr>
                <td>{{ ($tank->name) ? $tank->name : ''}}</td>
                <td>{{ ($tank->volume) ? $tank->volume : ''}}</td>
                <td>{{ ($tank->location->name) ? $tank->location->name : '' }}</td>
                <td>{{ (date('F d, Y', strtotime($tank->created_at))) ? date('F d, Y', strtotime($tank->created_at)) : ''}}</td>
                <td>{{ (date('F d, Y', strtotime($tank->created_at))) ? date('F d, Y', strtotime($tank->created_at)) : '' }}</td>
                <td><a href="{{ route('tanks.edit', $tank->id ) }}" class="btn btn-warning">Edit</a></td>
                <td>
                  <form action="{{ route('tanks.destroy', $tank->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            @endif
           
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

@stop

@section('scripts')
     <script type="text/javascript">
     	
     	
     </script>
 @stop