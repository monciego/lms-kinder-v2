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
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Puzzle Responses</h3>
                        </div>
                            
                        <div id="success_message"> </div>
                        <div class="card-body relative">
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    
                                
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Date Submitted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="account-list">
                                        @foreach($puzzle_responses as $puzzle_response)
                                            <tr>
                                                <td> {{ $puzzle_response->user->name }}</td>
                                                
                                                <td> {{ $puzzle_response->user->email }} </td>
                                                <td> {{ Carbon\carbon::parse($puzzle_response->created_at)->format('d/m/Y g:i A') }} </td>                                                
                                                <td>
                                                    <a href="{{ route('store-puzzle-response-teacher', [$puzzle_response->puzzle_id , $puzzle_response->user->id] ) }}" class="btn btn-primary"> Show </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
