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
                        <a href="{{ route('show-subject-content', $subject->id ) }}" class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow-sm h-100 py-6">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col d-flex flex-column">
                                            <div class="text-md text-center fw-bold font-weight-bold text-primary text-uppercase mb-1">
                                                {{ $subject->subject_name }}
                                            </div>
                                            <div class="text-sm text-center text-uppercase mb-1">
                                                {{ $subject->grade_level->grade_level_name }}
                                            </div>
                                            <div class="text-sm text-center text-uppercase mb-1">                                                
                                                @if(Carbon\carbon::parse($subject->start)->format('g:i A') == '12:00 AM' && Carbon\carbon::parse($subject->end)->format('g:i A') == '12:00 AM')
                                                    <span class="text-danger"> NO SCHEDULED ASSIGNED </span>
                                                @else
                                                    {{ Carbon\carbon::parse($subject->start)->format('g:i A') }} - {{ Carbon\carbon::parse($subject->end)->format('g:i A') }}
                                                @endif
                                            </div>
                                                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>  
            </div>
        </div>
    </div>
</x-app-layout>