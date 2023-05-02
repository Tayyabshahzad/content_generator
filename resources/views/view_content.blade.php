<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
        @foreach ($data as $content )
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>
                            {{ $content->keyword }}
                        </h1>
                        <p>
                                {{ $content->content }}
                        </p>
                        <p>
                            <img src="{{  $content->image }}" alt="" class="img img-responsive">
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
       
       
</body>
</html>