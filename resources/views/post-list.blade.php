@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <a href="{{route('AddPost')}}" class="btn btn-primary mb-2">Add Post</a>
            <div class="card">
              <div class="alert alert-success" id="successMsg" style="display: none;">
                <strong>Success!</strong> <span class="successMsg">Indicates a successful or positive action</span>
              </div>
              <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Description</th>
                     <th>Image</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody id="tableBody">
                <?php $i = 1; ?>
                @if($posts->count() > 0)
                @foreach($posts as $row)
                  <tr>
                     <td>1</td>
                     <td>{{ $row->description }}</td>
                     <td><strong>{{$row->Images->count() > 0 ? 'Available' : 'Not Available'}} </strong> </td>
                     <td><a href="{{route('EditPost', $row->id)}}"  class="btn btn-info">Edit</a></td>
                  </tr>
                  <?php $i++; ?>
              @endforeach

              @else
                <tr>
                    <td colspan="4">Posts Not Available</td>
                </tr>
              @endif
               </tbody>
              </table>
            </div>
       </div> 
    </div>
</div>
@endsection
