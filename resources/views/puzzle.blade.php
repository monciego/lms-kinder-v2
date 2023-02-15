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
                            @if(Auth::user()->hasRole('teacher'))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#puzzleModal" > New </button>
                            @endif
                        </div>
                            
                       
                        <div class="card-body relative">
                        
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    
                                
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Uploaded</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="shape-list">
                                        @foreach($puzzles as $puzzle)
                                            <tr> 
                                                <td> {{ $puzzle->title }} </td>
                                                <td> {{ Carbon\carbon::parse($puzzle->created_at)->format('d/m/Y g:i A') }} </td>
                                                <td> {{ Carbon\carbon::parse($puzzle->deadline)->format('d/m/Y g:i A') }} </td>
                                                <td> 
                                                    <a href="{{ route('puzzle.show', $puzzle->id) }}" class="btn btn-success"> Show </a>
                                                    @if(Auth::user()->hasRole('teacher'))
                                                    <a href="{{ route('store-puzzle-response-table', $puzzle->id ) }}" class="btn btn-secondary"> Responses </a>
                                                    <button class="btn btn-danger delete-modal" value="{{ $puzzle->id }}" > Delete </button>
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
    <div class="modal fade" id="puzzleModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Add Puzzle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="store-puzzle" action="javascript:void(0)" >
                    <div class="modal-body px-5">
                        <!-- input fields -->
                        
                            <ul id="save_errlist"></ul>
                                                        
                
                            <!-- Image -->
                            <div class="mt-4">
                                <x-label for="image" :value="__('Image')" />
                                <x-input id="image" class="block mt-1 w-full border-0 shadow-none" type="file" name="image" />
                            </div>
                            
                            <!-- title -->
                            <div class="mt-4">
                                <x-label for="title" :value="__('Title')" />
                                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" />
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
                        <button type="submit" class="btn btn-primary save-puzzle">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end- create modal -->
    
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
                    <button type="button" class="btn btn-danger delete-shape-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- delete confirmation modal -->

@section('scripts')
<script>   
    $(document).ready(function () {
        
        // store
        $(document).on('submit','#store-puzzle', function(e) { 
            e.preventDefault();
            
            var formData = new FormData(this);
            console.log(formData);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var url = '{{ route("puzzle.store") }}';
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
                        $('#puzzleModal').modal('hide');
                        $('#puzzleModal').find('input').val("");
                        
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
         var puzzle_id;
        $(document).on('click', '.delete-modal', function (e) {
            e.preventDefault();
            puzzle_id = $(this).val(); 
            $('#deleteModal').modal('show');
        });
        
        
        // edit
        $(document).on('click', '.delete-shape-btn', function (e) {
            e.preventDefault();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var url = "{{ route('puzzle.destroy', ':id') }}"
            url = url.replace(':id', puzzle_id);
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
        
    });
</script>
@endsection
</x-app-layout>

