<x-app-layout>

    <div class="py-3">
        <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto my-2">
            <div class="px-4 py-2 border-t border-gray-200">
                <a href="{{ url('/posts/add') }}">
                    <div class="flex items-center space-x-4">
                        <input name="post" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" placeholder="What's on your mind?">
                    </div>
                </a>
            </div>
        </div>

        @if($posts->isEmpty())
            <div class="py-6">
                <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            Welcome to the micro social media.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto my-4">
                <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
                    <div class="flex items-center space-x-2">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="{{ $post->createdBy->name }}" class="w-8 h-8 rounded-full">
                        <a href="{{ route('user-post', $post->created_by) }}">
                            <span class="text-sm font-semibold">{{ $post->createdBy->name }}</span>
                        </a>
                    </div>

                    @if (auth()->user()->id != $post->created_by)
                        <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                    @endif

                    @if (auth()->user()->id === $post->created_by)
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div><span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span></div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('posts.edit', $post->id)" class="text-blue-500 hover:text-blue-700">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-dropdown-link :href="route('posts.destroy', $post->id)" class="text-red-500 hover:text-red-700">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            </svg>
                            <span class="text-sm text-gray-500">Like</span>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">0 Likes</span>
                        <span class="text-sm text-gray-500">0 Comments</span>
                    </div>
                </div>

                <div class="px-4 py-2 border-t border-gray-200">
                    <form id="commentForm" action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        @if(isset($post))
                            @method('post')
                        @endif

                        <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
                        <input type="hidden" name="commentable_id" value="{{ $commentableId }}">
                        <div class="flex items-center space-x-4">
                            <textarea name="comment" id="commentText" rows="1" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" placeholder="Write a comment..."></textarea>
                            <button type="submit" id="postCommentButton" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Post</button>
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
