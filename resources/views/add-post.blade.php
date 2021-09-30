@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-12">
          <a href="{{route('PostList')}}" class="btn btn-primary mb-5 rounded-lg">Post List</a>
            <div class="card">
              @if ($message = Session::get('success')) 
                  <div class="alert alert-success alert-block"> 
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong> 
                  </div>
              @endif 
               @if ($message = Session::get('fail')) 
                  <div class="alert alert-danger alert-block"> 
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong> 
                  </div>
              @endif 
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <strong>Whoops!</strong> There were some problems with your input.<br><br>
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif 

              <form name="StorePost" action="{{route('StorePost')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{@$row->id}}">
                  <div class="form-group col-sm-12">
                      <label> <strong>Description</strong></label>
                      <textarea class="form-control" rows="5" name="description" id="description" minlength="20" maxlength="255" required>{{@$row->description}}</textarea>
                      <span class="help-block"></span>
                  </div>
                  <div class="form-group col-sm-12">
                    <label> <strong>Images Upload (Multiple)</strong></label>
                      <input type="file" class="form-control-file" name="images[]" multiple>                   
                  </div>
                  @if($row->Images->count() > 0)
                  <div class="col-sm-12">
                    <div class="row">
                      @foreach($row->Images as $row)
                      <?php $ext = pathinfo($row->name, PATHINFO_EXTENSION); ?>
                      <div class="col-sm-4">
                        <div class="card">
                          @if($ext == 'mp4')
                          <video width="320" height="240" src="{{$row->name}}" controls></video>
                          @else
                          <img class="card-img-top" src="{{$row->name}}" alt="Card image" style="width:100%">
                          @endif
                          <div class="card-body text-right">
                            <a href="{{route('DeletePost',$row->id)}}" class="btn btn-danger">Delete</a>
                          </div>
                        </div>
                      </div>
                      @endforeach 
                    </div>
                  </div>
                   @endif 
                  
                  <div class="form-group col-sm-12">
                   <button type="submit" class="btn btn-primary" value="submit">Save
                   </button>
                  </div>
              </form>
            </div>
       </div> 
    </div>
</div>
@endsection
