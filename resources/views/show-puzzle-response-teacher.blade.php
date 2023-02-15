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
                                                    
                                                 
                     <div class="mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Puzzle</h3>
                          
                        </div>
                        <ul id="save_errlist"></ul>
                        
                        <div class="card-body relative">
                            
                            <h4 class="text-center">{{  $response[0]->title }} </h4>
                            <p class="text-center text-md m-0">Uploaded: {{ Carbon\carbon::parse($response[0]->created_at)->format('d/m/Y g:i A') }} </p>
                            <p class="text-center text-md m-0 pb-3">Deadline: {{ Carbon\carbon::parse($response[0]->deadline)->format('d/m/Y g:i A') }} </p>
                            <p class="text-center text-md m-0 pb-3">Score: {{ $response[0]->score }} <button value="{{ $response[0]->id }}" class="ml-2 bg-primary px-4 rounded text-white return-score"> Edit </button> </p>
                            
                            <div class="d-flex justify-center">
                                <div class="d-flex justify-center items-center flex-column">
                                   
                                        <p class="m-0"> Student Work </p>
                                        <div id="previews"> <img src="{{ $response[0]->image }}" class="d-block mini"> </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /table -->
                    
                </div>
            </div>
        </div>
    </div>


    <!-- edit modal -->
    <div class="modal fade" id="puzzleEditModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Update Score</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    <!-- input fields -->
                    
                    <ul id="edit_errlist"></ul>
                                                    
                    <!-- account id -->
                    <input type="hidden" id="puzzle_response_id">
                    
                    <!-- Name -->
                    <div>
                        <x-label for="score" :value="__('Score')" />
                        <x-input id="score" class="block mt-1 w-full" type="text" name="scores" required autofocus />
                    </div>
        
                    <!-- end- input fields -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-score">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- edit modal -->

<style>
    #canvas {
        width: 336px;
        height: 335px;
        border: 1px solid gray;
        background-color: black; 
        margin: 0 3rem 3rem 3rem;
    }
    #canvas #windiv {
        display: none; 
    }
    #canvas .banner {
        width: 370px;
        font-size: 50px;
        background-color: #f5f5dc;
        position: relative;
        text-align: center;
        top: -60px;
        box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.55);
        left: -15px;
        z-index: 2; 
    }
    #canvas .innerSquare {
        width: 110px;
        height: 110px;
        float: left; 
    }
    #canvas .innerSquare.imageSquare {
        font-size: 24px;
        text-align: center;
        border: 1px outset  black; 
    }
    #canvas .innerSquare.imageSquare:hover {
        background-color: lightgray; 
    }
    #canvas .innerSquare.clickable:hover {
        opacity: 0.4;
        filter: alpha(opacity=40); 
    }
    #canvas .innerSquare.blank {
        border: 1px inset black; 
    }
    #previews {
        display: flex; 
        width: fit-content;
        height: fit-content;
        max-width: 100%; 
        max-height: 100%; 
        margin: 0 3rem 3rem 3rem;
    }
    #previews .mini {
        width: 335px;
        height: 335px;
    }


</style>

@section('scripts')
<script>   

     // edit 
     $(document).on('click', '.return-score', function (e) {
        e.preventDefault();
        var puzzle_response_id = $(this).val();
        
        var url = "{{ route('edit-score', ':id') }}";
        url = url.replace(':id', puzzle_response_id);
        $('#puzzleEditModal').modal('show');
        
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
                    $('#score').val(response.puzzle_response.score);
                    $('#puzzle_response_id').val(response.puzzle_response.id);
                }
                
            }
        });
    });
    
     // // update 
    $(document).on('click', '.update-score', function (e) {
        e.preventDefault();
        
        var puzzle_response_id = $('#puzzle_response_id').val();
        var url = "{{ route('update-score', ':id') }}"
        url = url.replace(':id' , puzzle_response_id); 
        
        var data = { 
            'score': $('#score').val(),
        }
        
        console.log(data);                
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
                
                if(response.status == 404) { 
                
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                    
                }
                else { 
                
                    $('#puzzleEditModal').modal('hide');
                    $('#puzzleEditModal').find('input').val("");
                    
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

