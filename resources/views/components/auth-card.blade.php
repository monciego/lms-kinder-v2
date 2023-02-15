<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="sm:w-3/5 w-full m-6 p-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="heading">
            <h1 class="text-center pb-8 text-4xl font-extrabold text-blue-500 cursor-default text-shadow">LMS FOR GRADE SCHOOL</h1>
        </div>
        <div class="grid grid-cols-2 items-center gap-5">
            <div>
                {{ $logo }}
            </div>
                {{ $slot }}
        </div>
    </div>
</div>
