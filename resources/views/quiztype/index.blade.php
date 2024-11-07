@props(['types'])
<x-layout>
    <x-slot name="title">
        <title>Quiz Type - QuizCraft</title>
    </x-slot>
    <x-blank-main>
        <x-bg-card>
            <div class="d-flex justify-content-between">
                <h5 class="card-title">
                    <a href="/" class="px-2"><i class="bi bi-caret-left-fill" style="font-size: 16px;"></i></a>
                    List of Quiz Type
                    <span class="badge bg-secondary text-white d-none">Selected Row : <span id="countTxt"
                            class="text-white fw-bold"></span></span>
                </h5>

                <div class="d-flex align-items-center">
                    <div>
                        <a href="/quiztype/create" class="btn btn-info"><i class="bi bi-plus-circle-dotted"></i> New</a>
                        <button type="button" class="btn btn-warning" id="btnEdit" onclick="editForm()" disabled><i
                                class="bi bi-pencil-square"></i> Edit</button>
                        <form method="post" class="d-inline" id="deleteForm">
                            @csrf
                            @method("DELETE")
                            <input type="hidden" name="actionIds" id="actionIds" readonly>
                        </form>
                        <button type="button" class="btn btn-danger" id="btnDelete" data-bs-toggle="modal"
                                data-bs-target="#delete-confirm-modal" disabled><i class="bi bi-trash3"></i>
                                Delete</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th class="d-none">Detail</th>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mark</th>
                            <th>Count</th>
                            <th>Header</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $type)
                            <tr>
                                <td class="d-none">
                                    @php
                                        $dataDetail = collect([
                                            'id' => $type->id,
                                            'name' => $type->name,
                                            'header' => $type->header,
                                            'mark' => $type->mark,
                                            'updated' => $type->updated_at->format('F j, Y, g:i a'),
                                        ]);
                                        $jsonDetail = $dataDetail->toJson();
                                    @endphp
                                    {{ $jsonDetail }}
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->mark }}</td>
                                <td>{{ $type->quizzes->count() }}</td>
                                <td>{!! Str::limit($type->header, 150, ' ... <a href="">more</a>') !!}</td>
                                <td class="exclude-select">
                                    <button class="btn btn-dark btn-sm exclude-select" onclick="showTypeDetail(this)">
                                        <i class="bi bi-eye exclude-select"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-detail-modal></x-detail-modal>
                <x-delete-modal></x-delete-modal>
            </div>
        </x-bg-card>
    </x-blank-main>
</x-layout>
