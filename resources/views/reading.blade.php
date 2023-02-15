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
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Reading</h3>
                            <button type="button" class="add-quiz-trigger btn btn-primary rounded-1 px-5" data-bs-toggle="modal" data-bs-target="#readingModal"> New </button>
                        </div>
                            
                        <div id="success_message"> </div>
                        <div class="card-body relative">
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    
                                
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Uploaded</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="quiz-list">
                                        @foreach($readings as $reading)
                                        <tr>
                                            <td>{{ $reading->title }}</td>
                                            <td>{{ Carbon\carbon::parse($reading->created_at)->format('d/m/Y g:i A') }}</td>
                                            <td> 
                                                <button class="btn btn-success show-reading" value="{{ $reading->id }}"> Show</button>
                                                @if(Auth::user()->hasRole('teacher'))
                                                <button class="btn btn-primary edit-reading" value="{{ $reading->id }}"> Edit</button>
                                                <button class="btn btn-danger delete-reading" value="{{ $reading->id }}"> Delete</button>
                                                @endif
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
    <div class="modal fade" id="readingModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Add Reading</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    
                    <!-- input fields -->
                
                        <ul id="save_errlist"></ul>
                                                    
                        <!-- Title -->
                        <div>
                            <x-label for="title" :value="__('Title')" />
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>
            
                        <!-- Instruction -->
                        <div class="mt-4">
                            <x-label for="content" :value="__('Content')" />
                           <textarea name="content" id="content" class="rounded-1" cols="20" rows="5"> </textarea>
                        </div>
        
                    <!-- end- input fields -->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-reading">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- create modal -->
    
     <!-- edit modal -->
     <div class="modal fade" id="readingEditModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Edit Reading</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    
                    <!-- input fields -->
                
                        <ul id="edit_errlist"></ul>
                                                    
                                                    
                        <input type="hidden" id="edit_reading_id">
                        <!-- Title -->
                        <div>
                            <x-label for="e-title" :value="__('Title')" />
                            <x-input id="e-title" class="block mt-1 w-full" type="text" name="e-title" required autofocus />
                        </div>
            
                        <!-- Instruction -->
                        <div class="mt-4">
                            <x-label for="e-content" :value="__('Content')" />
                           <textarea name="e-content" id="e-content" class="rounded-1" cols="20" rows="5"> </textarea>
                        </div>
        
                    <!-- end- input fields -->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-reading">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- edit modal -->
    
    <!-- show modal -->
    <div class="modal fade" id="readingShowModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body px-5">
                  
                <!-- input fields -->                                                    
                
                    <!-- Title -->
                    <div>
                        <x-label for="s-title" :value="__('Title')" />
                        <x-input disabled id="s-title" class="block mt-1 w-full" type="text" name="s-title" required autofocus />
                    </div>
                    
                    <!-- Content -->
                    <div class="mt-4">
                        <p class="m-0"> Content </p>
                        
                        <div class="s-content border p-2 mb-5" style="min-height: 10rem;" id="s-content"> </div>
                    </div>
                    
                    
                    <div class="d-flex gap-2 justify-center">
                        <button class="btn btn-primary read" onclick="speak('div.s-content')"> Read </button>
                        <button class="btn btn-warning pause" onclick="pause()"> Pause </button>
                        <button class="btn btn-success resume" onclick="resume()"> Resume </button>
                        <button class="btn btn-danger stop" onclick="stop()"> Stop </button>
                    </div>
                <!-- end- input fields -->
                    
                </div>
                
            </div>
        </div>
    </div>
    <!-- end- show modal -->
    
    <!-- delete modal -->
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
                    <button type="button" class="btn btn-danger delete-reading-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- delete modal -->
    
    
<style>


</style>
    
@section('scripts')

<script>
    function speak(obj) {
        $(obj).articulate('speak');
    };

    function pause() {
        $().articulate('pause');
    };

    function resume() {
        $().articulate('resume');
    };

    function stop() {
        $().articulate('stop');
    };
    
    $(document).on('click', '.btn-close' , function (e) {
        e.preventDefault(); 
        stop();
    });
    
    // show
    $(document).on('click', '.show-reading' , function (e) {
        e.preventDefault();
        
        $('#readingShowModal').modal('show');
        
        var reading_id = $(this).val();
        
        var url = '{{ route("reading.show" , ":id") }}';
        url = url.replace(':id', reading_id);
        
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response);
                
                $('#s-title').val(response.reading.title);
                $('#s-content').html(response.reading.content);
                
            }
        });
        
    });
    
     // store
     $(document).on('click','.save-reading', function(e) { 
        e.preventDefault();
        
        var data = {
        'title': $('#title').val(),
        'content': $('#content').val(),
        }
                    
        var url = "{{ route('reading.store') }}"
        
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
                    $('#save_errlist').html("");
                    $('#save_errlist').removeClass("alert alert-danger");
                    $('#readingModal').modal('hide');
                    $('#readingModal').find('input').val("");
                    
                    Swal.fire(
                        'Good job!',
                        response.message,
                        'success'
                    )
                }
            }
        });
        
    });
    
    //show delete confirmation modal
    var reading_id;
    $(document).on('click' ,'.delete-reading', function (e) {
        e.preventDefault();
        reading_id = $(this).val()
        $('#deleteModal').modal('show'); 
        
    });
    
    // show edit modal
    $(document).on('click', '.edit-reading' , function (e) {
        e.preventDefault();
        $('#readingEditModal').modal('show');
        
        var reading_id = $(this).val();
        var url = " {{ route('reading.edit', ':id') }} "
        url = url.replace(':id', reading_id);
       
        console.log(url);
        
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
                    $('#e-title').val(response.reading.title);
                    $('#e-content').val(response.reading.content);
                    $('#edit_reading_id').val(reading_id);
                }
            }
        });
       
    });
    
     // update 
     $(document).on('click', '.update-reading', function (e) {
        e.preventDefault();
        
        var quiz_id = $('#edit_reading_id').val();
        var url = " {{ route('reading.update', ':id') }} "
        url = url.replace(':id', quiz_id);
        
        var data = { 
            'title': $('#e-title').val(),
            'content': $('#e-content').val(),
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
                    $('#readingEditModal').modal('hide');
                    $('#readingEditModal').find('input').val("");
                    
                    Swal.fire(
                        'Good job!',
                        response.message,
                        'success'
                    );
                    
                }
                
            }
        });
    });

    
    // delete
    $(document).on('click', '.delete-reading-btn', function (e) {
        e.preventDefault();
        
        
        var url = "{{ route('reading.destroy', ':id') }}"
        url = url.replace(':id', reading_id);
        console.log(url);
        
        
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