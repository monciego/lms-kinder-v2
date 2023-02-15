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
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Quizzes</h3>
                            @if(Auth::user()->hasRole('teacher'))
                                <button type="button" class="add-quiz-trigger btn btn-primary rounded-1 px-5" data-bs-toggle="modal" data-bs-target="#quizModal"> New </button>
                            @endif
                        </div>
                            
                        <div id="success_message"> </div>
                        <div class="card-body relative">
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    
                                
                                    <thead>
                                        <tr>
                                            <th>Quiz</th>
                                            <th>Instruction</th>
                                            <th>Uploaded</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="quiz-list">
                                        @forelse ($quizzes as $quiz)
                                            <tr>
                                                <td> {{ $quiz->quiz_name }} </td>
                                                <td> {{ $quiz->instruction }} </td>
                                                <td> {{ Carbon\carbon::parse($quiz->created_at)->format('d/m/Y g:i A') }} </td> 
                                                <td> {{ Carbon\carbon::parse($quiz->deadline)->format('d/m/Y g:i A') }} </td>
                                                <td>
                                                    <a href=" {{ route('quizzes.show', $quiz->id ) }} " class="show-question btn btn-success mt-2"> Show </a> 
                                                    @if(Auth::user()->hasRole('teacher'))
                                                    <a href=" {{ route('show-quiz-responses', $quiz->id) }} "value=" quiz.id " class="btn btn-secondary mt-2"> Responses </a> 
                                                    <!-- <button type="button" value=" {{ $quiz->id }} " class="edit-quiz btn btn-primary mt-2"> Edit </button>  -->
                                                    <button type="button" value=" {{ $quiz->id }} " class="delete-quiz btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete </button> 
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty 
                                            <td>NO DATA FOUND</td>
                                        @endforelse
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
    <div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Add Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" enctype="multipart/form-data" id="store-quiz" action="javascript:void(0)" >
                    <div class="modal-body px-5">
                       <!-- input fields -->
                
                       <ul id="save_errlist"></ul>
                                                  
                            <input type="hidden" id="subject_id" name="subject_id" value="{{ $subject_id }}">
                            <input type="hidden" id="category" name="category" value="quiz">
                        
                            <!-- Quiz Name -->
                            <div>
                                <x-label for="quiz_name" :value="__('Quiz Name')" />
                                <x-input id="quiz_name" class="block mt-1 w-full" type="text" name="quiz_name" :value="old('quiz_name')" required autofocus />
                            </div>
                
                            <!-- Instruction -->
                            <div class="mt-4">
                                <x-label for="instruction" :value="__('Instruction')" />
                                <x-input id="instruction" class="block mt-1 w-full" type="text" name="instruction" :value="old('instruction')" />
                            </div>
                
                            <!-- Deadline -->
                            <div class="mt-4">
                                    <x-label for="deadline" :value="__('Deadline')" />
                                    <x-input id="deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline')" />
                            </div>
            
                        <!-- end- input fields -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save-quiz">Save</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- end- create modal -->

    <!-- edit modal -->
    <div class="modal fade" id="quizEditModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Edit Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    <!-- input fields -->
                    
                    <ul id="edit_errlist"></ul>
                                                    
                    <!-- Quiz id -->
                    
                    <input type="hidden" id="edit_quiz_id"> 
                                                    
                    <!-- Quiz Name -->
                    <div>
                        <x-label for="quiz_name" :value="__('Quiz Name')" />
                        <x-input id="edit_quiz_name" class="block mt-1 w-full" type="text" name="quiz_name" :value="old('quiz_name')" required autofocus />
                    </div>
        
                    <!-- Instruction -->
                    <div class="mt-4">
                        <x-label for="instruction" :value="__('Instruction')" />
                        <x-input id="edit_instruction" class="block mt-1 w-full" type="text" name="instruction" :value="old('instruction')" />
                    </div>
        
                    <!-- Deadline -->
                    <div class="mt-4">
                            <x-label for="deadline" :value="__('Deadline')" />
                            <x-input id="edit_deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline')" />
                    </div>
                
                    <!-- end- input fields -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-quiz">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- edit modal -->

    <!-- delete confirmation modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="material-icons">&#xE5CD;</i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger delete-quiz-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- delete confirmation modal -->

@section('scripts')

<script>
    
    $(document).ready(function () {
           
        // store
        $(document).on('submit','#store-quiz', function(e) { 
            e.preventDefault();
            
            var formData = new FormData(this);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var url = '{{ route("quizzes.store") }}';
            $.ajax({
                type: "POST",
                url: url, 
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    if(response.status == 400) { 
                        $('#save_errlist').html("");
                        $('#save_errlist').addClass("alert alert-danger");
                        $.each(response.errors, function (key, error_values) { 
                            $('#save_errlist').append('<li>'+ error_values +'</li>')
                        });
                    } else { 
                        $('#save_errlist').html("");
                        $('#save_errlist').removeClass("alert alert-danger");
                        $('#quizModal').modal('hide');
                        $('#quizModal').find('input').val("");
                        
                        Swal.fire(
                            'Good job!',
                            response.message,
                            'success'
                        )
                    }
                }
            });
            
        });
        
        
        // display delete modal
        var quiz_id;
        $(document).on('click', '.delete-quiz', function (e) {
            e.preventDefault();
            quiz_id = $(this).val(); 
            $('#deleteModal').modal('show');
        });
        
        
        // edit
        $(document).on('click', '.edit-quiz', function (e) {
            e.preventDefault();
        
            var quiz_id = $(this).val();
            $('#quizEditModal').modal('show');
        
            $.ajax({
                type: "GET",
                url: "/activities/quizzes/"+quiz_id+"/edit",
                success: function (response) {
                    console.log(response);
                    if (response.status == 404) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    } else { 
                        $('#edit_quiz_name').val(response.quiz.quiz_name);
                        $('#edit_instruction').val(response.quiz.instruction);
                        $('#edit_deadline').val(response.quiz.deadline);
                        $('#edit_quiz_id').val(quiz_id);
                    }
                    
                }
            });
            
        });
        
        
        // update 
        $(document).on('click', '.update-quiz', function (e) {
            e.preventDefault();
            
            var quiz_id = $('#edit_quiz_id').val();
            var data = { 
                'quiz_name': $('#edit_quiz_name').val(),
                'instruction': $('#edit_instruction').val(),
                'deadline': $('#edit_deadline').val(),
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: "PUT",
                url: "/activities/quizzes/"+quiz_id,
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if(response.status == 400) { 
                    
                        $('#edit_errlist').html("");
                        $('#edit_errlist').addClass("alert alert-danger");
                        $.each(response.errors, function (key, error_values) { 
                            $('#edit_errlist').append('<li>'+ error_values +'</li>')
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
                    
                        $('#edit_errlist').html("");
                        $('#edit_errlist').removeClass("alert alert-danger");
                        $('#quizEditModal').modal('hide');
                        $('#quizEditModal').find('input').val("");
                        
                        Swal.fire(
                            'Good job!',
                            response.message,
                            'success'
                        );
                        
                    }
                    
                }
            });
        });
        
        
        // destroy
        $(document).on('click', '.delete-quiz-btn', function (e) {
            e.preventDefault();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                
                type: "DELETE",
                url: "/activities/quizzes/"+quiz_id,
                
                success: function (response) {
        
                    $('#deleteModal').modal('hide');
                    
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    )
                }
            });
        });
        
    });
    
</script>

@endsection
</x-app-layout>

