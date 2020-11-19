<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Evaluation

        </h2>
    </x-slot>

    <div class="py-12">
        <div>

        </div>
        <div class="container mx-auto">

            <button class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                <a href="../dashboard">Back</a>
</button>
            <span class="container">
            </span>
            <div class="bg-white max-w-sm rounded overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <form action="/evaluation" method="POST">
                        @csrf
                        <input type="hidden" id="userID" name="userID" value="{{auth()->user()["id"]}}">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                            Student
                        </label>
                        <select name="student" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @if(1)


                            <!-- exclude those who evaluated -->
                                @foreach($result as $r)
                                    <option value="{{$r->id}}">{{$r->name}} </option>
                                @endforeach
                            @endif
                          </select>
                        <!-- comment box -->
                        <label class="block mt-4">
                          <span class="text-gray-700">Comment</span>
                          <textarea name="comment" class="form-textarea mt-1 block w-full" rows="3" placeholder="Comment your rubbish teammate"></textarea>
                        </label>
                        <!-- end comment box -->
                        <!-- rating -->
                        <div class="mt-4">
                          <span class="text-gray-700">Rating</span>
                          <div class="mt-2">
                              @foreach(range(1,10) as $rate)
                                  <label class="inline-flex items-center ml-6">
                                    <input type="radio" class="form-radio" name="rating" value="{{$rate}}">
                                    <span class="ml-2">{{$rate}}</span>
                                  </label>
                              @endforeach
                          </div>
                        </div>
                        <!-- end rating -->
                        <!-- Submit button -->
                        <div class="mt-4 flex justify-end">
                            <button class="bg-indigo-50 px-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
