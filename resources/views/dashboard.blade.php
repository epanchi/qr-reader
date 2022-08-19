<x-app-layout>
    <x-slot name="header">
        <div class='float-right'>
            <a class="bg-green-600 text-white rounded-lg p-2 " href="{{ url('/upload') }}"> New file</a>
        </div>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Document scann
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    ID
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Filename
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    State
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Created At
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Updated at
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Actions
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $row)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $row->getKey() }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ $row->original_filename }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $row->status }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $row->created_at }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $row->updated_at }}
                                    </td>
                                    <td class="py-4 px-6">
                                        ACTIONS
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
