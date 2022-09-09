<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                     <form method="POST" action="{{route('update_profile_data',Auth::user()->id)}}">
                        @csrf()
                        <div class="mt-1">
                            <label>Name</label>
                            <input type="text" id="name" name="name"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                value="{{ Auth::user()->name }}" />
                        </div>

                        <div class="mt-1">
                            <label>Email</label>
                            <input type="text" id="name" name="email"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                value="{{ Auth::user()->email }}" />
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Update Profile</button>
                        </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

