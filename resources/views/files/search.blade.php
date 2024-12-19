<form action="{{ route('files.search') }}" method="GET">
    <input type="text" name="keyword" placeholder="Search..." value="{{ request('keyword') }}">
    <button type="submit">Search</button>
</form>

@if($files->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Tags</th>
                <th>Observations</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $file->name }}</td>
                    <td>{{ $file->tags }}</td>
                    <td>{{ $file->observations }}</td>
                    <td><a href="storage/{{ $file->file_path }}" target="_blank">Download</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No files found.</p>
@endif
