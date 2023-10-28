<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Home</title>
    <!-- <link rel="stylesheet" href="./output/tailwind.css" /> -->
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('datatable')}}/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" />

 
    <script src="{{asset('datatable')}}/datatables.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@600;700;800;900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@500&display=swap');
    body{
        
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .checkbox {
    display: none;
    }

    .slider {
        width: 40px;
        height: 20px;
        background-color: lightgray;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: center;
        border: 1px solid transparent;
        transition: .3s;
        box-shadow: 0 0 10px 0 rgb(0, 0, 0, 0.25) inset;
        cursor: pointer;
    }

    .slider::before {
        content: '';
        display: block;
        width: 100%;
        height: 100%;
        background-color: #fff;
        transform: translateX(-20px);
        border-radius: 10px;
        transition: .3s;
        box-shadow: 0 0 10px 3px rgb(0, 0, 0, 0.25);
    }

    .checkbox:checked ~ .slider::before {
        transform: translateX(20px);
        box-shadow: 0 0 10px 3px rgb(0, 0, 0, 0.25);
    }

    .checkbox:checked ~ .slider {
        background-color: #2196F3;
    }

    .checkbox:active ~ .slider::before {
        transform: translate(0);
    }
    footer{
        font-family: 'Barlow', sans-serif;
    }
    .barlow{
        font-family: 'Barlow', sans-serif;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }

    </style>
</head>

<body class="h-screen bg-gray-100">
    <div class="text-center mx-[.4rem] bg-sky-600 rounded-b-lg">
        <p class="text-base sm:text-large md:text-xl lg:text-4xl text-white font-bold leading-5 pt-2">নিউ আজমীর ভান্ডার</p>
        <p class="text-xs sm:text-sm md:text-base lg:text-lg text-white leading-5 ">যাবতীয় পেঁয়াজ রসুন আদা,ইত্যাদি বিক্রয়
            ও কমিশন এজেন্ট</p>
        <p class="text-xs sm:text-sm md:text-base lg:text-lg text-white leading-5">আবু বক্কর সড়ক,ইসলামপুর রোড,ফেনী</p>
    </div>

    @yield('body')

    <footer class="fixed h-8 text-center bottom-0 left-0 z-20 w-full px-4 bg-white border-t border-gray-200 shadow md:flex md:items-center justify-center  dark:bg-gray-800 dark:border-gray-600">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© Development by Saiful Islam 2023 . All Rights Reserved.
        </span>
    </footer>

    {!! Toastr::message() !!}
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function confirmation()
        {
            if(confirm('আপনি কই সিউর ?'))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
</script>
</body>

</html>