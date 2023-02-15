<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-lg font-medium mb-4">Create Activity</h1>
                    <form method="POST" action="{{ route('activites.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- activity instruction -->
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div>
                            <x-label class="mb-2" for="activity_instruction"
                                :value="__('Activity Instruction')" />

                            <textarea id="activity_instruction" name="activity_instruction"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('activity_instruction') }}</textarea>

                        </div>

                        <!-- Activity Name -->
                        <div class="mt-4">
                            <x-label for="activity_name" :value="__('Activity Name')" />

                            <x-input id="activity_name" class="block mt-1 w-full" type="text" name="activity_name"
                                :value="old('activity_name')" required autofocus />
                        </div>

                        {{-- activity file --}}
                        <div class="mt-4">
                            <x-label for="activity_file" :value="__('Upload File')" />

                            <x-input id="activity_file" class="block mt-1 w-full" type="file"
                                name="activity_file[]" multiple :value="old('activity_file')" required autofocus />

                        </div>


                        <!-- activity details -->
                        <div class="mt-4">
                            <x-label class="mb-2" for="activity_details" :value="__('Activity Details')" />

                            <textarea id="activity_details" name="activity_details"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('activity_details') }}</textarea>

                        </div>


                        <div class="flex items-center justify-center mt-4">
                            <x-button class="w-full flex items-center justify-center">
                                {{ __('Upload Activity') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>