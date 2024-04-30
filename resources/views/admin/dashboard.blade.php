<x-app-layout>

    @if($posts->isEmpty())
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Welcome to the micro social media admin.
                    </div>
                </div>
            </div>
        </div>
    @endif

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

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200" style="border-collapse: collapse; width: 100%;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="border: 1px solid #e2e8f0;">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="border: 1px solid #e2e8f0;">
                                    Content
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="border: 1px solid #e2e8f0;">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="border: 1px solid #e2e8f0;">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="border: 1px solid #e2e8f0;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($posts as $post)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap" style="border: 1px solid #e2e8f0;">
                                    {{ $post->createdBy->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" style="border: 1px solid #e2e8f0;">
                                    {{ $post->content }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" style="border: 1px solid #e2e8f0;">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full rounded-lg" style="width: 100px;">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" style="border: 1px solid #e2e8f0;">
                                    @if ($post->status === 1)
                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            Active
                                        </span>
                                    @elseif($post->status === 2)
                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            Inactive
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" style="border: 1px solid #e2e8f0;">
                                    <a href="{{ route('admin.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
