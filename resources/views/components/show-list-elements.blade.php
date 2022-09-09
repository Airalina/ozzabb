<ul class="list-group list-group-flush">
    @foreach ($items as $item)
        <li class="list-group-item p-2">{{ is_numeric($item) ? abs($item) : $item }}</li>
    @endforeach
</ul>