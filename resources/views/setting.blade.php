@props(['setting'])
<x-layout>
    <x-slot name="title">
        <title>Setting - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <section class="section">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Setting</h3>
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-10 col-12">
                                        @if (session('success'))
                                            <x-alert-success>{{ session('success') }}</x-alert-success>
                                        @endif
                                        @if (session('error'))
                                            <x-alert-danger>{{ session('error') }}</x-alert-danger>
                                        @endif
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mb-3">
                                    <div class="col-md-3 col-12">
                                        <span class="fw-bold">Subject</span>
                                    </div>
                                    <div class="col-md-7 col-12 my-1 my-md-0">
                                        <form method="post" action="/setting/edit/subject">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group">
                                                <input name="subject" type="text"
                                                    class="form-control border-dark-subtle"
                                                    value="{{ $setting->subject }}">
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="bi bi-check-all"></i> Save</button>
                                            </div>
                                            <x-error name="subject"></x-error>
                                        </form>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mb-2">
                                    <div class="col-md-3 col-12 ">
                                        <span class="fw-bold">Grade</span>
                                    </div>
                                    <div class="col-md-7 col-12 my-1 my-md-0">
                                        <form method="post" action="/setting/edit/grade">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group">
                                                <input name="grade" type="number"
                                                    class="form-control border-dark-subtle"
                                                    aria-label="Text input with segmented dropdown button">
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="bi bi-check-all"></i> Save</button>
                                            </div>
                                            <x-error name="grade"></x-error>
                                        </form>
                                        <div class="my-2">
                                            @unless ($setting->grade == null)
                                                @foreach (explode(',', $setting->grade) as $grade)
                                                    <span class="badge rounded-pill bg-dark mb-1" style="font-size: 16px;">
                                                        {{ $grade }}
                                                        <a href="/setting/delete/grade/{{ $grade }}" class="ms-1">
                                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                                        </a>
                                                    </span>
                                                @endforeach
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mb-3">
                                    <div class="col-md-3 col-12 ">
                                        <span class="fw-bold">Chapter</span>
                                    </div>
                                    <div class="col-md-7 col-12 my-1 my-md-0">
                                        <form method="post" action="/setting/edit/chapter">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group">
                                                <input name="chapter" type="number"
                                                    class="form-control border-dark-subtle"
                                                    aria-label="Text input with segmented dropdown button">
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="bi bi-check-all"></i> Save</button>
                                            </div>
                                            <x-error name="chapter"></x-error>
                                        </form>
                                        <div class="my-2">
                                            @unless ($setting->chapter == null)
                                                @foreach (explode(',', $setting->chapter) as $chapter)
                                                    <span class="badge rounded-pill bg-dark mb-1" style="font-size: 16px;">
                                                        {{ $chapter }}
                                                        <a href="/setting/delete/chapter/{{ $chapter }}"
                                                            class="ms-1">
                                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                                        </a>
                                                    </span>
                                                @endforeach
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row d-flex justify-content-center mb-3">
                                    <div class="col-md-3 col-12 ">
                                        <span class="fw-bold">Quick Access</span>
                                    </div>
                                    <div class="col-md-7 col-12 my-1 my-md-0">
                                        <div>
                                            <span class="badge rounded-pill bg-dark mb-1" style="font-size: 16px;">
                                                All Quiz
                                                <a href="#" class="ms-1">
                                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                                </a>
                                            </span>
                                            <span class="badge rounded-pill bg-dark mb-1" style="font-size: 16px;">
                                                Paper
                                                <a href="#" class="ms-1">
                                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row d-flex justify-content-center mb-3">
                                    <div class="col-md-3 col-12 ">
                                        <span class="fw-bold">Image</span>
                                    </div>
                                    <div class="col-md-7 col-12 my-1 my-md-0">
                                        <form method="post" action="/setting/image/upload"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group">
                                                <input type="file" name="image"
                                                    class="form-control border-dark-subtle"
                                                    aria-label="Text input with segmented dropdown button">
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="bi bi-check-all"></i> Save</button>
                                            </div>
                                            <x-error name="image"></x-error>
                                        </form>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-3 col-12"></div>
                                    <div class="col-md-7 col-12">
                                        @unless ($setting->img_list == null)
                                            @foreach (explode(',', $setting->img_list) as $img)
                                                <div class="mb-2">
                                                    <img src="{{ asset("uploads/$img") }}" alt="" width="100px"
                                                        height="auto">
                                                    <p>{{ $img }}
                                                        <a href="/setting/image/delete/{{ $img }}"><i
                                                                class="bi bi-trash text-danger"></i></a>
                                                    </p>

                                                </div>
                                            @endforeach
                                        @endunless
                                    </div>
                                </div>
                                <hr>
                                <div class="mt-4 d-flex flex-column align-items-end pe-5">
                                    <form method="post" action="/import-database" enctype="multipart/form-data" class="d-block">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" name="importDatabase"
                                                class="form-control border-dark-subtle"
                                                aria-label="Text input with segmented dropdown button">
                                            <button type="submit" class="btn btn-warning"><i
                                                    class="bi bi-database-fill-add"></i> Import Data</button>
                                        </div>
                                        <div class="text-end">
                                            <small for="" class="form-text text-end">File type must be .sql
                                                extension!</small>
                                        </div>
                                        <x-error name="importDatabase"></x-error>
                                    </form>
                                </div>
                                <div class="d-flex justify-content-end pe-5">
                                    <form action="/export-database" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary d-block mt-3"><i
                                                class="bi bi-copy"></i> Export Data / Back up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-blank-main>
</x-layout>
