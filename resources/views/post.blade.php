@extends('layouts.app')

@section('content')
<div class="container">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
<div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 left-box">
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
                    <div class="card single_post">
                        <div class="body">
                            <div class="img-post owl-carousel owl-theme">
                                @if($row->Images->count() > 0)
                                @foreach($row->Images as $image)
                                <?php $ext = pathinfo($image->name, PATHINFO_EXTENSION); ?>
                                @if($ext == 'mp4')
                                <video class="d-block img-fluid item" src="{{$image->name}}" controls></video>
                                @else
                                <img class="d-block img-fluid item" src="{{$image->name}}" alt="First slide">
                                @endif
                                
                                @endforeach 
                                @else
                                <img class="d-block img-fluid item" src="https://via.placeholder.com/800x280/87CEFA/000000" alt="First slide">
                                @endif
                            </div>
                            <button class="btn btn-primary rounded-lg" @if($hasLike == 0) onclick="PostLike({{$row->id}});" @endif><i class="fa fa-thumbs-up"></i>     
                             <span id="likeCount">{{$likeCount}}</span></button>
                            <button class="btn btn-primary rounded-lg"><i class="fa fa-comments"></i> Comment</button>
                            <p>{{$row->description}}</p>
                        </div>                        
                    </div>
                    <div class="card">
                            <div class="header">
                                <h2>Comments</h2>
                            </div>
                            <div class="body">
                                <ul class="comment-reply list-unstyled">
                                    @if($row->Comments->count() > 0)
                                        @foreach($row->Comments as $comment)
                                        <li class="row maincomment clearfix">
                                            <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Awesome Image"></div>
                                            <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                                <h5 class="m-b-0">{{$comment->getUserName($comment->user_id)}} </h5>
                                                <p>{{$comment->comment}}</p>
                                                @if(!empty($comment->image))
                                                <div class="image"><img class="img-fluid img-thumbnail" width="100" src="{{$comment->image}}" alt="Awesome Image"></div>
                                                @endif
                                                <ul class="list-inline">
                                                    <li><a href="javascript:void(0);">{{date('D m Y', strtotime($comment->created_at))}}</a></li>
                                                    <li><a href="javascript:void(0);" class="btn btn-primary btn-sm rounded-lg" onclick="commentReply({{$comment->id}}, {{$comment->id}}, 1, this);">Reply</a></li>
                                                     @if($comment->user_id == Auth::id())<li><a href="{{route('DeleteComment',['id'=>$comment->id,'type'=>1])}}" class="btn btn-primary btn-sm rounded-lg">Delete</a></li> @endif
                                                </ul>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                     <div class="commentReplySection col-md-12 col-12 mt-5">
                                                         <ul class="comment-reply">
                                                             @if($comment->Replies->count() > 0)
                                                                @foreach($comment->Replies as $reply)
                                                                <li class="row mainReplyComment clearfix">
                                                                    <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Awesome Image"></div>
                                                                    <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                                                        <h5 class="m-b-0">{{$reply->getUserName($reply->user_id)}} </h5>
                                                                        <p><a href="javascript:void(0);">@ {{$reply->getUserName($reply->comment_user_id) }}</a>  {{$reply->comment}}</p>
                                                                        @if(!empty($reply->image))
                                                                        <div class="image"><img class="img-fluid img-thumbnail" width="100" src="{{$reply->image}}" alt="Awesome Image"></div>
                                                                        @endif
                                                                        <ul class="list-inline">
                                                                            <li><a href="javascript:void(0);">{{date('D m Y', strtotime($reply->created_at))}}</a></li>
                                                                            <li><a href="javascript:void(0);" class="btn btn-primary btn-sm rounded-lg" onclick="commentReply({{$comment->id}},{{$reply->id}}, 2, this);">Reply</a></li>
                                                                            @if($reply->user_id == Auth::id()) <li><a href="{{route('DeleteComment',['id'=>$reply->id,'type'=>2])}}" class="btn btn-primary btn-sm rounded-lg">Delete</a></li> @endif
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                                @endforeach
                                                            @endif
                                                         </ul>
                                                     </div>
                                                </div>
                                            </div>
                                            <div class="commentSection col-md-12 col-12 mt-5" style="display: none;"></div> 

                                        </li>
                                        @endforeach
                                    @endif

                                </ul>                                        
                            </div>
                        </div>
                        <div class="card">
                            <div class="header">
                                <h2>Leave a comment</h2>
                            </div>
                            <div class="body">
                                <div class="comment-form">
                                    <form name="PostComment" action="{{route('PostComment',$row->id)}}" class="form-horizontal row clearfix" method="post" enctype="multipart/form-data">
                                         @csrf
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <textarea rows="4" class="form-control no-resize" name="comment" placeholder="Please type what you want..." required></textarea>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label> <strong>Images</strong></label>
                                                  <input type="file" class="form-control-file" name="image">                   
                                              </div>
                                            <button type="submit" class="btn btn-block btn-primary" value="submit">SUBMIT</button>
                                        </div>                                
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-lg-4 col-md-12 right-box">
                    <div class="card">
                        <div class="header">
                            <h2>Popular Posts</h2>                        
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="commentForm" style="display: none;">
    <div class="comment-form">
        <form name="CommentReply" action="{{route('CommentReply',$row->id)}}" class="form-horizontal" method="post" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="comment_id" class="comment_id" value="">
             <input type="hidden" name="reply_id" class="reply_id" value="">
             <input type="hidden" name="type" class="comment_type" value="">
            <div class="col-sm-12">
                <div class="form-group">
                    <textarea rows="4" class="form-control no-resize" name="comment" placeholder="Please type what you want..." required></textarea>
                </div>
                <div class="form-group col-sm-12">
                    <label> <strong>Images</strong></label>
                      <input type="file" class="form-control-file" name="image">                   
                  </div>
                <button type="submit" class="btn btn-block btn-primary" value="submit">SUBMIT</button>
            </div>                                
        </form>
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
function PostLike(id) {
    jQuery.ajax({
      type: "POST",
      dataType : "JSON",
      url: "{!! route('PostLike')!!}",
      data:{'id':id},
      success: function(data)
      {
        var like = '{{$likeCount}}';
        like = parseInt(like)+1;
        $('#likeCount').text(like);
      },
      error: function(error)
      {
          alert("Oops Something goes Wrong.");
      }
    });
}
function commentReply(id, reply_id, type, thisEvent) {
    $('#commentForm').find('.comment_id').val(id);
    $('#commentForm').find('.reply_id').val(reply_id);
    $('#commentForm').find('.comment_type').val(type);
    var formHtml = $('#commentForm').html();
    if ($(thisEvent).hasClass('active')) {
        $(thisEvent).removeClass('active');
        $(thisEvent).closest('.maincomment').find('.commentSection').slideUp();
        $(thisEvent).closest('.maincomment').find('.commentSection .comment-form').remove();
    }else{
        $('.maincomment').find('.list-inline li a').removeClass('active');
        $('.maincomment').find('.commentSection').slideUp();

        $('.maincomment').find('.commentSection .comment-form').remove();
        setTimeout(function(){ 
             $(thisEvent).closest('.maincomment').find('.commentSection .comment-form').remove();
            $(thisEvent).closest('.maincomment').find('.commentSection').append(formHtml);
            $(thisEvent).addClass('active');
            $(thisEvent).closest('.maincomment').find('.commentSection').slideDown();
        }, 100);
       
        
    }
    
    // jQuery.ajax({
    //   type: "POST",
    //   dataType : "JSON",
    //   url: "{!! route('PostLike')!!}",
    //   data:{'id':id},
    //   success: function(data)
    //   {
    //     var like = '{{$likeCount}}';
    //     like = parseInt(like)+1;
    //     $('#likeCount').text(like);
    //   },
    //   error: function(error)
    //   {
    //       alert("Oops Something goes Wrong.");
    //   }
    // });
}
</script>
@endsection
