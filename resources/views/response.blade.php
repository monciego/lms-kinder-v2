<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }}!
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg c-container">
                <div class="bg-white">
                                                    
                     <!-- table -->                                
                     <div class="mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Responses</h3>
                        </div>
                            
                        <div id="success_message"> </div>
                        <div class="card-body relative">
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    
                                
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Quiz</th>
                                            <th>Submitted at</th>
                                            <th>Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="quiz-list">
                                        @foreach($results as $result)
                                            <tr>
                                                <td> {{ $result->user->name }}</td>
                                                <td> {{ $result->user->email }}</td>
                                                <td> {{ $result->quiz->quiz_name }}</td>
                                                <td> {{ Carbon\carbon::parse($result->created_at)->format('d/m/Y g:i A') }} </td>
                                                <td> {{ $result->score }} / {{ $questions_count }} </td>
                                                <td>
                                                    <a href="{{ route('show-quiz-response-answers' , [$result->user->id , $result->quiz_id ] ) }}" class="show-response-answers btn btn-success mt-2"> Show </a> 
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
    
</x-app-layout>

