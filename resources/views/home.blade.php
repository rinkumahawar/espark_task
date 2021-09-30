@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('AddPost')}}" class="btn btn-primary mb-5 rounded-lg">Add Post</a>
            <a href="{{route('PostList')}}" class="btn btn-primary mb-5 rounded-lg">Post List</a>
        </div>
        @if($posts->count() > 0)
            @foreach($posts as $row)
            <div class="col-md-4">
                <div class="card">
                    <div class="img-post owl-carousel owl-theme">
                        @if($row->Images->count() > 0)
                    @foreach($row->Images as $image)
                    <?php $ext = pathinfo($image->name, PATHINFO_EXTENSION); ?>
                    @if($ext == 'mp4')
                    <video class="card-img img-fluid item" src="{{$image->name}}" controls></video>
                    @else
                    <img class="card-img-top img-fluid item" src="{{$image->name}}" alt="First slide">
                    @endif
                    
                    @endforeach 
                    @else
                    <img class="card-img-top img-fluid item" src="{{asset('post/no-image.jpg')}}" alt="First slide">
                    @endif
                    </div>
                    
                  <div class="card-body">
                    <p class="card-text">{{$row->description}}</p>
                    <a href="{{route('ViewPost',$row->id)}}" class="btn btn-outline-secondary btn-sm float-md-right">Read More</a>
                  </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
      $('.img-post').owlCarousel({
        items: 1,
        animateOut: 'fadeOut',
        loop: false,
        margin: 10,
      });
      $('.custom1').owlCarousel({
        animateOut: 'slideOutDown',
        animateIn: 'flipInX',
        items: 1,
        margin: 30,
        stagePadding: 30,
        smartSpeed: 450
      });
    });
</script>
@endsection
