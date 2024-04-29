<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Post Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Post your social media information and image.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @if(isset($post))
                                @method('patch')
                            @endif

                            <div>
                                <x-input-label for="content" :value="__('Content *')" />
                                <textarea id="content" name="content" class="mt-1 block w-full" required>{{ isset($post) ? old('content', $post->content) : old('content') }}</textarea>
                                <p class="text-sm">The maximum length of content is 100.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('content')" />
                            </div>

                            <div>
                                <x-input-label for="image" :value="__('Image')" />
                                <input id="image" name="image" type="file" class="mt-1 block w-full" accept="image/*" />
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ isset($post) ? __('Update') : __('Create') }}</x-primary-button>

                                @if (session('status') === 'post-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Post updated.') }}</p>
                                @elseif (session('status') === 'post-created')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Post created.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
