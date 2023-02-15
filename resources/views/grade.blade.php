<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }} !
        </h2>
    </x-slot>

    <div class="account">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">
                        <!-- table -->
                        <div class="mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h3 class="m-0 font-weight-bold text-primary fw-bold">Grades</h3>
                                <a href="{{ route('generate-pdf') }}"
                                    class="text-white rounded bg-indigo-600 hover:bg-indigo-700 px-6 py-2">Export
                                    to PDF</a>
                            </div>

                            <div id="success_message"> </div>
                            <div class="card-body relative">

                                <div class="table-responsive">
                                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">


                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Grade</th>
                                                <th>Date Updated</th>
                                                @if(Auth::user()->hasRole('teacher'))
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody class="account-list">
                                            @foreach($students_grades as $students_grade)
                                            @if(optional($students_grade->user)->name != null)
                                            <tr>
                                                <td> {{ optional($students_grade->user)->name }}</td>
                                                <td> {{ $students_grade->grade }} </td>
                                                <td> {{ Carbon\carbon::parse($students_grade->created_at)->format('d/m/Y
                                                    g:i A') }} </td>
                                                <td>
                                                    @if(Auth::user()->hasRole('teacher'))
                                                    <button class="btn btn-primary edit-grade"
                                                        value=" {{ $students_grade->id }} "> Edit </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td class="text-danger absolute"> </td>
                                            </tr>
                                            @endif
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

    </div>

    <!-- edit modal -->
    <div class="modal fade" id="gradeEditModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Update Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                    <!-- input fields -->

                    <ul id="edit_errlist"></ul>

                    <!-- account id -->
                    <input type="hidden" id="e-grade-id">
                    <input type="hidden" id="edit_account_id">

                    <!-- Name -->
                    <div>
                        <x-label for="grade" :value="__('Grade')" />
                        <x-input id="e-grade" class="block mt-1 w-full" type="text" name="e-grade" required autofocus />
                    </div>

                    <!-- end- input fields -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-grade">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end- edit modal -->


    @section('scripts')
    <script>
        $(document).ready(function () {


    // // edit
    $(document).on('click', '.edit-grade', function (e) {
        e.preventDefault();

        var grade_id = $(this).val();

        var url = "{{ route('grade.edit', ':id') }}";
        url = url.replace(':id', grade_id);

        $('#gradeEditModal').modal('show');

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
                    $('#e-grade').val(response.grade.grade);
                    $('#e-grade-id').val(response.grade.id);
                }

            }
        });
    });

    // // update
    $(document).on('click', '.update-grade', function (e) {
        e.preventDefault();

        var grade_id = $('#e-grade-id').val();
        var url = "{{ route('grade.update', ':id') }}"
        url = url.replace(':id' , grade_id);

        var data = {
            'grade': $('#e-grade').val(),
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
                    $('#gradeEditModal').modal('hide');
                    $('#gradeEditModal').find('input').val("");

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