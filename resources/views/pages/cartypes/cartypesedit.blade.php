@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
   
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Car Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Edit Car type</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @foreach ($cartype as $cartype)
    <section class="content">
      <form  method="POST" action="{{route('cartypesupdate', $cartype->uuid)  }}"enctype="multipart/form-data">
        @csrf
      
       
            <div class="container-fluid">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
 
              
              <div class="row">
                <!-- left column -->
      
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Car Type</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm">
              <div class="card-body">
            
             
          
                 <div class="form-group">
                  <label for="exampleInputcountry">Display Name:</label>

                  <input type="text" value="{{ $cartype->display_name }}" name="display_name" class="form-control" placeholder="Display Name">
               </div>
               <div class="form-group">
                <label for="exampleInput">Capacity:</label>

                <input type="text"  value="{{ $cartype->capacity }}" name="capacity"  class="form-control" placeholder="Capacity">
             </div>
             <div class="form-group">
              <label for="exampleInput">Cost Per Minute:</label>

              <input type="number" value="{{ $cartype->cost_per_minute }}"  name="cost_per_minute" class="form-control" placeholder="Cost Per Minute" step="0.01" min="0" max="100">
           </div>
             <div class="form-group">
              <label for="exampleInput">Cost Per KM:</label>

              <input type="number" value="{{ $cartype->cost_per_km }}"  name="cost_per_km" class="form-control" placeholder="Cost Per KM" step="0.01" min="0" max="100">
           </div>
           <div class="form-group">
            <label for="exampleInput">Cancellation Fee:</label>

            <input type="number" value="{{ $cartype->cancellation_fee }}"  name="cancellation_fee" class="form-control" placeholder="Cancellation Fee" step="0.01" min="0" max="100">
         </div>
         <div class="form-group">
          <label for="exampleInput">Initial Fee:</label>

          <input type="number"  value="{{ $cartype->initial_fee }}" name="initial_fee" class="form-control" placeholder="Initial Fee" step="0.01" min="0" max="100">
       </div>
       <div class="form-group">
        <label for="exampleInput">Description:</label>

        <input type="text" value="{{ $cartype->description }}"  name="description" class="form-control" placeholder="Description">
     </div>
             <div class="form-group">
              <label for="exampleInput">Image:</label>
              <input type="file" name="image" class="form-control" name="image">
              <img src="{{ asset($cartype->image) }}" width="80">
              {{-- <input type="file" class="form-control"
              placeholder="Enter  image" value="" name="image" accept="image/png,.jpg,.jpeg"> --}}
           </div>
         
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>

         
          </div>
          <!-- /.card -->
          </div>
          </div>
        </div>

  </form>

    </section> 
    @endforeach
 
    <!-- Main content -->
    
<!-- /.content -->
</div>

@endsection