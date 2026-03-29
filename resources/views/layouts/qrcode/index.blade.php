@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Upload New QR Code</h5>
                <form action="{{ route('qrcode.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>QR Name (e.g. ABA Bank)</label>
                        <input type="text" name="qr_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Select QR Image</label>
                        <input type="file" name="qr_image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload QR</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5>Manage QR Codes</h5>
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qrcodes as $qr)
                        <tr>
                            <td>{{ $qr->qr_name }}</td>
                            <td>
                                <img src="{{ asset('img/qrcode/'.$qr->qr_image) }}" width="80">
                            </td>
                            <td>
                                <a href="{{ route('qrcode.delete', $qr->id) }}" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure?')">
                                   <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection