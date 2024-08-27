@extends('layout')

@section('content')
<div class="relative p-5 rounded-lg sm:max-w-xl sm:mx-auto bg-gray-700">
    <form class="flex flex-col" id="new_event_form" method="POST" action="{{route('event-create-new')}}">
        @csrf
        <input
            class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mt-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
            name="title" minlength="3" maxlength="255" placeholder="Event title" />
        @error('title')
            <p class="text-red-500 text-sm block">{{ $message }}</p>
        @enderror
        <textarea
            class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mt-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
            name="summary" maxlength="255" placeholder="Event summary"></textarea>
        @error('summary')
            <p class="text-red-500 text-sm block">{{ $message }}</p>
        @enderror
        <select
            class="border rounded-lg px-3 py-2 mb-1 mt-5 text-sm w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
            name="interval">
            <option value="daily">Daily</option>
            <option value="monthly">Monthly</option>
        </select>
        @error('interval')
            <p class="text-red-500 text-sm block">{{ $message }}</p>
        @enderror
        <input
            class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mt-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
            type="number" name="occurrence" value="1" min="1" max="99" />
        @error('occurrence')
            <p class="text-red-500 text-sm block">{{ $message }}</p>
        @enderror
        <div class="row  mb-4 grid grid-cols-2">
            <label for="start_datetime" class="col text-gray-50 font-bold">Start Datetime</label>
            <input
                class="col flex justify-end  w-auto col-span-full bg-gray-100 text-gray-800 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                type="datetime-local" name="start_datetime" id="start_datetime"
                value="{{ now()->addHour()->format('Y-m-d\TH:i')  }}" />
            @error('start_datetime')
                <p class="text-red-500 text-sm block">{{ $message }}</p>
            @enderror
        </div>
        <div class="row  mb-4 grid grid-cols-2">
            <label for="end_datetime" class=" text-gray-50 font-bold">End Datetime</label>
            <input
                class="flex justify-end  w-auto col-span-full bg-gray-100 text-gray-800 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                type="datetime-local" name="end_datetime" id="end_datetime"
                value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}" />
            @error('end_datetime')
                <p class="text-red-500 text-sm block">{{ $message }}</p>
            @enderror
        </div>
        <div class="row  mb-4 grid grid-cols-2">
            <label for="until" class=" text-gray-50 font-bold">Until</label>
            <input
                class="flex justify-end  w-auto col-span-full bg-gray-100 text-gray-800 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                type="datetime-local" name="until" id="until" value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}" />
            @error('until_datetime')
                <p class="text-red-500 text-sm block">{{ $message }}</p>
            @enderror
        </div>
        <button
            class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150"
            type="submit">Create</button>
        @if ($errors->has('error'))
            <p class="text-red-500 text-sm block">{{ $errors->first('error') }}</p>
        @endif
    </form>
</div>
@endsection