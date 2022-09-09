@if (count($errors) > 0)
    <div class="text-danger">
        @foreach ($errors as $error)
            @if (is_array($error))
                @foreach ($error as $errorImage)
                    <p>{{ $errorImage }}</p>
                @endforeach
            @else
                <p>{{ $error }}</p>
            @endif
        @endforeach
    </div>
@endif
