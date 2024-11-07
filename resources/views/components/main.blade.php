@props(['title','breadcrumb'])
<main id="main" class="main bg-color1">
    <div class="d-flex justify-content-between main-header">
        <div class="pagetitle">
            <h1>{{ $title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    @foreach ($breadcrumb as $item)
                    <li class="breadcrumb-item active">{{ $item }}</li>
                    @endforeach
                </ol>
            </nav>
        </div>
        <p id="clocktxt"></p>
    </div>
    {{ $slot }}
</main>