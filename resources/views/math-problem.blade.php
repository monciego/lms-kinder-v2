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
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Math Problem</h3>
                            <button type="button" class="add-quiz-trigger btn btn-primary rounded-1 px-5" data-bs-toggle="modal" data-bs-target="#quizModal"> New </button>
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
                <div class="modal-body px-5">
                    
                    <!-- input fields -->
                
                        <ul id="save_errlist"></ul>
                                                    
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
                    <button type="button" class="btn btn-primary save-quiz">Save</button>
                </div>
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
           
        // show  
        fetchQuiz();
        function fetchQuiz() { 
            var url = '{{ route("show-math-problem-quizzes") }}';
        
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    var count = 1; 
                    $('.quiz-list').html("");
                    
                    if (response.quizzes.length > 0) {
                        $.each(response.quizzes, function (key, quiz) { 
                            var created_at = new Date(quiz.created_at);
                            var created_at_formated = created_at.toString('dd-MMM-yyyy');
                            var deadline = new Date(quiz.deadline); 
                            var deadline_formated = deadline.toString('dd-MMM-yyyy');
                            var url = '{{ route("quizzes.show", ":id") }}';
                            url = url.replace(':id', quiz.id);
                            var response_url = '{{ route("show-quiz-responses", ":id") }}';
                            response_url = response_url.replace(':id', quiz.id);
                            
                            
                            $('.quiz-list').append(
                                '<tr>'+
                                    '<td>'+ quiz.quiz_name +'</td>'+
                                    '<td>'+ quiz.instruction +'</td>'+
                                    '<td>'+ created_at_formated +'</td>'+
                                    '<td>'+ deadline_formated +'</td>'+
                                    '<td>'+
                                        '<a href="'+ url +'" class="show-question btn btn-success"> Show </a> '+
                                        '<a href="'+ response_url +'" class="show-responses btn btn-secondary"> Response </a> '+
                                        '<button type"button" value="'+ quiz.id +'" class="edit-quiz btn btn-primary"> Edit </button> '+
                                        '<button type="button" value="'+ quiz.id +'" class="delete-quiz btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete </button> '+
                                    '</td>'+
                                '</tr>'
                            );
                            
                        });
                    } else { 
                        $('.quiz-list').append('<div class="no-data"> No data Found </div>')
                    }
                    
                    if (response.role == "teacher") {
                        $(".add-quiz-trigger").show();
                        $(".edit-quiz").show();
                        $(".delete-quiz").show();
                      
                        
                    }
                    else { 
                        $(".add-quiz-trigger").hide();
                        $(".edit-quiz").hide();
                        $(".delete-quiz").hide();
                        $(".show-responses").hide();
                    }
                    
                }
            });
        }
        
        // store
        $(document).on('click','.save-quiz', function(e) { 
            e.preventDefault();
            
            var data = {
            'quiz_name': $('#quiz_name').val(),
            'instruction': $('#instruction').val(),
            'deadline': $('#deadline').val(),
            'category': 'math-problem',
            }
            
            console.log(data);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/activities/quizzes", 
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
                    } else { 
                        $('#save_errlist').html("");
                        $('#save_errlist').removeClass("alert alert-danger");
                        $('#quizModal').modal('hide');
                        $('#quizModal').find('input').val("");
                        
                        fetchQuiz();
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
                        
                        fetchQuiz();
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
                    fetchQuiz();
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

