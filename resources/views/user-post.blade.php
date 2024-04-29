<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $posts[0]->createdBy->name  }} Profile
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline"> {{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($posts->isEmpty())
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        No posts to display. Please upload a post.
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
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="{{ $post->createdBy->name }}" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-semibold">{{ $post->createdBy->name }}</span>
                    </div>
                    <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                </div>
                
                <div class="px-4 py-2">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full rounded-lg">
                    @endif

                    @if ($post->content)
                        <p>{{ $post->content }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-between px-4 py-2 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            </svg>
                            <span class="text-sm text-gray-500">Like</span>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">0 Likes</span>
                        <span class="text-sm text-gray-500">0 Comments</span>
                    </div>

                    @if (auth()->user()->id === $post->created_by)
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="px-4 py-2 border-t border-gray-200">
                    <form action="" method="POST">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <textarea name="comment" rows="2" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" placeholder="Write a comment..."></textarea>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @if ($posts->hasPages())
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
