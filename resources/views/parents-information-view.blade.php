<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }} !
        </h2>
    </x-slot>

<div class="account">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <!-- table -->                                
                    <div class="mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Student Parent Information</h3>
                        </div>
                            
                        <div class="card-body relative">
                            <div class="row">
                                <div class="col">
                                    <label for="">Mothers name</label>
                                    <input type="text" class="form-control" placeholder="{{ optional($user[0]->parent_information)->mothers_name }}" disabled>
                                </div>
                                <div class="col">
                                    <label for="">Fathers name</label>
                                    <input type="text" class="form-control" placeholder="{{ optional($user[0]->parent_information)->fathers_name }}" disabled>
                                </div>
                            </div>   
                            <div class="row pt-4">
                                <div class="col">
                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control" placeholder="{{ optional($user[0]->parent_information)->contact_no }}" disabled>
                                </div>
                                <div class="col">
                                    <label for="">Address</label>
                                    <input type="text" class="form-control" placeholder="{{ optional($user[0]->parent_information)->address }}" disabled>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!-- /table -->
                </div>
            </div>
        </div>
    </div>
    
</div>

</x-app-layout>
