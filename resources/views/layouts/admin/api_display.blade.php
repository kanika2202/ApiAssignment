@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm bg-dark rounded-4">
    <div class="card-header bg-dark border-secondary d-flex justify-content-between align-items-center py-3">
        <h5 class="text-info mb-0"><i class="bi bi-cpu"></i> API JSON Viewer</h5>
        <button class="btn btn-sm btn-outline-light" onclick="copyJSON()">Copy JSON</button>
    </div>
    <div class="card-body p-0">
        <pre id="json-viewer" class="m-0 p-4" style="color: #a6e22e; background: #1e1e1e; font-family: 'Consolas', monospace; font-size: 14px; line-height: 1.6; overflow-x: auto;">
{
    "status": true,
    "message": "{{ $title }}",
    "data": {!! json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
}
        </pre>
    </div>
</div>

<script>
    // មុខងារបំប្លែង URL ឱ្យទៅជា Link ដែលអាចចុចបាន
    function activateLinks() {
        const viewer = document.getElementById('json-viewer');
        const content = viewer.innerHTML;
        const urlPattern = /"(https?:\/\/[^"]+)"/g;

        viewer.innerHTML = content.replace(urlPattern, function(match, url) {
            // នៅពេលចុច វានឹងហៅ function fetchNewData ជំនួសឱ្យការបើក Tab ថ្មី
            return `"<a href="javascript:void(0)" onclick="fetchNewData('${url}')" style="color: #61dafb; text-decoration: underline;">${url}</a>"`;
        });
    }

    // មុខងារទាញទិន្នន័យថ្មីមកបង្ហាញ (Interactive List)
    function fetchNewData(url) {
        const viewer = document.getElementById('json-viewer');
        viewer.innerHTML = "<span class='text-secondary'>Loading data from " + url + "...</span>";

        fetch(url)
            .then(response => response.json())
            .then(newData => {
                // បង្ហាញទិន្នន័យថ្មីជា JSON
                viewer.innerHTML = JSON.stringify(newData, null, 4);
                // ធ្វើឱ្យ URL ក្នុងទិន្នន័យថ្មីអាចចុចបានបន្តទៀត
                activateLinks();
            })
            .catch(error => {
                viewer.innerHTML = "<span class='text-danger'>Error: " + error + "</span>";
            });
    }

    function copyJSON() {
        navigator.clipboard.writeText(document.getElementById('json-viewer').innerText);
        alert('Copied!');
    }

    // ដំណើរការដំបូងពេល Load Page
    window.onload = activateLinks;
</script>
@endsection
<script>
function fetchNewData(url) {
    const viewer = document.getElementById('json-viewer');
    viewer.innerHTML = "<span style='color: #666;'>Loading...</span>";

    fetch(url)
        .then(response => {
            // ប្រសិនបើ Response មិនមែនជា JSON (ឧទាហរណ៍ចេញ HTML Error)
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new TypeError("URL នេះមិនបានបោះ JSON មកទេ (វាអាចជាទំព័រ HTML Error ឬបាត់ Token)!");
            }
            return response.json();
        })
        .then(newData => {
            viewer.innerHTML = JSON.stringify(newData, null, 4);
            activateLinks(); 
        })
        .catch(error => {
            // បង្ហាញ Error ឱ្យច្បាស់ដើម្បីស្រួលដោះស្រាយ
            viewer.innerHTML = "<span style='color: #ff5f56;'>Error: " + error.message + "</span>";
        });
}
</script>