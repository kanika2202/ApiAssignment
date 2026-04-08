@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-dark">📊 Business Intelligence Report 2026</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 h-100">
                <h6 class="small text-uppercase opacity-75">1. Total Revenue</h6>
                <h3 class="fw-bold">${{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3 h-100">
                <h6 class="small text-uppercase opacity-75">2. Today's Orders</h6>
                <h3 class="fw-bold">{{ $todayOrders }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark p-3 h-100">
                <h6 class="small text-uppercase opacity-75">3. Today's Revenue</h6>
                <h3 class="fw-bold">${{ number_format($todayRevenue, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white p-3 h-100">
                <h6 class="small text-uppercase opacity-75">4. Total Products</h6>
                <h3 class="fw-bold">{{ $totalProductsCount }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-4 mb-4">
                <h5 class="fw-bold mb-4 text-secondary small text-uppercase">6. Monthly Revenue Trend</h5>
                <canvas id="salesChart" style="max-height: 280px;"></canvas>
            </div>
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-4 text-secondary small text-uppercase">7. Daily Revenue (Last 7 Days)</h5>
                <canvas id="dailyChart" style="max-height: 250px;"></canvas>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4 mb-4">
                <h5 class="fw-bold mb-3 text-secondary small text-uppercase">5. Top 5 Best Sellers</h5>
                <table class="table table-sm align-middle">
                    <tbody class="small">
                        @foreach($products as $tp)
                        <tr>
                            <td>{{ $tp->ProductName }}</td>
                            <td class="text-end fw-bold text-success">{{ $tp->total_sold }} Sold</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card shadow-sm border-0 p-4 mb-4">
                <h6 class="fw-bold mb-3 text-secondary small text-uppercase">8 & 10. Quick Stats</h6>
                <div class="d-flex justify-content-between mb-2 small">
                    <span>Total Categories:</span>
                    <span class="fw-bold">{{ $categoryReports->count() }}</span>
                </div>
                <hr class="my-2">
                @foreach($paymentMethods as $pm)
                <div class="d-flex justify-content-between small">
                    <span class="text-uppercase">{{ $pm->payment_method }}:</span>
                    <span class="fw-bold">{{ $pm->count }} Orders</span>
                </div>
                @endforeach
            </div>

            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3 text-secondary small text-uppercase">9. Orders by City</h5>
                <ul class="list-unstyled mb-0 small">
                    @foreach($cityReports as $city)
                    <li class="d-flex justify-content-between border-bottom py-1">
                        <span>{{ $city->city }}</span>
                        <span class="badge bg-light text-dark">{{ $city->count }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Line Chart
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyData->pluck('month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyData->pluck('revenue')) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true, tension: 0.4
            }]
        }
    });

    // Daily Bar Chart
    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyData->pluck('date')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($dailyData->pluck('revenue')) !!},
                backgroundColor: '#ffc107',
                borderRadius: 5
            }]
        }
    });
</script>
@endsection