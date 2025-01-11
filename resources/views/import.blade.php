<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>import</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container pt-5">
        <div class="card">
            <div class="card-header">
                <div class="btnHeader d-flex justify-content-between align-items-center">
                    <div class="headerfor">
                        <h1>Customer CSV Import</h1>
                    </div>
                    <div class="buttonforCustomer">
                        <a class="btn btn-primary" href="/">Customer</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="mt-3" action="{{ url('/import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Customer CSV File Input</label>
                        <input name="import_file" class="form-control" type="file" id="formFile">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <h4>
                    Please run this command in terminal before submitting:
                    <code>php artisan queue:work --timeout=90</code>
                </h4>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
