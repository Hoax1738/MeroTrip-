<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Esewa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

    <div class="container">
        @if(session('success_message'))
        <div class="alert alert-success" role="alert">
            {{session('success_message')}}
          </div>
        @endif

        @if(session('error_message'))
        <div class="alert alert-danger" role="alert">
            {{session('error_message')}}
          </div>
        @endif
        <a class="btn btn-info" href="{{url('/commitments')}}">Go Back</a>
    </div>


</body>
</html>
