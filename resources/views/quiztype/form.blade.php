@props(["type"])
<x-layout>
    <x-slot name="title">
        <title>Quiz Type - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <x-bg-card>
            <h5 class="card-title">
                <a href="/quiztype" class="px-2"><i class="bi bi-caret-left-fill" style="font-size: 16px;"></i></a>
                Quiz Type {{ isset($type)?"Edit":"Entry" }} Form
            </h5>
            @if (session("success"))
                <x-alert-success>{{ session("success") }}</x-alert-success>
            @endif
            @if (session("error"))
                <x-alert-danger>{{ session("error") }}</x-alert-danger>
            @endif
            <form class="row" method="POST">
                @csrf
                @isset($type)
                    @method("PUT")
                @endisset
                <div class="col-md-6">
                    <label for="nameInput" class="form-label"><b>Name</b> <small class="form-text"> ( Enter the name of question type ) </small></label>
                    <input name="name" type="text" value="{{ isset($type)?$type->name:old("name") }}" class="form-control" id="nameInput" autocomplete="off" required>
                    <x-error name="name"></x-error>
                </div>
                <div class="col-md-6">
                    <label for="markInput" class="form-label"><b>Mark</b> <small class="form-text"> ( Enter the mark value for each question ) </small></label>
                    <input name="mark" type="number" value="{{ isset($type)?$type->mark:old("mark") }}" class="form-control" id="markInput" autocomplete="off" required>
                    <x-error name="mark"></x-error>
                </div>
                <div class="col-12 my-2">
                    <label for="headerInput" class="form-label"><b>Header</b> <small class="form-text"> ( Enter the title that will appear in the question paper ) </small></label>
                    <textarea name="header" class="editor" id="headerInput">
                        {{ isset($type)?$type->header:old("header") }}
                    </textarea>
                    <x-error name="header"></x-error>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">{{ isset($type)?"Edit":"Save" }}</button>
                </div>
            </form><!-- End floating Labels Form -->
        </x-bg-card>
    </x-blank-main>
</x-layout>
