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
                                                    
                    <div class="p-4 question d-flex flex-column gap-6 relative">
                        <div class="card mh-10 heading">
                        
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title pb-3 border-b quiz-name"> {{ $quiz->quiz_name }} </h5>
                                <p class="card-text fs-6 mb-0 quiz-instruction"> {{ $quiz->instruction }} </p>
                                <p class="card-text fs-6 mb-0 date-uploaded pt-2">Date uploaded: {{ Carbon\carbon::parse($quiz->created_at)->format('d/m/Y g:i A') }}</p>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text fs-6 mb-0 quiz-deadline">Deadline: {{ Carbon\carbon::parse($quiz->deadline)->format('d/m/Y g:i A') }} </p>
                                    @if(Auth::user()->hasRole('student'))
                                        <p class="card-text fs-6 mb-0 score">Score:  @if($count ==  0) {{$score}} @else __ @endif / {{ $count_total_question }} </p>
                                    @endif
                                </div>
                                @if(Auth::user()->hasRole('teacher'))
                                    <button type="button" class="add-question-trigger mt-2 btn btn-primary rounded-1 px-5" style="width: fit-content; float: right" data-bs-toggle="modal" data-bs-target="#questionModal"> Add </button>
                                @endif
                            </div>
                     
                        </div>
   
                        <!-- display question -->
                        <input type="hidden" id="quiz-id" value="{{ $quiz_id }}">
                       
                        <div class="display_questions">
                        @foreach($questions as $question)
                            <div class="card mh-10 questions-wrapper" >
                                <div class="card-body d-flex flex-column justify-content-center">
                               
                                    <div class="input-fields">
                                        @if($question->image != null)
                                        <div class="image-wrapper m-auto" style="width: 40%; aspect-ratio: 1/1; object-fit: contain">
                                            <img src="{{ asset('uploads/quiz/' .$question->image ) }}" class="d-block">
                                        </div>
                                        @endif
                                        <div class="field__input relative question_content">
                                                                                        
                                            <input disabled type="text" class="w-full border-0" id="question_display" value="{{ $question->question }}"> 
                                            
                                            @if(Auth::user()->hasRole('teacher'))
                                                <div class="d-flex">
                                                    <!-- <button class="btn btn-primary mx-2 edit-question" value=" {{ $question->id }} "> Edit </button> -->
                                                    <button class="btn btn-danger delete-question" value=" {{ $question->id }} "> Delete </button>
                                                </div>
                                            @endif
                                        </div>
                                                                    
                                        <!-- choices teacher-->
                                        <div class="choices-display__wrapper pt-4">
                                        
                                                <div class="field__input relative d-flex items-center">
                                                    <input @if(Auth::user()->hasRole('teacher'))) disabled @endif value=" {{ $question->option_1 }} " @if($question->option_1 == $question->key_answer &&  Auth::user()->hasRole('teacher')) checked @endif type="radio" name="{{ $question->id }}" id="option_1_display" class="option_1_display option_display mr-2" placeholder="Option 1">
                                                    <label for="{{ $question->id }}"> {{ $question->option_1 }}  </label>
                                                </div>
                                                
                                                <div class="field__input relative d-flex items-center">
                                                    <input @if(Auth::user()->hasRole('teacher'))) disabled @endif value=" {{ $question->option_2 }} " @if($question->option_2 == $question->key_answer  &&  Auth::user()->hasRole('teacher')) checked @endif type="radio" name="{{ $question->id }}" id="option_2_display" class="option_2_display option_display mr-2" placeholder="Option 2">
                                                    <label for="{{ $question->id }}">  {{ $question->option_2 }}  </label>
                                                </div>
                                                
                                                <div class="field__input relative d-flex items-center">
                                                    <input @if(Auth::user()->hasRole('teacher'))) disabled @endif value=" {{ $question->option_3 }} " @if($question->option_3 == $question->key_answer  &&  Auth::user()->hasRole('teacher')) checked @endif type="radio" name="{{ $question->id }}" id="option_3_display" class="option_3_display option_display mr-2" placeholder="Option 3">
                                                    <label for="{{ $question->id }}">  {{ $question->option_3 }}  </label>
                                                </div>
                                                
                                                <div class="field__input relative d-flex items-center">
                                                    <input @if(Auth::user()->hasRole('teacher'))) disabled @endif value=" {{ $question->option_4 }} " @if($question->option_4 == $question->key_answer  &&  Auth::user()->hasRole('teacher')) checked @endif type="radio" name="{{ $question->id }}" id="option_4_display" class="option_4_display option_display mr-2" placeholder="Option 4">
                                                    <label for="{{ $question->id }}">  {{ $question->option_4 }}  </label>
                                                </div>
                                                
                                                @if(Auth::user()->hasRole('student')) 
                                                <button type="submit" class="btn btn-primary mt-2 submit-answer" data-id="{{ $question->id }}"> Submit </button> 
                                                @endif 
                                        </div>
                                        <!-- end- choices teacher -->

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        
                        @if(Auth::user()->hasRole('student')) 
                            @if($count == 0)
                                @foreach($answered_questions as $answered_question)
                                    <div class="card mh-10 questions-wrapper" >
                                        <div class="card-body d-flex flex-column justify-content-center">
                                    
                                            <div class="input-fields">
                                                
                                                <ul id="save_errlist"> </ul>
                                                <div class="field__input relative question_content">
                                                                                                
                                                    <input disabled type="text" class="w-full border-0" id="question_display" value="{{ $answered_question->question }}"> 
                                                    
                                                    @if(Auth::user()->hasRole('teacher'))
                                                        <div class="d-flex">
                                                            <button class="btn btn-primary mx-2 edit-question" value=" {{ $answered_question->id }} "> Edit </button>
                                                            <button class="btn btn-danger delete-question" value=" {{ $answered_question->id }} "> Delete </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                                            
                                                <!-- choices teacher-->
                                                <div class="choices-display__wrapper pt-4">
                                                
                                                        <div class="field__input relative d-flex items-center">
                                                            <input disabled value=" {{ $answered_question->option_1 }} " @if($answered_question->option_1 == $answered_question->key_answer) checked @endif type="radio" name="{{ $answered_question->id }}" id="option_1_display" class="option_1_display option_display mr-2" placeholder="Option 1">
                                                            <label for="{{ $answered_question->id }}"> {{ $answered_question->option_1 }}  </label>
                                                        </div>
                                                        
                                                        <div class="field__input relative d-flex items-center">
                                                            <input disabled value=" {{ $answered_question->option_2 }} " @if($answered_question->option_2 == $answered_question->key_answer ) checked @endif type="radio" name="{{ $answered_question->id }}" id="option_2_display" class="option_2_display option_display mr-2" placeholder="Option 2">
                                                            <label for="{{ $answered_question->id }}">  {{ $answered_question->option_2 }}  </label>
                                                        </div>
                                                        
                                                        <div class="field__input relative d-flex items-center">
                                                            <input disabled value=" {{ $answered_question->option_3 }} " @if($answered_question->option_3 == $answered_question->key_answer ) checked @endif type="radio" name="{{ $answered_question->id }}" id="option_3_display" class="option_3_display option_display mr-2" placeholder="Option 3">
                                                            <label for="{{ $answered_question->id }}">  {{ $answered_question->option_3 }}  </label>
                                                        </div>
                                                        
                                                        <div class="field__input relative d-flex items-center">
                                                            <input disabled value=" {{ $answered_question->option_4 }} " @if($answered_question->option_4 == $answered_question->key_answer ) checked @endif type="radio" name="{{ $answered_question->id }}" id="option_4_display" class="option_4_display option_display mr-2" placeholder="Option 4">
                                                            <label for="{{ $answered_question->id }}">  {{ $answered_question->option_4 }}  </label>
                                                        </div>
                                                
                                                </div>
                                                
                                                @foreach($answered_question->responses as $response)
                                                    <div class="mt-2 p-3 text-white fw-bold rounded-2 @if($response->answer == $answered_question->key_answer) bg-success @else bg-danger @endif    ">Your answer:  {{ $response->answer }} </div>
                                                @endforeach
                                                <!-- end- choices teacher -->

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                        </div>
                           
                        <!-- end- display questions -->
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- create modal -->
    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Add Question </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <form method="POST" enctype="multipart/form-data" id="store-question" action="javascript:void(0)" >
                    <div class="modal-body px-5">
                         <!-- question -->
                         <div class="card border-0 mh-10 questions-wrapper">
                            <div class="card-body d-flex flex-column justify-content-center">
                                
                                <ul id="save_errlist"> </ul>
                                <!-- input fields -->
                                <input type="hidden" name="quiz_id" id="save_quiz_id" value="{{$quiz_id}}">
                                
                                <div class="input-fields">
                                     <!-- image -->
                                     <div class="field__input relative mt-2">
                                        <input type="file" name="image" id="image" class="w-full input border-0" placeholder="Image">
                                    </div>
                                    <!-- end- image -->
                                
                                    <!-- question -->
                                    <div class="field__input relative mt-2">
                                        <input type="text" name="question" id="question" class="w-full input" placeholder="Type your question...">
                                    </div>
                                    <!-- end- question -->
                                    
                                    <!-- choices -->
                                    <div class="choices-wrapper pt-3">
                                    
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_1" id="option_1" class="w-full input" placeholder="Option 1">
                                        </div>
                                        
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_2" id="option_2" class="w-full input" placeholder="Option 2">
                                        </div>
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_3" id="option_3" class="w-full input" placeholder="Option 3">
                                        </div>
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_4" id="option_4" class="w-full input" placeholder="Option 4">
                                        </div>
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <select name="key_answer" id="key_answer" class="w-full input">
                                                <option value="" id="selected" selected>--Select Answer--</option>
                                                <option id="key_answer_1"></option>
                                                <option id="key_answer_2"></option>
                                                <option id="key_answer_3"></option>
                                                <option id="key_answer_4"></option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <!-- end- choices -->
                                    
                                </div>
                                <!-- end- input-fields -->
                                
                            </div>
                        </div>
                        <!-- end- question -->
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save-puzzle">Save</button>
                    </div>
                </form>
               
               
            </div>
        </div>
    </div>
    <!-- end- create modal -->
    
     <!-- edit modal -->
    <div class="modal fade" id="questionEditModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Edit Question </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                
                        <!-- question -->
                        <div class="card border-0 mh-10 edit-questions-wrapper">
                            <div class="card-body d-flex flex-column justify-content-center">
                                
                                <ul id="save_errlist"></ul>
                                <!-- input fields -->
                                <input type="hidden" name="quiz_id" id="save_quiz_id" value="{{$quiz_id}}">
                                
                                <div class="input-fields">
                                    <!-- question -->
                                    <div class="field__input relative mt-2">
                                        <input type="text" name="question" id="e-question" class="w-full input" placeholder="Type your question...">
                                    </div>
                                    <!-- end- question -->
                                    
                                    <!-- choices -->
                                    <div class="choices-wrapper pt-3">
                                    
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_1" id="e-option_1" class="w-full input" placeholder="Option 1">
                                        </div>
                                        
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_2" id="e-option_2" class="w-full input" placeholder="Option 2">
                                        </div>
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_3" id="e-option_3" class="w-full input" placeholder="Option 3">
                                        </div>
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <div class="circle"> </div>
                                            <input type="text" name="option_4" id="e-option_4" class="w-full input" placeholder="Option 4">
                                        </div>
                                        
                                        <div class="field__input relative d-flex items-center">
                                            <select name="e-key_answer" id="e-key_answer" class="w-full input">
                                                <option id="e-key_answer_1" value=""></option>
                                                <option id="e-key_answer_2" value=""></option>
                                                <option id="e-key_answer_3" value=""></option>
                                                <option id="e-key_answer_4" value=""></option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <!-- end- choices -->
                                    
                                </div>
                                <!-- end- input-fields -->
                                
                            </div>
                        </div>
                        <!-- end- question -->
        
                   
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-question">Save</button>
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
    // get current data
    var date = new Date();
	var current_date = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+ date.getDate();
    
    var deadline = $('.quiz-deadline').html();
    deadline = deadline.replace('Deadline:', '');
    
    if(current_date < deadline) { 
        console.log($('.choices-display__wrapper input'));
        $('.choices-display__wrapper input').attr('disabled','disabled');
        $('.submit-answer').hide();
        $('.quiz-deadline').addClass('text-danger');
    }
    

    fetchQuestion()
    function fetchQuestion() { 
        var quiz_id = $('#quiz-id').val();
        
        var url = '{{ route("quizzes.show", ":id") }}'
        url = url.replace(':id', quiz_id);
        
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                
                if (response.count == 0 && response.result_existance == 0) {
                    var data = {
                        'score': response.score,
                        'quiz_id': quiz_id,
                    }
                    console.log('score: ', response.score, 'data', data);  
                    var url = '{{ route("store-result") }}';

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax({
                        type: "POST",
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
                                
                            } else { 
                            
                                fetchQuestion();
                            }
                        }
                    });
                }
                
            }
        });
    }
    
    
    // submit response
    $(document).on('click', '.submit-answer', function (e) {
        e.preventDefault();
        
        var data = {
            'answer': $('input[name="'+$(this).attr('data-id')+'"]:checked').val(),
            'question_id': $(this).attr('data-id'),
        }
        
        var url = '{{ route("responses.store") }}';
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "POST",
            url: url, 
            data: data,
            dataType: "json",
            success: function (response) {
                
                if(response.status == 400) { 
                
                    $('#save_errlist').html("");
                    $('#save_errlist').addClass("alert alert-danger");
                    $.each(response.errors, function (key, error_values) { 
                        $('#save_errlist').append('<li>'+ error_values +'</li>')
                    });
                    
                } else { 
                       
                    window.location.reload(); 
                }
            }
        });
    });
    
    // adding key answers data
    $(document).on('focusout','.questions-wrapper input', function (e) {
        e.preventDefault();
        $('#key_answer_1').val($('#option_1').val());
        $('#key_answer_2').val($('#option_2').val());
        $('#key_answer_3').val($('#option_3').val());
        $('#key_answer_4').val($('#option_4').val());

        $('#key_answer_1').html($('#option_1').val());
        $('#key_answer_2').html($('#option_2').val());
        $('#key_answer_3').html($('#option_3').val());
        $('#key_answer_4').html($('#option_4').val());
    });
    
    // store
    // $(document).on('click','.save-question', function(e) { 
    //     e.preventDefault();
    //     var data = {
    //         'question': $('#question').val(),
    //         'option_1': $('#option_1').val(),
    //         'option_2': $('#option_2').val(),
    //         'option_3': $('#option_3').val(),
    //         'option_4': $('#option_4').val(),
    //         'key_answer': $('#key_answer').val(),
    //         'quiz_id': $('#save_quiz_id').val(),
    //     }
                
    //     var url = '{{ route("questions.store") }}';
                
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
        
    //     $.ajax({
    //         type: "POST",
    //         url: url, 
    //         data: data,
    //         dataType: "json",
    //         success: function (response) {
    //             if(response.status == 400) { 
                
    //                 $('#save_errlist').html("");
    //                 $('#save_errlist').addClass("alert alert-danger");
    //                 $.each(response.errors, function (key, error_values) { 
    //                     $('#save_errlist').append('<li>'+ error_values +'</li>')
    //                 });
                    
    //             } else { 
    //                 $('#questionModal').modal('hide');
    //                 Swal.fire(
    //                     'Good job!',
    //                     response.message,
    //                     'success'
    //                 )
    //             }
    //         }
    //     });
        
    // });
    
    // store
    $(document).on('submit','#store-question', function(e) { 
        e.preventDefault();
        
        var formData = new FormData(this);
        console.log(formData);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var url = '{{ route("questions.store") }}';
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
                    $('#questionModal').modal('hide');
                    $('#questionModal').find('input').val("");
                    
                    Swal.fire(
                        'Good job!',
                        response.message,
                        'success'
                    )
                }
            }
        });
        
    });
    
    //edit
    var question_id;
    $(document).on('click', '.edit-question' , function (e) {
        e.preventDefault();
        $('#questionEditModal').modal('show');
        
        question_id = $(this).val(); 
        var url = "{{ route('questions.edit', ':id') }}";
        url = url.replace(':id', question_id) ;
      
        var data = {
            'id': $(this).val(),
        } 
        
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
                    $('#e-question').val(response.question.question);
                    $('#e-option_1').val(response.question.option_1);
                    $('#e-option_2').val(response.question.option_2);
                    $('#e-option_3').val(response.question.option_3);
                    $('#e-option_4').val(response.question.option_4);
                                        
                   
                    
                    $('#e-key_answer_1').val($('#e-option_1').val());
                    $('#e-key_answer_2').val($('#e-option_2').val());
                    $('#e-key_answer_3').val($('#e-option_3').val());
                    $('#e-key_answer_4').val($('#e-option_4').val());
                    
                    $('#e-key_answer_1').html($('#e-option_1').val());
                    $('#e-key_answer_2').html($('#e-option_2').val());
                    $('#e-key_answer_3').html($('#e-option_3').val());
                    $('#e-key_answer_4').html($('#e-option_4').val());
                    
                    if ($('#e-key_answer_1').val() == response.question.key_answer ) {
                        $('#e-key_answer_1').attr("selected","selected");
                    }
                    if ($('#e-key_answer_2').val() == response.question.key_answer ) {
                        $('#e-key_answer_2').attr("selected","selected");
                    }
                    if ($('#e-key_answer_3').val() == response.question.key_answer ) {
                        $('#e-key_answer_3').attr("selected","selected");
                    }
                    if ($('#e-key_answer_4').val() == response.question.key_answer ) {
                        $('#e-key_answer_4').attr("selected","selected");
                    }
                    
                    $(document).on('focusout', '.edit-questions-wrapper input' , function () {
                        $('#e-key_answer_1').val($('#e-option_1').val());
                        $('#e-key_answer_2').val($('#e-option_2').val());
                        $('#e-key_answer_3').val($('#e-option_3').val());
                        $('#e-key_answer_4').val($('#e-option_4').val());
                        
                        $('#e-key_answer_1').html($('#e-option_1').val());
                        $('#e-key_answer_2').html($('#e-option_2').val());
                        $('#e-key_answer_3').html($('#e-option_3').val());
                        $('#e-key_answer_4').html($('#e-option_4').val());
                    });

                }
                
            }
        });
        
    });
   
    
    // update
    $(document).on('click', '.update-question', function (e) {
        e.preventDefault();
        
        var url = '{{ route("questions.update", ":id") }}';
        url = url.replace(':id', question_id);
        
        var data = {
            'question': $('#e-question').val(),
            'option_1': $('#e-option_1').val(),
            'option_2': $('#e-option_2').val(),
            'option_3': $('#e-option_3').val(),
            'option_4': $('#e-option_4').val(),
            'key_answer': $('#e-key_answer').children("option:selected").val(),
        }
        
        console.log($('#e-key_answer'));
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
                    $('#questionEditModal').modal('hide');
                    $('#questionEditModal').find('input').val("");
                    
                    Swal.fire(
                        'Good job!',
                        response.message,
                        'success'
                    );
                    
                }
                
            }
        });
    });
    
    
    // display delete modal
    var question_id;
    $(document).on('click', '.delete-question', function (e) {
        e.preventDefault();
        question_id = $(this).val(); 
        $('#deleteModal').modal('show');
    });
    
    
    // destroy
     $(document).on('click', '.delete-quiz-btn', function (e) {
        e.preventDefault();
                
        var url = '{{ route("questions.destroy", ":id") }}';
        url = url.replace(':id', question_id);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            
            type: "DELETE",
            url: url,
            
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
    
</script>

@endsection
</x-app-layout>