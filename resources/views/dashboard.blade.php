<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome, {{auth()->user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table-auto">
  <thead>
    <tr>
      <th class="px-4 py-2">Team {{auth()->user()->currentTeam->name}}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        @foreach(auth()->user()->currentTeam->users as $u)
            <td class="border px-4 py-2">{{$u->name}}</td>
        @endforeach
    </tr>

  </tbody>
</table>
                        @if($result != "[]")
                        @if(count($result) <2)
                            <div class="flex justify-end">
                                <button class="bg-indigo-700 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <a href="./evaluation/create">Create Evaluation</a>
                                </button>
                            </div>
                        @endif
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
                        <table class="border table-fixed w-full">

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
                                    <td class="border px-4 py-2 text-center" >
                                         @if(!$r->isSubmit)
                                            <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                            <a href="./evaluation/{{$r->id}}">Update</a>
                                            @else
                                                <button disabled class="py-2 px-4 border">
                                                Submitted
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                        @endforeach
                    @else
                        <div class="flex justify-end">
                                <button class="bg-indigo-700 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <a href="./evaluation/create">Create Evaluation</a>
                                </button>
                            </div>
                        <div class="bg-indigo-50 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                          <p class="font-bold">No evaluation</p>
                          <p class="text-sm">please add some evaluation</p>
                        </div>
                            @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
