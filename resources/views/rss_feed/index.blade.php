<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Information</h1>

    <form method="GET" action="{{ route('rss_feed.index') }}" class="mb-4">
        <div class="form-row">
            <div class="col">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ $search }}">
            </div>
            <div class="col">
                <select name="sort" class="form-control">
                    <option value="">Sort By</option>
                    <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Title</option>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Link</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item['title'] }}</td>
                <td>{{ $item['description'] }}</td>
                <td><a href="{{ $item['link'] }}" target="_blank">Read More</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $items->links('vendor.pagination.bootstrap-5') }}
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
