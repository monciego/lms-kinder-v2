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
                                    <p class="card-text fs-6 mb-0 score">Score: {{ $quiz->results[0]->score }} / {{ $count_total_question }} </p>
                                </div>
                            </div>
                     
                        </div>
                        @foreach($answered_questions as $answered_question)
                            <div class="card mh-10 questions-wrapper" >
                                <div class="card-body d-flex flex-column justify-content-center">
                            
                                    <div class="input-fields">
                                        
                                        <ul id="save_errlist"> </ul>
                                        <div class="field__input relative question_content">
                                                                                        
                                            <input disabled type="text" class="w-full border-0" id="question_display" value="{{ $answered_question->question }}"> 
                                            
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
                                            <div class="mt-2 p-3 text-white fw-bold rounded-2 @if($response->answer == $answered_question->key_answer) bg-success @else bg-danger @endif    ">Response:  {{ $response->answer }} </div>
                                        @endforeach
                                        <!-- end- choices teacher -->

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>