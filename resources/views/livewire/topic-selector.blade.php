<div>
    <label for="topic" class="sr-only">Topic</label>
    <select id="topic" name="topic" autocomplete="topic-name" x-data x-on:change="$event.target.form.submit()"
            class="relative block w-full rounded-none rounded-r-md border-0 bg-transparent py-1.5 pt-2 text-gray-700 ring-1 ring-inset ring-indigo-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8">
        <option value></option>
        @foreach($topics ?? [] as $topic)
            <option class="p-2 rounded-md" value="{{ $topic?->id }}" @selected($topic->id == request()->get('topic')) >
                {{ $topic->name }}
            </option>
        @endforeach
    </select>

</div>
