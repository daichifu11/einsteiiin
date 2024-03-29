@extends('layouts.app')
@section('content')
<div>
    <div class="card col-md-6 m-auto p-3">
        <p class="h4"><a class="text-dark" href="/profile/{{ $post->user->id }}">{{ $post->user->name }}</a></p>
        <hr>
        <p>{{ $post->content }}</p>
        @if ($login_user && $login_user->id == $post->user->id)
            <form action="{{ route('post_remove', ['id' => $post->id]) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $post->id }}">
                <input type="submit" value="削除" class="btn btn-danger mt-5"
                    onclick='return confirm("この投稿を削除しますか？")'>
            </form>
        @endif
        <p class="mt-3">{{ $post->created_at->format('Y年m月d日H時i分') }}</p>
    </div>
    <br><br>

    @if ($login_user)
        <div class="card col-md-6 m-auto p-3 ">
            <form action="/comment" method="post">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ $login_user->id }}">
                <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <input type="submit" value="コメント" class="btn btn-primary">
            </form>
        </div>
      @else
          <div class="card col-md-6 m-auto p-3">
              <textarea cols="30" rows="10" readonly="readonly" class="text-secondary">※コメントをするにはログインが必要です。</textarea>
              <p class="mt-5 mb-3 h6 text-center"><a class="text-white bg-primary p-3 rounded-pill" href="/login">ログインする</a></p>
          </div>
      @endif
    <br><br>
    
    @if ($post->comments->count() != 0)
        @foreach ($post->comments as $comment)
            <div class="mb-1">
                <div class="card col-md-6 p-3 m-auto">
                    <p class="h4"><a class="text-dark" href="/profile/{{ $comment->user->id }}">{{ $comment->user->name  }}</a></p>
                    <hr>
                    <p>{{ $comment->content }}</p>
                    <p>{{ $post->created_at->format('Y年m月d日H時i分') }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="card col-md-6 m-auto p-3 ">
            <p class="text-center">コメントがありません</p>
        </div>
    @endif
</div>
@endsection