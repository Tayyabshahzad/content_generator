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

        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    @if(Session::has('success'))
                        <p class="alert alert-info">{{ Session::get('success') }}</p>
                    @endif


                    <h1>Add KeyWords</h1>
                    <form class="form-group" method="post" enctype="multipart/form-data" action="{{ route('save') }}">
                        @csrf
                        <input type="text"  class="form-control" name="title" id=""   required> <br>
                        <input type="text"  class="form-control" name="keywords" id="" placeholder="Separate keywords with comma " required> <br>
                        <button class="btn btn-sm btn-info"> Save </button>
                    </form>

                     
                   
                </div>
               
                    <ul>

                    @foreach ($keywords as $keyword )
                            <li>  <a href="{{  route('view-content',$keyword->id) }} " > Generate Content for  {{ $keyword->title }}   </a> </li> 
                    @endforeach
                </ul>
            </div>
        </div>
       
</body>
</html>