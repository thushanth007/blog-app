@extends('layouts.custom')

@section('content')
    @if (count($errors) > 0)
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($posts->isEmpty())
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Welcome to the micro social media.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-2">
        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto my-4">
                <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
                    <div class="flex items-center space-x-2">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="{{ $post->createdBy->name }}"
                            class="w-8 h-8 rounded-full">
                        <a href="{{ url('/login') }}">
                            <span class="text-sm font-semibold">{{ $post->createdBy->name }}</span>
                        </a>
                    </div>
                    <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <div class="px-4 py-2">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full rounded-lg">
                    @endif

                    @if ($post->content)
                        <p class="pt-2">{{ $post->content }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-between px-4 py-2 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20"
                                fill="currentColor">
                            </svg>
                            <a href="{{ url('/login') }}"><span class="text-sm text-gray-500">Like</span></a>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ $post->likes_count }} Likes</span>
                        <span class="text-sm text-gray-500">{{ $post->comments_list_count }} Comments</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($posts->hasPages())
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
