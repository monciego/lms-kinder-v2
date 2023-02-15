<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }} !
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg c-container">
                <h3 class="p-6 m-0 font-weight-bold text-primary fw-bold">Subjects</h3>
                <div class="row mx-3">                            
                    @foreach($subjects as $subject)                       
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow-sm h-100 py-6">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col d-flex flex-column">
                                            <div class="text-md text-center fw-bold font-weight-bold text-primary text-uppercase mb-1">
                                                {{ $subject->subject_name }}
                                            </div>
                                            <!-- <div class="text-sm text-center text-uppercase mb-1">
                                            @if( optional($subject->user)->name == null)
                                                No instructor                                               
                                            @else 
                                                {{ optional($subject->user)->name }}                                                
                                            @endif
                                            </div> -->
                                            <div class="text-sm text-center text-uppercase mb-1">
                                                @if(Carbon\carbon::parse($subject->start)->format('g:i A') == '12:00 AM' && Carbon\carbon::parse($subject->end)->format('g:i A') == '12:00 AM')
                                                    <span class="text-danger"> NO SCHEDULED ASSIGNED </span>
                                                @else
                                                    {{ Carbon\carbon::parse($subject->start)->format('g:i A') }} - {{ Carbon\carbon::parse($subject->end)->format('g:i A') }}
                                                @endif                                                
                                            </div>
                                            
                                            <div class="mt-2 d-flex m-auto gap-1" style="width: fit-content">
                                                <button type="button" value=" {{ $subject->id }} " class="btn btn-primary m-auto edit"> Edit </button>
                                                <button type="button" value=" {{ $subject->id }} " class="btn btn-danger m-auto delete-modal-trigger" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete </button> 

                                            </div>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>  
            </div>
        </div>
    </div>
    
    <!-- edit modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    <!-- input fields -->
                    
                    <ul id="edit_errlist"></ul>
                                                    
                    <!-- Quiz id -->
                    
                    <input type="hidden" id="subject_id"> 
                    
                    <!-- subject_name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full uppercase" type="text" name="name" :value="old('name')" required autofocus />
                    </div>
                                                    
                    <!-- start -->
                    <div class="mt-4">
                        <x-label for="start" :value="__('Starts at')" />
                        <x-input id="start" class="block mt-1 w-full" type="time" name="start" :value="old('start')" required autofocus />
                    </div>
                    
                    <!-- end -->
                    <div class="mt-4">
                        <x-label for="end" :value="__('Ends at')" />
                        <x-input id="end" class="block mt-1 w-full" type="time" name="end" :value="old('end')" required autofocus />
                    </div>
                                        
                    <!-- end- input fields -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update">Update</button>
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
                    <button type="button" class="btn btn-danger delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- delete confirmation modal -->
    
@section('scripts')
<script>
$(document).ready(function () {
    // display delete modal
    var id;
    $(document).on('click', '.delete-modal-trigger' , function (e) {
        e.preventDefault();
        id = $(this).val();
    });
    
     // delete
     $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var url = "{{ route('delete-subject', ':id') }}"; 
        url = url.replace(':id', id);
        
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
    
    // edit
    $(document).on('click', '.edit' , function (e) {
        e.preventDefault();
        var id = $(this).val();
        $('#editModal').modal('show');
        var url = '{{ route("edit-subjects" , ":id") }}';
        url = url.replace(':id', id);
        
        $('#subject_id').val(id);
        
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
                    $('#name').val(response.subject.subject_name);
                    $('#start').val(response.subject.start);
                    $('#end').val(response.subject.end);
                    
                    $("#instructor option[value='"+ response.subject.user_id +"']").attr("selected","selected");
                }
            }
        });
        
    });
    
    // update 
    $(document).on('click', '.update', function (e) {
        e.preventDefault();
        
        var id = $('#subject_id').val();
        var data = { 
            'subject_name': $('#name').val(),
            'start': $('#start').val(),
            'end': $('#end').val(),
        }
        
        console.log(data);
        
        var url = '{{ route("update-subjects" , ":id") }}';
        url = url.replace(':id', id);
        
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
                    $('#editModal').modal('hide');
                    $('#editModal').find('input').val("");
                    
                    Swal.fire(
                        'Good job!',
                        response.message,
                        'success'
                    );
                    
                }
                
            }
    });
    
    
});
    
});
</script>
@endsection
</x-app-layout>
