@extends('layout')

@section('content')
<h3>Event Details</h3>
<table class="table-auto w-full border border-collapse border-black bg-green-100">
    <tbody>
        <tr>
            <td class="border border-gray-50 px-4 py-2">Event ID</td>
            <td class="border border-gray-50 px-4 py-2">{{$event->id}}</td>
        </tr>
        <tr>
            <td class="border border-gray-50 px-4 py-2">Title</td>
            <td class="border border-gray-50 px-4 py-2">{{$event->title}}</td>
        </tr>
        <tr>
            <td class="border border-gray-50 px-4 py-2">Summary</td>
            <td class="border border-gray-50 px-4 py-2">{{$event->summary}}</td>
        </tr>
        <tr>
            <td class="border border-gray-50 px-4 py-2">Interval</td>
            <td class="border border-gray-50 px-4 py-2">{{$event->interval}}</td>
        </tr>
    </tbody>
</table>
<table class="table-auto w-full border border-collapse border-black">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-200 px-4 py-2">Occurrence Id</th>
            <th class="border border-gray-200 px-4 py-2">Start DateTime</th>
            <th class="border border-gray-200 px-4 py-2">End DateTime</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($event->occurrences as $occurrence)
            <tr class="bg-gray-50">
                <td class="border border-gray-200 px-4 py-2">{{$occurrence->id}}</td>
                <td class="border border-gray-200 px-4 py-2">{{$occurrence->start_datetime}}</td>
                <td class="border border-gray-200 px-4 py-2">{{$occurrence->end_datetime}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection