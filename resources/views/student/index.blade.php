<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$user[0]->name}}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Team {{$user[0]->team}}
            </h2>

            @foreach($result as $r)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
                     <table class="border table-fixed w-full">
                         <tr class="bg-indigo-50">
                             <th>Team Member</th>
                             <th>Rate</th>
                         </tr>
                         <tr>
                             <td>{{$r->name}}</td>
                             <td>{{$r->rate}}</td>
                         </tr>
                         <tr class="bg-indigo-50">
                             <th colspan="2">Comments</th>
                         </tr>
                         <tr>
                             <td>{{$r->description}}</td>
                         </tr>
                     </table>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
