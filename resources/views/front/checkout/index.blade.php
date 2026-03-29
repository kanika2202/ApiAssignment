@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <form method="POST" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            {{-- ផ្នែកខាងឆ្វេង៖ ព័ត៌មានអតិថិជន និងការបង់ប្រាក់ --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 mb-4 rounded-4">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-geo-alt me-2"></i>Delivery Address</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">Full Name</label>
                            <input name="customer_name" class="form-control pill" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">Phone</label>
                            <input name="customer_phone" class="form-control pill" placeholder="012 345 678" required>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold">Address Details</label>
                            <input name="address_line" class="form-control pill" placeholder="St. 123, House 45, Sangkat..." required>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-credit-card me-2"></i>Payment Method</h5>
                    <div class="d-flex gap-3 mb-3">
                        <label class="btn btn-outline-dark pill px-4 py-2 flex-fill">
                            <input type="radio" name="payment_method" value="cod" checked onchange="handlePaymentChange()"> 
                            <span class="ms-1">Cash (COD)</span>
                        </label>
                        <label class="btn btn-outline-dark pill px-4 py-2 flex-fill">
                            <input type="radio" name="payment_method" value="qr" onchange="handlePaymentChange()"> 
                            <span class="ms-1">Pay by QR</span>
                        </label>
                    </div>

                    {{-- QR Code Section (បង្ហាញនៅខាងក្រោមនេះតែម្តង) --}}
                    <div id="qrBox" style="display:none;" class="mt-4 p-4 border rounded-4 bg-light shadow-sm">
                        <div class="text-center">
                            <h6 class="fw-bold mb-3"><i class="bi bi-qr-code-scan me-2 text-primary"></i>Scan to Pay</h6>
                            
                            @if($activeQR)
                                {{-- រូបភាព QR Code --}}
                                <div class="bg-white p-2 d-inline-block rounded-4 shadow-sm border mb-2">
                                    <img src="{{ asset('img/qrcode/' . $activeQR->qr_image) }}" 
                                         class="img-fluid rounded-3" 
                                         style="max-width:220px; display: block;">
                                </div>
                                <h5 class="fw-bold text-dark mt-2 mb-0">{{ $activeQR->qr_name }}</h5>
                            @else
                                <div class="alert alert-warning py-2 small">
                                    <i class="bi bi-exclamation-triangle me-1"></i> No QR found. Please contact support.
                                </div>
                            @endif

                            <div class="mt-3 bg-white py-2 px-3 d-inline-block rounded-pill border">
                                <small class="text-muted">Total to Pay:</small>
                                <span class="fw-bold text-primary fs-5 ms-1">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">Transaction ID</label>
                                <input name="payment_ref" class="form-control pill" placeholder="E.g. 123456">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">Upload Receipt <span class="text-danger">*</span></label>
                                <input type="file" name="receipt_image" id="receiptInput" class="form-control pill" accept="image/*">
                            </div>
                        </div>

                        {{-- Preview រូបភាព Receipt --}}
                        <div id="receiptPreview" class="mt-3 text-center" style="display:none;">
                            <div class="position-relative d-inline-block">
                                <img id="receiptImg" src="" class="rounded-3 border shadow-sm" style="max-height:180px;">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                    <i class="bi bi-check"></i>
                                </span>
                            </div>
                            <p class="small text-success mt-1 fw-bold">Receipt Selected!</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ផ្នែកខាងស្តាំ៖ សេចក្តីសង្ខេបការបញ្ជាទិញ --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4"><i class="bi bi-cart-check me-2"></i>Order Summary</h5>
                    
                    <div class="cart-items mb-3" style="max-height: 300px; overflow-y: auto;">
                        @foreach($cart as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <div class="fw-bold small">{{ $item['name'] }}</div>
                                        <small class="text-muted">{{ $item['qty'] }} unit(s) x ${{ number_format($item['price'], 2) }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold small">${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">Total Amount</span>
                        <span class="fw-bold fs-3 text-primary">${{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 pill py-3 fw-bold shadow">
                        PLACE ORDER NOW
                    </button>
                    
                    <p class="text-center small text-muted mt-3 mb-0">
                        <i class="bi bi-shield-check me-1"></i> Secure Checkout
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .pill { border-radius: 50px !important; padding-left: 20px; }
    .border-dashed { border-style: dashed !important; }
    input[type="radio"] { cursor: pointer; }
    .btn-outline-dark:hover { color: #fff !important; }
</style>

@endsection

@push('scripts')
<script>
    function handlePaymentChange() {
        // ចាប់យកតម្លៃដែល User រើស
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const qrBox = document.getElementById('qrBox');

        if (method === 'qr') {
            // បង្ហាញ QR Box
            qrBox.style.display = 'block';
            // Scroll ចុះមកក្រោមបន្តិចឱ្យឃើញ QR ច្បាស់
            qrBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            // លាក់វិញ
            qrBox.style.display = 'none';
        }
    }

    // Script សម្រាប់បង្ហាញរូបភាព Receipt ភ្លាមៗពេលភ្ញៀវ Upload
    document.getElementById('receiptInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('receiptPreview');
        const img = document.getElementById('receiptImg');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                img.src = event.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush