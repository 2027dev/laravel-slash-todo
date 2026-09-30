<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tasks</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#111114] font-sans antialiased">
        <div class="flex min-h-screen items-center justify-center px-6 py-16">
            <main class="w-full max-w-md">
                <p class="mb-6 text-sm font-medium text-gray-500">{{ now()->format('l, F j') }}</p>

                @if ($todos->isEmpty())
                    <p class="mb-6 text-sm text-gray-600">Nothing here yet — add your first task below.</p>
                @else
                    <ul class="mb-6 space-y-4">
                        @foreach ($todos as $todo)
                            <li class="group flex items-center gap-3">
                                <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        aria-label="{{ $todo->completed ? 'Mark as not done' : 'Mark as done' }}"
                                        class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 transition
                                            {{ $todo->completed ? 'border-violet-600 bg-violet-600' : 'border-gray-600 hover:border-gray-400' }}"
                                    >
                                        @if ($todo->completed)
                                            <svg class="h-3 w-3 text-white" viewBox="0 0 12 12" fill="none">
                                                <path d="M2 6l2.5 2.5L10 3" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <span class="flex-1 truncate text-lg font-semibold {{ $todo->completed ? 'text-gray-600 line-through' : 'text-gray-100' }}">
                                    {{ $todo->title }}
                                </span>

                                <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        aria-label="Delete task"
                                        class="shrink-0 text-gray-600 opacity-0 transition hover:text-red-400 group-hover:opacity-100"
                                    >
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none">
                                            <path d="M5 5l10 10M15 5L5 15" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('todos.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input
                        type="text"
                        name="title"
                        placeholder="Add task..."
                        autocomplete="off"
                        required
                        class="w-full border-0 border-b border-gray-700 bg-transparent pb-2 text-lg font-medium text-gray-100 placeholder-gray-600 focus:border-violet-500 focus:outline-none focus:ring-0"
                    >

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-violet-600 py-4 text-base font-bold text-white transition hover:bg-violet-500 active:bg-violet-700"
                    >
                        Add Task
                    </button>
                </form>

                @if ($todos->isNotEmpty())
                    <p class="mt-6 text-center text-sm text-gray-600">{{ $remaining }} task{{ $remaining === 1 ? '' : 's' }} remaining</p>
                @endif
            </main>
        </div>
    </body>
</html>
