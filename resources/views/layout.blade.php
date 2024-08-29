<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script
        src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-slate-300 text-black/50 dark:bg-black dark:text-white/50">
        <header class="grid items-center gap-2 pb-10">
            <nav class="bg-white border-b border-gray-200 py-4">
                <div class="grid grid-cols-2 max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="{{route('event-index')}}">
                            <h2 class="text-black text-bold">Events</h2>
                        </a>
                    </div>
                    <div class="flex items-center justify-end">
                        <div class="mx-3 flex items-center space-x-4">
                            <a href="{{route('event-index')}}"
                                class="text-gray-700 hover:bg-gray-200 hover:text-blue-500 px-3 py-2 flex items-center rounded-md text-sm font-medium">
                                <svg class="mx-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                                Home
                            </a>
                        </div>
                        <div class="mx-3 flex items-center space-x-4">
                            <a href="{{route('event-new')}}"
                                class="text-gray-700 hover:bg-gray-200 hover:text-blue-500 px-3 py-2 flex items-center rounded-md text-sm font-medium">
                                <svg class="mx-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <circle cx="12" cy="12" r="9" />
                                    <line x1="9" y1="12" x2="15" y2="12" />
                                    <line x1="12" y1="9" x2="12" y2="15" />
                                </svg>
                                New Event
                            </a>
                        </div>

                        <div class="mx-3 flex items-center space-x-4">
                            <a href="#" id="search"
                                class="text-gray-700 hover:bg-gray-200 hover:text-blue-500 px-3 py-2 flex items-center rounded-md text-sm font-medium">
                                <svg class="mx-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                                Search
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#d78f8b] selection:text-black">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <main class="mt-6">
                    @yield('content')
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
    <div id="search-results" class="hidden fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4 py-16">
            <div class="relative bg-white rounded-lg px-6 py-8 shadow-md w-max">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Search Results</h3>
                    <button type="button" onclick="closeSearchResultsModal()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg focus:outline-none active:bg-gray-300 transition duration-150 ease-in-out">
                        <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center justify-end mb-3">
                    <form id="search-form" class="relative">
                        <input type="text" name="search_term" placeholder="Search" id="search-term"
                            class="input shadow-lg focus:border-2 border-gray-300 px-5 py-3 rounded-xl w-56 transition-all focus:w-64 outline-none" />
                        <button type="submit">
                            <svg class="size-6 absolute top-3 right-3 text-gray-500" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="my-5 flex flex-row gap-2 items-center justify-center hidden" id="search-results-loader">
                    <div class="w-4 h-4 rounded-full bg-red-500 animate-bounce"></div>
                    <div class="w-4 h-4 rounded-full bg-red-500 animate-bounce [animation-delay:-.3s]"></div>
                    <div class="w-4 h-4 rounded-full bg-red-500 animate-bounce [animation-delay:-.5s]"></div>
                </div>
                <table class="table-auto w-full border border-collapse border-black hidden" id="search-results-table">
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('search').addEventListener('click', (e) => {
            e.preventDefault()
            document.getElementById('search-results').classList.remove('hidden');
        });

        document.getElementById('search-form').addEventListener('submit', (e) => {
            e.preventDefault()
            document.getElementById('search-results-loader').classList.remove('hidden');
            sendRequest(`{{route('search-event')}}?search_term=${document.getElementById('search-term').value}`, 'GET', null, (response) => {
                events = JSON.parse(response);
                const tableBody = document.getElementById('search-results-table').querySelector('tbody');
                tableBody.innerHTML = ''; // Clear existing rows
                events['events'].forEach(event => {
                    const row = document.createElement('tr');
                    console.log(event)
                    const url = `/events/detail/${event['id']}`
                    row.innerHTML = `
                        <tr class="bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2">
                                <a href="${url}" class="flex items-center group justify-center p-2 rounded-md drop-shadow-xl from-gray-800 font-semibold transition-all duration-250 hover:from-[#331029] hover:to-[#310413]">
                                    ${event['id']}
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
                            <td class="border border-gray-200 px-4 py-2">${event['title']}</td>
                            <td class="border border-gray-200 px-4 py-2">${event['summary']}</td>
                            <td class="border border-gray-200 px-4 py-2">${event['interval']}</td>
                            <td class="border border-gray-200 px-4 py-2">${event['until_datetime']}</td>
                        </tr>`
                    tableBody.appendChild(row);
                });
                document.getElementById('search-results-loader').classList.add('hidden');
                document.getElementById('search-results-table').classList.remove('hidden');
            });

        })

        function closeSearchResultsModal() {
            document.getElementById('search-results').classList.add('hidden');
            document.getElementById('search-results-table').classList.add('hidden');
        }


        function sendRequest(url, method, data, callback) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.onload = function () {
                if ((xhr.status >= 200 && xhr.status < 300) || xhr.status == 422) {
                    callback(xhr.responseText);
                } else {
                    console.error('Error:', xhr.statusText);
                }
            };
            xhr.send(data);
        }
    </script>
</body>

</html>