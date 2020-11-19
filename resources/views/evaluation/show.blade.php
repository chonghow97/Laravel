<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Evaluation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto">
            <div class="bg-white max-w-sm rounded overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <form action="/evaluation/{{$result->id}}" method="POST">
                        {{ method_field('PUT') }}
                        @csrf
                        <input type="hidden" id="userID" name="userID" value="{{auth()->user()["id"]}}">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                            Student
                        </label>

                        <select id="animal-select" disabled="true">
                            <option name="team_id" value="{{$result->team_id}}" selected>{{$result->name}}</option>
                        </select>
                        <!-- comment box -->
                        <label class="block mt-4">
                          <span class="text-gray-700">Comment</span>
                          <textarea name="comment" class="form-textarea mt-1 block w-full" rows="3" placeholder="Comment your rubbish teammate">{{$result->description}}</textarea>
                        </label>
                        <!-- end comment box -->
                        <!-- rating -->
                        <div class="mt-4">
                          <span class="text-gray-700">Rating</span>
                          <div class="mt-2">
                              @foreach(range(1,10) as $rate)
                                  <label class="inline-flex items-center ml-6">
                                      @if($rate == $result->rate)
                                    <input type="radio" class="form-radio" name="rating" value="{{$rate}}" checked>
                                    <span class="ml-2">{{$rate}}</span>
                                      @else
                                          <input type="radio" class="form-radio" name="rating" value="{{$rate}}">
                                          <span class="ml-2">{{$rate}}</span>
                                      @endif
                                  </label>
                              @endforeach
                          </div>
                        </div>
                        <!-- end rating -->
                        <!-- Submit button -->
                        <div class="mt-4 flex justify-end">
                            <button class="bg-indigo-50 px-4 ml-3" name="isSubmit" value="0">Save</button>
                            <button class="bg-indigo-50 px-4 ml-3" name="isSubmit" value="1">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
