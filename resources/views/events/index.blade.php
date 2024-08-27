@extends('layout')

@section('content')

<table class="table-auto w-full border border-collapse border-black">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-200 px-4 py-2">Id</th>
            <th class="border border-gray-200 px-4 py-2">Title</th>
            <th class="border border-gray-200 px-4 py-2">Summary</th>
            <th class="border border-gray-200 px-4 py-2">Interval</th>
            <th class="border border-gray-200 px-4 py-2">Until</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list['events'] as $event)
            <tr class="bg-gray-50">
                <td class="border border-gray-200 px-4 py-2">
                    <a href="{{ route('event-detail', $event->id) }}">
                        {{$event->id}}
                    </a>
                </td>
                <td class="border border-gray-200 px-4 py-2">{{$event->title}}</td>
                <td class="border border-gray-200 px-4 py-2">{{$event->summary}}</td>
                <td class="border border-gray-200 px-4 py-2">{{$event->interval}}</td>
                <td class="border border-gray-200 px-4 py-2">{{$event->until_datetime}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@if ($errors->has('error'))
    <p class="text-red-500 text-sm block">{{ $errors->first('error') }}</p>
@endif
@endsection