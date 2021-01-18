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
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
