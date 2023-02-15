<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }} !
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg c-container">
                <div class="bg-white">
                                                    
                     <!-- table -->                                
                     <div class="mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Shapes Response</h3>
                        </div>
                            
                        <div class="card-body relative shape">
                            
                            <div class="container mx-auto mt-4">
                                <div class="card" style="width: fit-content; max-width: 100%; margin: auto;">
                                    <div class="card-body" >
                                        <div class="display-contents"></div>
                                        
                                        
                                        <!--displays image using jquery  -->
                                        <div id="image_response_label_wrapper" class="d-flex justify-between">
                                            <p id="image_response_label"> Student Response: {{ $shape_responses[0]->user->name }}</p>
                                            <p id="image_response_score"> Score: {{ $shape_responses[0]->score }}  </p>
                                        </div>
                                        <img class="card-img pb-3" src="{{ asset('uploads/shape/'.$shape_responses[0]->shape->image) }}">
                                        <img src="{{ $shape_responses[0]->image_response }}" id="image_response_display" style="margin: auto; border: 1px solid #000;">
                                    </div>
                                    
                                </div>
                            </div>
                                
                        </div>
                    </div>
                    <!-- /table -->
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

