@extends('admin.layout')

@section('content')
    <nav class="navbar">
        <div class="container">
            <form action="{{ route('answer.list') }}" class="d-flex" method="GET">
                <input class="form-control me-2 mr-4" type="search" name="text" placeholder="Câu hỏi"
                    aria-label="Question Name">
                <select class="form-control me-2 mr-4" aria-label="Question Type" name="kind_question">
                    <option value="" selected>Tất cả</option>
                    @foreach ($kinds as $kind)
                        <option value="{{ $kind->id }}">{{ $kind->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-success" type="submit">Search</button>
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
                            <th scope="col">Câu hỏi</th>
                            <th scope="col">Loại câu hỏi</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Sample Question 1</td>
                            <td>Multiple Choice</td>
                            <td>
                                <button class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>
                                <button class="btn btn-primary btn-sm" title="Update"><i class="fa fa-pen"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
