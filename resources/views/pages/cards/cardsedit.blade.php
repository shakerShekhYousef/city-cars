@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
   
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Card</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Edit Card</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @foreach ($card as $card)
    <section class="content">
      <form  method="POST" action="{{route('cardsupdate', $card->code)  }}"enctype="multipart/form-data">
        @csrf
      
       
            <!-- <div class="container-fluid">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif -->
 
              
              <div class="row">
                <!-- left column -->
      
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Card</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm">
              <div class="card-body">
            
             
          
                 
             
             <div class="form-group">
              <label for="exampleInput">price:</label>

              <input type="number" value="{{ $card->price }}"  name="price" class="form-control" placeholder="price">
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