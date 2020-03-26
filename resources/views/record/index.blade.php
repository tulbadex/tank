@extends('layouts.header')


@section('content')

<!--Content Row-->
<div class="container-fluid">
	@section('title')
	<h1>Record</h1>
	@stop

  <!-- Page Heading -->
  @include('partials.message')


  <form novalidat class="needs-validation user" method="POST" action="{{ route('transfers.store') }}" >
    @csrf

    <div class="form-group">
      <select class="form-control select {{ $errors->has('tank_id_from') ? ' is-invalid' : '' }}" name="tank_id_from">
        <option value="">Select Transfer From</option>
        @if(count($tanks) > 0)
          @foreach($tanks as $tank)
            <option value="{{ $tank->id }}" {{ old('tank_id_from')== $tank->tank_id_from ? 'selected="selected"' : '' }}>{{ $tank->name }} - {{ $tank->location->name }}</option>
          @endforeach
        @else
          <option value="">Add Tank with Location from the menu, Location and Tank is empty</option>
        @endif
        
      </select>
      @if($errors->has('tank_id_from'))
            <span class="invalid-feedback">{{ $errors->first('tank_id_from') }}</span>
        @endif
    </div>

    <div class="form-group">
      <select class="form-control select {{ $errors->has('tank_id_to') ? ' is-invalid' : '' }}" name="tank_id_to">
        <option value="">Select Transfer To</option>
        @if(count($tanks) > 0)
          @foreach($tanks as $tank)
            <option value="{{ $tank->id }}" {{ old('tank_id_to')== $tank->tank_id_to ? 'selected="selected"' : '' }}>{{ $tank->name }} - {{ $tank->location->name }}</option>
          @endforeach
        @else
          <option value="">Add Tank with Location from the menu, Location and Tank is empty</option>
        @endif
        
      </select>
      @if($errors->has('tank_id_to'))
            <span class="invalid-feedback">{{ $errors->first('tank_id_to') }}</span>
        @endif
    </div>

    <div class="form-group">
      <input type="text" class="form-control form-control-user {{ $errors->has('volume') ? ' is-invalid' : '' }}" id="volume" placeholder="Transfer Volume" name="volume" value="{{ old('volume') }}">
      @if($errors->has('volume'))
            <div class="invalid-feedback">{{ $errors->first('volume') }}</div>
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
      <h6 class="m-0 font-weight-bold text-primary">Record Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Transfer From</th>
              <th>Transfer To</th>
              <th>Transfer Volume</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
              <th>Transfer From</th>
              <th>Transfer To</th>
              <th>Transfer Volume</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </tfoot>

          <tbody>
          	
            @if($records)
              @foreach($records as $record)
              <tr>
                <td>{{ ($record->tank($record->tank_id_from)) ? $record->tank($record->tank_id_from) : '' }}</td>
                <td>{{ ($record->tank($record->tank_id_to)) ? $record->tank($record->tank_id_to) : '' }}</td>
                <td>{{ ($record->volume) ? $record->volume : ''}}</td>
                <td>{{ (date('F d, Y', strtotime($record->created_at))) ? date('F d, Y', strtotime($record->created_at)) : ''}}</td>
                <td>{{ (date('F d, Y', strtotime($record->created_at))) ? date('F d, Y', strtotime($record->created_at)) : '' }}</td>
                <td><a href="{{ route('transfers.edit', $record->id) }}" class="btn btn-warning">Edit</a></td>
                <td>
                  <form action="{{ route('transfers.destroy', $record->id) }}" method="post">
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