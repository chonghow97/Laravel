<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administrator
        </h2>
    </x-slot>

    <div class="py-12">
        <form method="get" action="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center border-b border-teal-500 py-2">
                <select name="Catergory" class="block appearance-none w-200 bg-gray-200 border border-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="studentID">ID</option>
                    <option value="Average">Average score</option>
                </select>
                <input name="search" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Jane Doe" aria-label="Full name">
                <input type="submit" class="flex-shrink-0 border-solid border-4" value="Search">
            </div>
            </form>
            <a href={{"/dashboard/?Sort=asc"}}>
                <button type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold
                hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Low to High</button></a></td>
            <a href={{"/dashboard/?Sort=desc"}}><button type="button" class="bg-transparent
            hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500
            hover:border-transparent rounded">High to low</button></a></td>
        <a href={{"/dashboard/"}}><button type="button" class="bg-transparent
            hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500
            hover:border-transparent rounded">Clear</button></a></td>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">

                <table class="border table-fixed w-full">
                        <tbody>

                        @if(count($result))
                                <tr class="bg-indigo-50">
                                        <th class="border px-4 py-2 text-center">ID</th>
                                        <th class="border px-4 py-2 text-center">Student Name</th>
                                        <th class="border px-4 py-2 text-center">Average Score</th>
                                        <th class="border px-4 py-2 text-center">Details</th>
                                </tr>
                                @foreach($result as $user)
                                    <tr class="border">
                                        <td class="px-4 py-2 text-center" >{{$user->username}}</td>
                                        <td class="px-4 py-2 text-center" >{{$user->name}}</td>
                                        @if($user->Average == null)
                                        <td class="px-4 py-2 text-center" >0</td>
                                        @else
                                            <td class="px-4 py-2 text-center" >{{$user->Average}}</td>
                                        @endif
                                        <td class="px-4 py-2 text-center" >
                                            <a href={{"/student/$user->id"}}><button type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">More Details</button></a></td>
                                    </tr>
                                @endforeach
                                    {{ $result->links() }}
                            @else
                                <tr class="bg-indigo-50">
                                        <th class="border px-4 py-2 text-center">No data found</th>
                                </tr>
                            @endif
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
