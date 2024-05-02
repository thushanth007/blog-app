<x-app-layout>
    <div class="py-3">
        @if (session('success'))
            <div class="py-3">
                <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto my-2">
                    <div class="p-6 text-gray-900">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline"> {{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto my-2">
            <div class="px-4 py-2 border-t border-gray-200">
                <a href="{{ url('/posts/add') }}">
                    <div class="flex items-center space-x-4">
                        <input name="post"
                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"
                            placeholder="What's on your mind?">
                    </div>
                </a>
            </div>
        </div>

        @if ($posts->isEmpty())
            <div class="py-6">
                <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            No posts to display. Please upload a post.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-md max-w-xl mx-auto my-4">
                <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
                    <div class="flex items-center space-x-2">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="{{ $post->createdBy->name }}"
                            class="w-8 h-8 rounded-full">
                        <span class="text-sm font-semibold">{{ $post->createdBy->name }}</span>
                        <span>
                            @if ($post->status === 1)
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                    Active
                                </span>
                            @elseif($post->status === 2)
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                    Inactive
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                    Pending
                                </span>
                            @endif
                        </span>
                    </div>

                    @if (auth()->user()->id === $post->created_by)
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div><span
                                                class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('posts.edit', $post->id)" class="text-blue-500 hover:text-blue-700">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>

                                    <form method="post" action="{{ route('posts.destroy', $post->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        @if (isset($post))
                                            @method('DELETE')
                                        @endif

                                        <x-dropdown-link class="text-blue-500 hover:text-blue-700">
                                            <button>
                                                <div class="text-blue-500 hover:text-blue-700">
                                                    {{ __('Delete') }}
                                                </div>
                                            </button>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20"
                                fill="currentColor">
                            </svg>
                            <form id="likeForm" onsubmit="event.preventDefault(); addLike({{ $post->id }})"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="likeButton" class="text-sm text-gray-500">Like</button>
                            </form>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500" id="likeCount_{{ $post->id }}"
                            data-post-id="{{ $post->id }}">{{ $post->likes_count }} Likes</span>
                        <span class="text-sm text-gray-500" id="commentCount_{{ $post->id }}"
                            data-post-id="{{ $post->id }}">{{ $post->comment_list_count }} Comments</span>
                    </div>
                </div>

                @if ($post->status === 1)
                    <div class="px-4 py-2 border-t border-gray-200">
                        <form id="commentForm"
                            onsubmit="event.preventDefault(); submitComment('{{ $post->id }}', '{{ $commentableType }}')"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="flex items-center space-x-4">
                                <input type="text" name="comment" id="commentField_{{ $post->id }}"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"
                                    placeholder="Write a comment...">
                                <button type="submit" id="postCommentButton"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Post</button>
                            </div>
                        </form>
                    </div>
                @endif

                @if ($post->comments)
                    @foreach ($post->comments as $comment)
                        <div id="commentsSection_{{ $post->id }}">
                            <div id="comment_{{ $comment->id }}">
                                <div class="flex items-center justify-between px-4 py-2 border-t border-gray-200">
                                    <div class="flex items-center space-x-2">
                                        <img src="https://randomuser.me/api/portraits/men/1.jpg"
                                            alt="{{ $post->createdBy->name }}" class="w-8 h-8 rounded-full">
                                        <a href="{{ route('user-post', $comment->user_id) }}">
                                            <span class="text-sm">{{ $comment->createdBy->name }}</span>
                                        </a>
                                    </div>
                                    @if ($comment->user_id == Auth::id())
                                        <div class="flex items-center space-x-4">
                                            <form id="commentDeleteForm"
                                                onsubmit="event.preventDefault(); deleteComment({{ $comment->id }})"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="postCommentDeleteButton"
                                                    class="text-sm text-gray-500">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center px-12 border-gray-200 pb-2">
                                    <div class="flex items-center space-x-4">
                                        {{ $comment->body }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
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
