@if (count($errors) > 0)
    <div class="text-danger">
        @foreach ($errors as $error)
            @foreach ($error as $errorImage)
                <p>{{ $errorImage }}</p>
            @endforeach
        @endforeach
    </div>
@endif
