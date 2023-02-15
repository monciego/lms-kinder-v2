<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reports</title>
</head>

<body>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-blue-100">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                    Student Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                    Grade
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                    Date Updated
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($students_grades as $students_grade)
            @if(optional($students_grade->user)->name != null)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ optional($students_grade->user)->name }}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="ml-1">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $students_grade->grade }}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        {{ Carbon\carbon::parse($students_grade->created_at)->format('d/m/Y
                        g:i A') }}
                    </div>
                </td>
            </tr>
            @endif
            @endforeach


            <!-- More people... -->
        </tbody>
    </table>


    <style>
        h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: .5rem;
        }

        table tr:nth-child(even) {
            background: #c1d0e4;
        }

        table th {
            padding: 12px 0;
            text-align: center;
            background: #140b86;
            color: #fff;
        }

        #download {
            font-family: Arial, Helvetica, sans-serif;
            margin: 1rem 0;
            display: block;
            float: right;
        }

        .cta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .cta a {
            font-size: 1rem;
            margin: 1rem 0;
            display: inline-block;
        }
    </style>
    {{-- {{ $scholars->scholarship->scholarship_name }}
    {{ $scholars->address }} --}}

</body>

</html>