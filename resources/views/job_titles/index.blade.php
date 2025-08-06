@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">All Job Titles</h1>
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Job Title</th>
                    <th class="px-4 py-2 border">Department</th>
                    <th class="px-4 py-2 border">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobTitles as $index => $job)
                    <tr>
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $job->name }}</td>
                        <td class="px-4 py-2 border">{{ $job->department->name ?? '—' }}</td>
                        <td class="px-4 py-2 border">{{ $job->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
