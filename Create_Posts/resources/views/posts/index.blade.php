@extends('layouts.app')

@section('content')
    <div class="flex justify-center ">
        <div class="w-8/12 bg-white p-6 rounded-lg">
           <form action="{{route('posts')}}" method="post">
            @csrf
            <div class="mb-4">
                <label for="desc" class="sr-only">Body</label>
                <textarea name="desc" id="desc" cols="30" rows="7" class="bg-gray-100 border-2 w-full p-4 rounde-lg @error('desc') border-red-500 @enderror" placeholder="write description....." ></textarea>

                @error('desc')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror

                <div class="">
                    <button type="submit" class="bg-blue-500 text-white px-4 mt-5 py-3 rounded font-medium  ">Post</button>
                </div>
            </div>


           </form>
           @if ($posts->count())
              @foreach ($posts as $pst )
              <div class="mb-4">
                  <a href="" class="font-bold">{{ $pst->user->name }}</a> <span class="text-gray-600 text-sm">{{ $pst->created_at->diffForHumans() }}</span>
                  <p class="mb-2">{{$pst->description}}</p>
                  @auth
                  <div>
                      <form action="{{route('posts',$pst)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-blue-500">Delete</button>
                    </form>
                  </div>
                  @endauth

                  <div class="flex items-center">
                      @auth
                        @if (!$pst->checkLike(auth()->user()))
                            <form action="{{route('posts.likes', $pst )}}" method="post" class="mr-1">
                                @csrf
                                <button type="submit" class="text-blue-500">Like</button>
                            </form>
                        @else
                            <form action="{{route('posts.likes', $pst )}}" method="post" class="mr-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Unlike</button>
                            </form>
                        @endif
                    @endauth
                    @if ($pst->likes->count())
                        <span>{{$pst->likes->count()}} {{ Str::plural('like',$pst->likes->count())}}</span>
                    @endif


                  </div>
              </div>

              @endforeach
              {{ $posts->links() }}
           @else
              <p>No posts found</p>
           @endif
        </div>
    </div>

@endsection

