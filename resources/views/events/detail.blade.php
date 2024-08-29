@extends('layout')

@section('content')
<div class="grid grid-cols-2 bg-blue-200 text-black text-center rounded-t-lg text-lg p-4">
    <h3 class="flex lg:justify-end">Event Details</h3>
    <div class="flex lg:justify-end">
        <a class="group cursor-pointer from-gray-800 font-semibold transition-all duration-250 hover:from-[#331029] hover:to-[#310413]"
            href="#" id="update-event">
            <svg class="h-8 w-8 text-black" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                <line x1="16" y1="5" x2="19" y2="8" />
            </svg>

            <span
                class="absolute opacity-0 group-hover:opacity-100 group-hover:text-white group-hover:text-sm duration-500 w-max  group-hover:bg-black p-2 rounded-lg">
                Edit Event
            </span>
        </a>
        <a title="Delete Event"
            class="group cursor-pointer from-gray-800 font-semibold transition-all duration-250 hover:from-[#331029] hover:to-[#310413]"
            href="#" id="delete-event">
            <svg class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span
                class="absolute opacity-0 group-hover:opacity-100 group-hover:text-white group-hover:text-sm duration-500 w-max  group-hover:bg-black p-2 rounded-lg">
                Delete Event
            </span>
        </a>
    </div>
</div>
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
        <tr>
            <td class="border border-gray-50 px-4 py-2">Until DateTime</td>
            <td class="border border-gray-50 px-4 py-2">
                {{(\Carbon\Carbon::parse($event->until_datetime))->format('Y-m-d H:i')}}
            </td>
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
                <td class="border border-gray-200 px-4 py-2">
                    {{(\Carbon\Carbon::parse($occurrence->start_datetime))->format('Y-m-d H:i')}}
                </td>
                <td class="border border-gray-200 px-4 py-2">
                    {{(\Carbon\Carbon::parse($occurrence->end_datetime))->format('Y-m-d H:i')}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



<div id="myModal" class="hidden fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen px-4 py-16">
        <div class="relative bg-white rounded-lg px-6 py-8 shadow-md w-full max-w-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg text-center font-bold block">Update Event</h3>
                <button type="button" onclick="closeModal()"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg focus:outline-none active:bg-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <form id="update-event-form">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{$event->title}}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="summary" class="block text-gray-700 font-bold mb-2">Summary</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text" id="summary" name="summary">{{$event->summary}}</textarea>
                </div>
                <div class="mb-4">
                    <label for="start_datetime" class="block text-gray-700 font-bold mb-2">Start DateTime</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="datetime-local" name="start_datetime" id="start_datetime"
                        value="{{ (\Carbon\Carbon::parse($event->start_datetime))->format('Y-m-d\TH:i')  }}" required />
                </div>
                <div class="mb-4">
                    <label for="end_datetime" class="block text-gray-700 font-bold mb-2">End DateTime</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="datetime-local" name="end_datetime" id="end_datetime"
                        value="{{ (\Carbon\Carbon::parse($event->end_datetime))->format('Y-m-d\TH:i') }}" required />
                </div>
                <div class="mb-4">
                    <label for="until_datetime" class="block text-gray-700 font-bold mb-2">Until DateTime</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="datetime-local" name="until_datetime" id="until_datetime"
                        value="{{ (\Carbon\Carbon::parse($event->until_datetime))->format('Y-m-d\TH:i') }}" required />
                </div>
                <p class="bg-red-200 my-4 p-4 text-gray-600 text-sm block rounded-md hidden" id="error-out"></p>

                <div class="flex justify-end">
                    <button type="button"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 me-2 rounded"
                        onclick="closeModal()">Close</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
    document.getElementById('delete-event').addEventListener('click', (e) => {
        e.preventDefault();
        if (confirm('This is a irreversible action. Would you still like to continue?'))
            sendRequest('{{route('delete-event', $event->id)}}', 'DELETE', null, (response) => {
                alert(JSON.parse(response)['message']);
                window.location.href = '{{route('event-index')}}';
            })
    })
    document.getElementById('update-event').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('myModal').classList.remove('hidden');
    });
    document.getElementById('update-event-form').addEventListener('submit', (e) => {
        e.preventDefault();
        document.getElementById('error-out').classList.add('hidden');
        document.getElementById('error-out').innerText = '';
        document.getElementById('full-page-loader').classList.remove('hidden');
        const formData = new FormData(e.target);
        sendRequest('{{route('update-event', $event->id)}}', 'POST', formData, (response) => {
            document.getElementById('full-page-loader').classList.add('hidden');
            data = JSON.parse(response);
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
                window.location.href = '{{route('event-detail', $event->id)}}'
            }

        })
    });

    function closeModal() {
        document.getElementById('myModal').classList.add('hidden');
    }


</script>


@endsection