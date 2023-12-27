<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Report</title>
    <script src="{{asset('js')}}/jquery.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('datatable')}}/datatables.min.css">
    <script src="{{asset('datatable')}}/datatables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" />

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@600;700;800;900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@500&display=swap');
    body{ 
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .barlow{
        font-family: 'Barlow', sans-serif;
    }
    </style>
</head>

<body class="">
@yield('report_body')
</body>

</html>