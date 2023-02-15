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
                                <h3 class="m-0 font-weight-bold text-primary fw-bold"> {{ $student->name }} </h3>
                            </div>

                            <div class="card-body relative">

                                <div class="table-responsive">
                                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>

                                        <tbody class="account-list">
                                            <!-- english -->
                                            <tr>
                                                <td> English </td>
                                                <td style="width: 50%;">
                                                    <div class="progress" style="height: 1.5rem;">
                                                    @if($english_progress_percentage > 0)
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ round($english_progress_percentage, 0) }}%" aria-valuenow="{{ round($english_progress_percentage, 0) }}" aria-valuemin="0"
                                                            aria-valuemax="100">                                                        
                                                           <span> {{ round($english_progress_percentage, 0) }} % </span>
                                                        </div>
                                                    @else    
                                                        <span class="text-danger w-full flex items-center justify-center fw-bold"> No Progress </span>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- math -->
                                            <tr>
                                                <td> Mathematics </td>
                                                <td style="width: 50%;">
                                                    <div class="progress" style="height: 1.5rem;">
                                                    @if($math_progress_percentage > 0)
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ round($math_progress_percentage, 0) }}%" aria-valuenow="{{ round($math_progress_percentage, 0) }}" aria-valuemin="0"
                                                            aria-valuemax="100">                                                        
                                                           <span> {{ round($math_progress_percentage, 0) }} % </span>
                                                        </div>
                                                    @else    
                                                        <span class="text-danger w-full flex items-center justify-center fw-bold"> No Progress </span>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            
                                            <!-- science -->
                                            <tr>
                                                <td> Science </td>
                                                <td style="width: 50%;">
                                                    <div class="progress" style="height: 1.5rem;">
                                                    @if($science_progress_percentage > 0)
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ round($science_progress_percentage, 0) }}%" aria-valuenow="{{ round($science_progress_percentage, 0) }}" aria-valuemin="0"
                                                            aria-valuemax="100">                                                        
                                                           <span> {{ round($science_progress_percentage, 0) }} % </span>
                                                        </div>
                                                    @else    
                                                        <span class="text-danger w-full flex items-center justify-center fw-bold"> No Progress </span>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            
                                            <!-- filipino -->
                                            <tr>
                                                <td> Filipino </td>
                                                <td style="width: 50%;">
                                                    <div class="progress" style="height: 1.5rem;">
                                                    @if($filipino_progress_percentage > 0)
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ round($filipino_progress_percentage, 0) }}%" aria-valuenow="{{ round($filipino_progress_percentage, 0) }}" aria-valuemin="0"
                                                            aria-valuemax="100">                                                        
                                                           <span> {{ round($filipino_progress_percentage, 0) }} % </span>
                                                        </div>
                                                    @else    
                                                        <span class="text-danger w-full flex items-center justify-center fw-bold"> No Progress </span>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>

                        
                                            <!-- mapeh -->
                                            <tr>
                                                <td> Mapeh </td>
                                                <td style="width: 50%;">
                                                    <div class="progress" style="height: 1.5rem;">
                                                    @if($mapeh_progress_percentage > 0)
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ round($mapeh_progress_percentage, 0) }}%" aria-valuenow="{{ round($mapeh_progress_percentage, 0) }}" aria-valuemin="0"
                                                            aria-valuemax="100">                                                        
                                                            <span> {{ round($mapeh_progress_percentage, 0) }} % </span>
                                                        </div>
                                                    @else    
                                                        <span class="text-danger w-full flex items-center justify-center fw-bold"> No Progress </span>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                             <!-- mtb -->
                                             <tr>
                                                <td> Mtb </td>
                                                <td style="width: 50%;">
                                                    <div class="progress" style="height: 1.5rem;">
                                                    @if($mtb_progress_percentage > 0)
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ round($mtb_progress_percentage, 0) }}%" aria-valuenow="{{ round($mtb_progress_percentage, 0) }}" aria-valuemin="0"
                                                            aria-valuemax="100">                                                        
                                                            <span> {{ round($mtb_progress_percentage, 0) }} % </span>
                                                        </div>
                                                    @else    
                                                        <span class="text-danger w-full flex items-center justify-center fw-bold"> No Progress </span>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            
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

</x-app-layout>