@extends('layouts.header')


@section('content')

<!--Content Row-->
<div class="container-fluid">
	@section('title')
	<h1>Location</h1>
	@stop

  <!-- Page Heading -->
  @include('partials.message')

  <!-- DataTales Example -->

  <form novalidat class="needs-validation user" method="POST" action="{{ route('locations.store') }}" >
    @csrf

    <div class="form-group">
      <input type="text" class="form-control form-control-user {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Location Name" name="name" value="{{ old('name') }}">
      @if($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>


    <hr>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" id="submit" name="submitLocation" value="Add Location">
    </div>
  </form>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Location Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
              <th>Name</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </tfoot>

          <tbody>
          	
            @if($locations)
              @foreach($locations as $location)
              <tr>
                <td>{{ ($location->name) ? $location->name : ''}}</td>
                <td>{{ (date('F d, Y', strtotime($location->created_at))) ? date('F d, Y', strtotime($location->created_at)) : ''}}</td>
                <td>{{ (date('F d, Y', strtotime($location->created_at))) ? date('F d, Y', strtotime($location->created_at)) : '' }}</td>
                <td><a href="{{ route('locations.edit', $location->id ) }}" class="btn btn-warning">Edit</a></td>
                <td>
                  <form action="{{ route('locations.destroy', $location->id) }}" method="post">
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