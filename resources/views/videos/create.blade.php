<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Video
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                @if (count($errors) > 0)
                    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-red-700 bg-red-100 border border-red-300 ">
                        <div slot="avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon w-5 h-5 mx-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <div class="text-xl font-normal  max-w-full flex-initial">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form method="post" action="{{ route('videos.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                            <input type="text" id="title" name="title" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('title', '') }}">
                            @error('title')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('description', '') }}</textarea>
                            @error('description')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="subject" class="block font-medium text-sm text-gray-700">Subject</label>
                            <select type="text" id="subject" name="subject" class="form-select rounded-md shadow-sm mt-1 block w-full" value="{{ old('subject', '') }}">
                                <option value="History">History</option>
                                <option value="Nature">Nature</option>
                                <option value="Technology">Technology</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Science">Science</option>
                                <option value="Sports">Sports</option>
                                <option value="Economy">Economy</option>
                                <option value="Culture">Culture</option>
                                <option value="Geography">Geography</option>
                            </select>
                            @error('subject')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="file" class="block font-medium text-sm text-gray-700">Video</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="thumbnail" class="block font-medium text-sm text-gray-700">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
