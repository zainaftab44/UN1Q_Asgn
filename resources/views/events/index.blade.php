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
                    <a href="{{ route('event-detail', $event->id) }}" class="flex items-center group justify-center p-2 rounded-md drop-shadow-xl from-gray-800 font-semibold transition-all duration-250 hover:from-[#331029] hover:to-[#310413]">
                        {{$event->id}}
                        <svg class="mx-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5" />
                            <line x1="10" y1="14" x2="20" y2="4" />
                            <polyline points="15 4 20 4 20 9" />
                        </svg>
                        <span
                            class="absolute opacity-0 group-hover:opacity-100 group-hover:text-white group-hover:text-sm duration-500 w-max  group-hover:bg-black p-2 rounded-lg">
                            See event details
                        </span>
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