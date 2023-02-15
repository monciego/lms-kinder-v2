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
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Shapes</h3>
                            <button type="button" class="create-modal-trigger btn btn-primary rounded-1 px-5" data-bs-toggle="modal" data-bs-target="#shapeModal"> New </button>
                        </div>
                            
                        <div id="success_message"> </div>
                        <div class="card-body relative">
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    
                                
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Instruction</th>
                                            <th>Uploaded</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="shape-list">
                                        
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
    <div class="modal fade" id="shapeModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Add Shape</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="store-shape" action="javascript:void(0)" >
                    <div class="modal-body px-5">
                        <!-- input fields -->
                        
                            <ul id="save_errlist"></ul>
                                                        
                
                            <!-- Image -->
                            <div class="mt-4">
                                <x-label for="image" :value="__('Image')" />
                                <x-input id="image" class="block mt-1 w-full border-0 shadow-none" type="file" name="image" />
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
                        <button type="submit" class="btn btn-primary save-shape">Save</button>
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
           
        // show  
        fetchShape();
        function fetchShape() { 
        
            var url = '{{ route("show-shape") }}';
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    var count = 1; 
                    $('.shape-list').html("");
                    
                    if (response.shapes.length > 0) {
                        $.each(response.shapes, function (key, shape) { 
                            var created_at = new Date(shape.created_at);
                            var created_at_formated = created_at.toString('dd-MMM-yyyy');
                            var deadline = new Date(shape.deadline); 
                            var deadline_formated = deadline.toString('dd-MMM-yyyy');
                                              
                            var url = '{{ route("shapes.show", ":id") }}';
                            url = url.replace(':id', shape.id);
                                      
                            var response_url = '{{ route("shape-responses", ":id") }}';
                            response_url = response_url.replace(':id', shape.id);
                                                        
                            $('.shape-list').append(
                                '<tr>'+
                                    '<td class="text-center">'+ count++ +'</td>'+
                                    '<td>'+ shape.instruction +'</td>'+
                                    '<td>'+ created_at_formated +'</td>'+
                                    '<td>'+ deadline_formated +'</td>'+
                                    '<td>'+
                                        '<a href="'+ url +'" class="show-shape btn btn-success"> Show </a> '+
                                        '<a href="'+ response_url +'" class="show-response btn btn-secondary"> Responses </a> '+
                                        '<button type="button" value="'+ shape.id +'" class="delete-shape btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete </button> '+
                                    '</td>'+
                                '</tr>'
                            );
                            
                        });
                    } else { 
                        $('.shape-list').append('<div class="no-data"> No data Found </div>')
                    }
                    
                    
                    if (response.role == 'teacher') {
                        $('.edit-shape').show(); 
                        $('.delete-shape').show(); 
                        $('.create-modal-trigger').show(); 
                    }
                    else { 
                        $('.edit-shape').hide(); 
                        $('.delete-shape').hide(); 
                        $('.create-modal-trigger').hide(); 
                        $('.show-response').hide(); 
                    }
                    
                    
                }
            });
        }
        
        // store
        $(document).on('submit','#store-shape', function(e) { 
            e.preventDefault();
            
            var formData = new FormData(this);
            console.log(formData);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var url = '{{ route("shapes.store") }}';
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
                        $('#shapeModal').modal('hide');
                        $('#shapeModal').find('input').val("");
                        
                        fetchShape();
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
        var shape_id;
        $(document).on('click', '.delete-shape', function (e) {
            e.preventDefault();
            shape_id = $(this).val(); 
            $('#deleteModal').modal('show');
            
        });
        
        
        // destroy
        $(document).on('click', '.delete-quiz-btn', function (e) {
            e.preventDefault();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var url = '{{ route("shapes.destroy", ":id") }}';
            url = url.replace(':id', shape_id);
                            
            $.ajax({
                
                type: "DELETE",
                url: url,
                
                success: function (response) {
        
                    $('#deleteModal').modal('hide');
                    fetchShape();
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

