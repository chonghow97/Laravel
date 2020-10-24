<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Team
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()["id"] != 1)
            <div class="flex justify-end">
                <button class="bg-indigo-700 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <a href="./evaluation/create">Create Evaluation</a>
                </button>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
                <table class="border table-fixed w-full">
                    @if(auth()->user()["id"] == 1)
                        <tbody>
                            @foreach(auth()->user()->ownedTeams as $team)
                                <tr class="bg-indigo-50">
                                    @if($team->id !=1)
                                        <th class="border px-4 py-2 " colspan="3">{{$team->name}}</th>
                                    @endif
                                </tr>
                                <tr class="bg-indigo-50">
                                    @if($team->id !=1)
                                        <th class="border px-4 py-2 text-center">ID</th>
                                        <th class="border px-4 py-2 text-center">Average Score</th>
                                        <th class="border px-4 py-2 text-center">Details</th>
                                    @endif
                                </tr>
                                @foreach($team->users as $user)
                                    <tr class="border">
                                        <td class="px-4 py-2 text-center" >{{$user->name}}</td>
                                        <td class="px-4 py-2 text-center" >0</td>
                                        <td class="px-4 py-2 text-center" ><button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">More Details</button></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <!-- check current id have evaluation -->
                        <!-- Select evaluations only user -->
                        <!-- linking team id to another table -->
                    @elseif($result = DB::table('evaluations')
                                        ->join('users', 'users.id', '=', 'evaluations.team_id')
                                        ->whereRaw('user_id = '.auth()->user()["id"].'', [0])
                                        ->get())
                        @if($result != "[]")
                        <tbody>
                            <tr class="bg-indigo-50">
                                <th class="border px-4 py-2 text-center">Student ID</th>
                                <th class="border px-4 py-2 text-center">Name</th>
                                <th class="border px-4 py-2 text-center">Action</th>
                            </tr>
                        </tbody>
                        @foreach($result as $r)
                                <tr>
                                    <td class="border px-4 py-2 text-center">{{$r->username}}</td>
                                    <td class="border px-4 py-2 text-center"> {{$r->name}}</td>
                                    <td class="border px-4 py-2 text-center" ><button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                            <a href="./evaluation/{{$r->id}}">Update</a>
                                        </button>
                                    </td>
                                </tr>
                        @endforeach
                    @else
                        <div class="bg-indigo-50 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                          <p class="font-bold">No evaluation</p>
                          <p class="text-sm">please add some evaluation</p>
                        </div>
                            @endif
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
