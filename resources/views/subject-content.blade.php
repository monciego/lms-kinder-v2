<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }} !
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg c-container">
                <!-- <h3 class="p-6 m-0 font-weight-bold text-primary fw-bold">Activities</h3> -->

                <div class="row mx-3 mt-5">

                    <!-- QUIZ -->
                    <a href="{{ route('show-quizzes', $id) }}" class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow-sm h-100 py-6 relative">
                            <div
                                class="p-4 h-2 w-2 flex items-center text-center justify-center rounded-full absolute bg-red-600 text-white -top-4 right-0">
                                {{ $quizzes_count }}
                            </div>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class="text-md text-center fw-bold font-weight-bold text-primary text-uppercase mb-1">
                                            QUIZ
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END- QUIZ -->

                    <!-- EXERCISES -->
                    <a href="{{ route('show-exercises', $id) }}" class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow-sm h-100 py-6 relative">
                            <div
                                class="p-4 h-2 w-2 flex items-center text-center justify-center rounded-full absolute bg-red-600 text-white -top-4 right-0">
                                {{ $exercises_count }}
                            </div>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class="text-md text-center fw-bold font-weight-bold text-primary text-uppercase mb-1">
                                            EXERCISES
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END- EXERCISES -->

                    <!-- EXAMS -->
                    <a href="{{ route('show-examinations', $id) }}" class="col-xl-4 col-md-6 mb-4 ">
                        <div class="card border-left-primary shadow-sm h-100 py-6 relative">
                            <div
                                class="p-4 h-2 w-2 flex items-center text-center justify-center rounded-full absolute bg-red-600 text-white -top-4 right-0">
                                {{ $exams_count }}
                            </div>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class="text-md text-center fw-bold font-weight-bold text-primary text-uppercase mb-1">
                                            EXAMS
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END- EXAMS -->

                    <!-- ACTIVITIES -->
                    <a href="{{ route('show-act', $id) }}" class="col-xl-4 col-md-6 mb-4 ">
                        <div class="card border-left-primary shadow-sm h-100 py-6 relative">
                            <div
                                class="p-4 h-2 w-2 flex items-center text-center justify-center rounded-full absolute bg-red-600 text-white -top-4 right-0">
                                {{ $activities_count }}
                            </div>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">

                                        <div
                                            class="text-md text-center fw-bold font-weight-bold text-primary text-uppercase mb-1">
                                            ACTIVITIES
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- END- ACTIVITIES -->

                </div>


            </div>
        </div>
    </div>
</x-app-layout>