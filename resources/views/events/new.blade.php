@extends('layout')

@section('content')
<h2
    class="relative p-7 rounded-t-lg sm:max-w-xl sm:mx-auto  flex items-center justify-center font-semibold h-4 bg-slate-400">
    Create Event</h2>
<div class="relative px-5 pb-5 rounded-b-lg sm:max-w-xl sm:mx-auto bg-blue-200 ">
    <form class="flex flex-col" id="new-event-form" action="#">
        @csrf
        <input
            class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mt-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
            name="title" minlength="3" maxlength="255" placeholder="Event title" required />
        <textarea
            class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mt-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
            name="summary" maxlength="255" placeholder="Event summary"></textarea>
        <select
            class="border rounded-lg px-3 py-2 mb-1 mt-5 text-sm w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
            name="interval" required>
            <option value="daily">Daily</option>
            <option value="monthly">Monthly</option>
        </select>
        <div class="row  mb-4 grid grid-cols-2">
            <label for="start_datetime" class="col text-gray-700 font-bold">Start Datetime</label>
            <input
                class="col flex justify-end  w-auto col-span-full bg-gray-100 text-gray-800 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                type="datetime-local" name="start_datetime" id="start_datetime"
                value="{{ now()->addHour()->format('Y-m-d\TH:i')  }}" required />
        </div>
        <div class="row  mb-4 grid grid-cols-2">
            <label for="end_datetime" class=" text-gray-700 font-bold">End Datetime</label>
            <input
                class="flex justify-end  w-auto col-span-full bg-gray-100 text-gray-800 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                type="datetime-local" name="end_datetime" id="end_datetime"
                value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}" required />
        </div>
        <div class="row  mb-4 grid grid-cols-2">
            <label for="until_datetime" class=" text-gray-700 font-bold">Until</label>
            <input
                class="flex justify-end  w-auto col-span-full bg-gray-100 text-gray-800 border-0 rounded-md p-2 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                type="datetime-local" name="until_datetime" id="until_datetime"
                value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}" required />
        </div>
        <button
            class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150"
            type="submit">Create</button>
        <p class="bg-red-200 mt-4 p-4 text-gray-600 text-sm block rounded-md hidden" id="error-out"></p>
    </form>
</div>
<script>
    document.getElementById('new-event-form').addEventListener('submit', function (event) {
        event.preventDefault();
        document.getElementById('error-out').classList.add('hidden');
        document.getElementById('full-page-loader').classList.remove('hidden');
        const formData = new FormData(this);
        sendRequest('{{route('create-event')}}', 'POST', formData, (response) => {
            data = JSON.parse(response);
            document.getElementById('full-page-loader').classList.add('hidden');
            if (data['errors']) {
                for (const key in data['errors']) {
                    if (Object.prototype.hasOwnProperty.call(data['errors'], key)) {
                        const error = data['errors'][key];
                        document.getElementById('error-out').innerText += error + "\n";
                    }
                }
                document.getElementById('error-out').classList.remove('hidden');
            } else {
                document.getElementById('error-out').classList.add('hidden');
                window.location.href = '{{route('event-index')}}';
            }
        })
    });
</script>

@endsection