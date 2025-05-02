<div class="row">
    <div class="form-group col-md-6 mb-3">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $research->title ?? '') }}" required>
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
    </div>



    <div class="form-group col-md-6 mb-3">
        <label for="authors">Authors</label>
        <input type="text" name="authors" class="form-control" value="{{ old('authors', $research->authors ?? '') }}">
        @error('authors') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group col-md-6 mb-3">
        <label for="fields">Fields</label>
        <input type="text" name="fields" class="form-control" value="{{ old('fields', $research->fields ?? '') }}">
        @error('fields') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group col-md-6 mb-3">
        <label for="document">Upload Document</label>
        <input type="file" name="document" class="form-control">
        @if(isset($research) && $research->document)
            <p>Current File: <a href="{{ Storage::url($research->document) }}" target="_blank">View</a></p>
        @endif
        @error('document') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group col-md-12 mb-3">
        <label for="abstract">Abstract</label>
        <textarea name="abstract" class="form-control" id="abstractEditor">{{ old('abstract', $research->abstract ?? '') }}</textarea>
        @error('abstract') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('#abstractEditor')).catch(error => console.error(error));
    </script>
@endpush
