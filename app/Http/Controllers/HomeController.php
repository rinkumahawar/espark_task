<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
Use App\Models\Image;
Use App\Models\Post;
Use App\Models\Like;
Use App\Models\Comment;
Use App\Models\Reply;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('Images')->get();
        return view('home',compact('posts'));
    }
    public function ViewPost($id)
    {
        $row = Post::with('Images','Comments.Replies')->find($id);
        $likeCount = Like::where('post_id',$id)->count();
        $hasLike = Like::where('user_id',Auth::id())->where('post_id',$id)->count();
        return view('post',compact('row','likeCount','hasLike'));
    }
    public function PostLike(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->input('id'))) {
                $hasLike = Like::where('user_id',Auth::id())->where('post_id',$request->input('id'))->count();
                if ($hasLike == 0) {
                    $input['user_id'] = Auth::id();
                    $input['post_id'] = $request->input('id');
                    Like::create($input);
                }
                return 1;
            }
        }
    }
    public function PostComment(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            request()->validate([
                'comment' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif'
            ]);
            if($request->hasfile('image')) {
                $image = $request->file('image');
                $imageName = time().rand(0, 1000).pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = $imageName.'.'.$image->getClientOriginalExtension();
                $image->move(public_path('comment'),$imageName);
                $input['image'] = $imageName;
            }
            if (!empty($id)) {
                $input['user_id'] = Auth::id();
                $input['post_id'] = $id;
                $input['comment'] = $request->input('comment');
                $res = Comment::create($input);
                if ($res) {
                    \Session::flash('success', 'Comment Added Successfully.');
                } else {
                    \Session::flash('fail', 'Opps! Somthing Went Wrong.');
                }
            }
            return redirect()->back(); 
        }
    }
    public function CommentReply(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            request()->validate([
                'comment' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif'
            ]);
            if($request->hasfile('image')) {
                $image = $request->file('image');
                $imageName = time().rand(0, 1000).pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = $imageName.'.'.$image->getClientOriginalExtension();
                $image->move(public_path('comment'),$imageName);
                $input['image'] = $imageName;
            }
            $comment = Comment::find($request->input('comment_id'));
            $reply = Reply::find($request->input('reply_id'));
            if (!empty($comment)) {
                $input['user_id'] = Auth::id();
                $input['comment_user_id'] = ($request->input('type')==1) ? $comment->user_id : $reply->user_id;
                $input['type'] = (int)$request->input('type');
                $input['comment_id'] = $comment->id;
                $input['reply_comment_id'] = (int)$request->input('reply_id');
                $input['comment'] = $request->input('comment');
                $res = Reply::create($input);
                if ($res) {
                    \Session::flash('success', 'Comment Added Successfully.');
                } else {
                    \Session::flash('fail', 'Opps! Somthing Went Wrong.');
                }
            }
            return redirect()->back(); 
        }
    }
    public function DeleteComment($id, $type)
    {   
        if ($type == 1) {
            $res = Comment::destroy($id);
        }else{
            $res = Reply::find($id);
            Reply::where('reply_comment_id', $res->reply_comment_id)->delete();
            $res->delete();
        }
        if ($res) {
            \Session::flash('success', 'Comment Delete Successfully.');
        } else {
            \Session::flash('fail', 'Opps! Somthing Went Wrong.');
        }
        return redirect()->back(); 
    }
    public function PostList()
    {
        $posts = Post::with('Images')->Where('user_id', Auth::id())->get();
        return view('post-list',compact('posts'));
    }
    public function AddPost($id=null)
    {
        $row = new Post();
        if ($id != null) {
            $row = Post::with('Images')->find($id);
        }
        return view('add-post',compact('row'));
    }

    public function StorePost(Request $request)
    {
        request()->validate([
            'description' => 'required|min:20|max:255',
            'images.*' => 'mimes:mp4,jpeg,jpg,png,gif'
        ]);
        if ($request->input('description')) {
            if (!empty($request->input('id'))) {
                $post = Post::find($request->input('id'));
                $post->description = $request->input('description');
                $post->save();
                $msg = 'Post Updated Successfully';
            }else{
                $post = Post::create(['user_id'=>Auth::id(), 'description'=>$request->input('description')]);
                $msg = 'Post Added Successfully';
            }
        }
        if($request->hasfile('images')) { 
            foreach($request->file('images') as $image)
            {
                $imageName = time().rand(0, 1000).pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = $imageName.'.'.$image->getClientOriginalExtension();
                $image->move(public_path('post'),$imageName);
                $input['post_id'] = $post->id;
                $input['name'] = $imageName;
                Image::create($input);
            }
        }
        \Session::flash('success', $msg);
        return redirect()->back(); 
    }
    public function DeletePost($id)
    {   $res = Image::find($id);
        $path = public_path().'/post/'.basename($res->name);
        if(File::exists($path)){
              File::delete($path);
        }
        $res->delete();
        if ($res) {
            \Session::flash('success', 'Image Delete Successfully.');
        } else {
            \Session::flash('fail', 'Opps! Somthing Went Wrong.');
        }
        return redirect()->back(); 
    }
}
