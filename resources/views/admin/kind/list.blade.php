@extends('admin.layout')

@section('content')
    <nav class="navbar">
        <div class="container">
            <form action="{{ route('kind.create') }}" class="d-flex" method="POST">
                @csrf
                <input class="form-control me-2 mr-4" name="name" placeholder="Loại câu hỏi" aria-label="Kind Question Name">
                <button class="btn btn-outline-success" type="submit">Thêm</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped border border-2">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Loại câu hỏi</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kinds ?? [] as $kind)
                            <tr>
                                <th scope="row">{{ $kind->id }}</th>
                                <td>{{ $kind->name }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" title="Delete"><i
                                            class="fa fa-trash"></i></button>
                                    <button class="btn btn-primary btn-sm" title="Update"><i class="fa fa-pen"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
