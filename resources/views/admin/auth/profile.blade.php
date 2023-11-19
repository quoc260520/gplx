@extends('admin.layout')
@section('content')
    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            @if (!(Auth::user()->hasRole('staff') || Auth::user()->hasRole('admin')))
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-lg-6 mb-4 mb-lg-0">
                        <div class="card mb-3" style="border-radius: .5rem;">
                            <div class="row g-0">
                                <div class="col-md-4 gradient-custom text-center text-white"
                                    style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                        alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                    <h5>Marie Horwitz</h5>
                                    <p>Web Designer</p>
                                    <i class="far fa-edit mb-5"></i>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h6>Information</h6>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-6 mb-3">
                                                <h6>Email</h6>
                                                <p class="text-muted">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                        <h6>Họ tên</h6>
                                        <p class="text-muted">{{ Auth::user()->full_name }}</p>
                                        <div class="d-flex justify-content-start">
                                            <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                            <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                            <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="d-flex flex-row flex-wrap justify-content-center">
                    <div class="col-4">
                        <canvas id="supplier"></canvas>
                    </div>
                </div>
                <div class="d-flex flex-row flex-wrap justify-content-between mt-5">
                    <div class="col-4">
                        <canvas id="users"></canvas>
                    </div>
                    <div class="col-4">
                        <canvas id="gplx"></canvas>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const users = document.getElementById('users');
        const gplx = document.getElementById('gplx');
        const supplier = document.getElementById('supplier');
        const allGplxActive = {{ json_encode($gplxActive) }}
        const allGplxDeactive = {{ json_encode($gplxDeactive) }}
        new Chart(supplier, {
            type: 'doughnut',
            data: {
                labels: ['Nhà cung cấp'],
                datasets: [{
                    label: 'Nhà cung câp',
                    data: [{{ $allSupplier }}],
                    borderWidth: 1
                }]
            },
            backgroundColor: 'red',
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(gplx, {
            type: 'bar',
            data: {
                labels: ['Nhân viên', 'Khách hàng'],
                datasets: [{
                    label: 'Người dùng',
                    data: [{{ $countStaff }}, {{ $countClient }}],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(users, {
            type: 'bar',
            data: {
                labels: ['Còn hạn', 'Hết hạn'],
                datasets: [{
                    label: 'Tổng số GPLX',
                    data: [allGplxActive, allGplxDeactive],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
