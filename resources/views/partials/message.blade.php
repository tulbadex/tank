<div class="col-sm-12">

  @if(session()->get('success'))
    <div class="alert alert-success">
      <h1 class="h3 mb-2 text-gray-800">{{ session()->get('success') }} </h1> 
    </div>
    @elseif(session()->get('error'))
    <div class="alert alert-danger">
      <h1 class="h3 mb-2 text-gray-800">{{ session()->get('error') }} </h1> 
    </div>
  @endif
</div>