<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($type === 'reporter')
                Videos grouped by reporter
            @elseif($type === 'subject')
                Videos grouped by subject
            @endif
        </h2>
    </x-slot>
    <div>
        <div class="max-w-6xl mx-auto py-10">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="container mx-auto">
                        <div class="flex flex-wrap px-6">
                            @foreach($loopables as $index => $loopable)
                                <div class="w-full md:px-4 lg:px-5 py-5">
                                    <div class="bg-white shadow sm:rounded-lg">
                                        <div class="border-b-2 border-gray-300 p-1.5 flex justify-center items-center">
                                            @if($type === 'reporter')
                                                <p>{{$loopable->name}}</p>
                                            @elseif($type === 'subject')
                                                <p>{{$index}}</p>
                                            @endif
                                        </div>
                                        <div class="px-2 py-2">
                                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                                <thead>
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Title
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Description
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="200">
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200 data-table">
                                                @if($type === 'reporter')
                                                    @foreach($loopable->videos as $video)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{$video->title}}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ \Illuminate\Support\Str::limit($video->description, 40, '...') }}
                                                            </td>
                                                            <td class="py-4 whitespace-nowrap text-sm text-gray-900">
                                                                <a href="{{ route('videos.show', $video->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">View</a>
                                                                <a href="{{ route('videos.edit', $video->id) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>
                                                                <form class="inline-block" action="{{ route('videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($type === 'subject')
                                                    @foreach($loopable as $video)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{$video->title}}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ \Illuminate\Support\Str::limit($video->description, 40, '...') }}
                                                            </td>
                                                            <td class="py-4 whitespace-nowrap text-sm text-gray-900">
                                                                <a href="{{ route('videos.show', $video->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">View</a>
                                                                <a href="{{ route('videos.edit', $video->id) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>
                                                                <form class="inline-block" action="{{ route('videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
