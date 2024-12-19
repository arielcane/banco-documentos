<form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    <label for="tags">Tags:</label>
    <input type="text" name="tags">
    <label for="observations">Observations:</label>
    <textarea name="observations"></textarea>
    <label for="file">Upload PDF:</label>
    <input type="file" name="file" accept="application/pdf" required>
    <button type="submit">Upload</button>
</form>