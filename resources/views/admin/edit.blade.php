<x-app-layout>

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


    <div class="py-3">
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
                        <p class="pt-2">{{ $post->content }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-between px-4 py-2 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        @if($post->status === 0)
                            <form method="post" action="{{ route('admin.update-status', $post) }}" enctype="multipart/form-data">
                                @csrf

                                @if(isset($post))
                                    @method('patch')
                                @endif

                                <input type="hidden" name="status" value="1">

                                <button class="flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    </svg>
                                    <span class="text-sm text-gray-500">Approve</span>
                                </button>
                            </form>
                            <form method="post" action="{{ route('admin.update-status', $post) }}"  enctype="multipart/form-data">
                                @csrf

                                @if(isset($post))
                                    @method('patch')
                                @endif

                                <input type="hidden" name="status" value="2">

                                <button class="flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    </svg>
                                    <span class="text-sm text-gray-500">Reject</span>
                                </button>
                            </form>
                        @endif
                        <form method="post" action="{{ route('admin.post-destroy', $post) }}"  enctype="multipart/form-data">
                            @csrf

                            @if(isset($post))
                                @method('DELETE')
                            @endif

                            <button class="flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                </svg>
                                <span class="text-sm text-gray-500">Delete</span>
                            </button>
                        </form>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">0 Likes</span>
                        <span class="text-sm text-gray-500">0 Comments</span>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
