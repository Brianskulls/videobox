<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User actions
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <section class="bg-indigo-dark h-50 p-8">
                        <div class="container mx-auto py-8">
                            <input oninput="updateTable()"
                                class="w-full h-16 px-3 rounded mb-8 focus:outline-none focus:shadow-outline text-xl px-8 shadow-lg"
                                type="search" placeholder="Search usernames..." id="search">
                            <nav class="flex">
                                <a class="no-underline text-white py-3 px-4 font-medium mr-3 bg-indigo hover:bg-indigo-darker"
                                   href="#">Cardamom</a>
                                <a class="no-underline text-white py-3 px-4 font-medium mx-3 bg-indigo-darker hover:bg-indigo"
                                   href="#">Cinnamon</a>
                                <a class="no-underline text-white py-3 px-4 font-medium mx-3 bg-indigo hover:bg-indigo-darker"
                                   href="#">Chamomille</a>
                                <a class="no-underline text-white py-3 px-4 font-medium mx-3 bg-indigo-darker hover:bg-indigo"
                                   href="#">Apple</a>
                                <a class="no-underline text-white py-3 px-4 font-medium mx-3 bg-indigo hover:bg-indigo-darker"
                                   href="#">Mint</a>
                                <a class="no-underline text-white py-3 px-4 font-medium mx-3 bg-indigo-darker hover:bg-indigo"
                                   href="#">Curry</a>
                                <a class="no-underline text-white py-3 px-4 font-medium mx-3 bg-indigo hover:bg-indigo-darker"
                                   href="#">Fragrance</a>
                                <a class="no-underline text-white py-3 px-4 font-medium ml-auto bg-indigo-darker hover:bg-indigo"
                                   href="#">Amchoor</a>
                            </nav>
                        </div>
                    </section>
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" width="50"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" width="50"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subject type
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action type
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Datetime
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 data-table">
                                @foreach ($activityLogs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($log->causer !== null)
                                                {{ $log->causer->name }}
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Test
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->subject_type }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->description }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>

        async function updateTable()
        {
            const tableEl = document.getElementsByClassName('data-table')[0];
            const inputEl = document.getElementById('search');

            while(tableEl.firstChild){
                tableEl.removeChild(tableEl.firstChild);
            }

            let urlAppend = '';

            if(inputEl.value !== '')
            {
                urlAppend = '?name=' + inputEl.value;
            }

            const data = await fetch('/activity-logs-ajax'+urlAppend)
            .then(res => res.json())
            .then(data => {
                return data;
            });

            console.log(data);

            let endStr = '';

            data.forEach((log) => {

                //Username
                let name = null;
                if(log.causer  === null) {name = ''} else {name = log.causer.name}

                //Subject type
                let subjectType = log.subject_type;

                //Action type
                let actionType = log.description;

                //Datetime
                let dateTime = log.created_at;

                let str = '<tr>\n' +
                    '                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">\n' +
                    '                                        ' + name + '\n' +
                    '                                        </td>\n' +
                    '\n' +
                    '                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">\n' +
                    '                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">\n' +
                    '                                                Test\n' +
                    '                                            </span>\n' +
                    '                                        </td>\n' +
                    '\n' +
                    '                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">\n' +
                    '                                        ' + subjectType + '\n' +
                    '                                        </td>\n' +
                    '\n' +
                    '                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">\n' +
                    '                                        ' + actionType + '\n' +
                    '                                        </td>\n' +
                    '\n' +
                    '                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">\n' +
                    '                                        ' + dateTime + '\n' +
                    '                                        </td>\n' +
                    '                                    </tr>';

                endStr += str;
            });

            tableEl.innerHTML = endStr;
        }


    </script>

</x-app-layout>
