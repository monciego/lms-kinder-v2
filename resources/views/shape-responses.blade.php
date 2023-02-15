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
                                            <th>Submitted at</th>
                                            <th>Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="quiz-list">
                                        @foreach($student_responses as $student_response)
                                            <tr>
                                                <td> {{ $student_response->user->name }} </td>
                                                <td> {{ $student_response->user->email }} </td>
                                                <td> {{ Carbon\carbon::parse($student_response->created_at)->format('d/m/Y g:i A') }} </td>
                                                <td> {{ $student_response->score }} </td>
                                                <td>
                                                    <button value="{{ $student_response->id }}" class="btn btn-primary edit-score" data-bs-toggle="modal" data-bs-target="#responseModal"> Edit </button>
                                                    <a href="{{ route('show-shape-responses', [ $student_response->shape_id, $student_response->user->id ] ) }}" class="show-response-answers btn btn-success"> Show </a> 
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
    
    <!-- create modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Return Score </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    
                    <!-- input fields -->
                
                        <ul id="save_errlist"></ul>
                        <input type="hidden" name="shape_response_id" id="shape_response_id">             
                        <input type="hidden" name="user_id" id="user_id">             
                        <!-- Title -->
                        <div>
                            <x-label for="score" :value="__('Score')" />
                            <x-input id="score" class="block mt-1 w-full" type="text" name="score" :value="old('score')" required autofocus />
                        </div>
        
                    <!-- end- input fields -->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- create modal -->
    
  
@section('scripts')
    <script>  
            // edit 
    $(document).on('click', '.edit-score', function (e) {
        e.preventDefault();
        
        var shape_response_id = $(this).val();
        var url = "{{ route('return-shape-score', ':id') }}"    
        url = url.replace(":id" , shape_response_id);
        
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                console.log(response);
                if (response.status == 404) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                } else { 
                    $('#score').val(response.shape_response.score);
                    $('#shape_response_id').val(response.shape_response.id);
                    $('#user_id').val(response.shape_response.user_id);
                }
            }
        });
    });
    
    // update
    $(document).on('click', '.save', function (e) {
        e.preventDefault();
        
        var shape_response_id = $('#shape_response_id').val();
        var user_id = $('#user_id').val();
        var url = '{{ route("update-shape-score", ":id") }}';
        url = url.replace(':id', shape_response_id);
        
        var data = {
            'score': $('#score').val(),
        }
                    
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "PUT",
            url: url,
            data: data,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.status == 400) { 
                
                    $('#save_errlist').html("");
                    $('#save_errlist').addClass("alert alert-danger");
                    $.each(response.errors, function (key, error_values) { 
                        $('#save_errlist').append('<li>'+ error_values +'</li>')
                    });
                    
                } 
                else if(response.status == 404) { 
                
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                    
                }
                else { 
                
                    $('#save_errlist').html("");
                    $('#save_errlist').removeClass("alert alert-danger");
                    $('#responseModal').modal('hide');
                    $('#responseModal').find('input').val("");
                    
                    Swal.fire(
                        'Good job!',
                        response.message,
                        'success'
                    );
                    
                }
                
            }
        });
    });
    
    
    </script>
@endsection


</x-app-layout>

