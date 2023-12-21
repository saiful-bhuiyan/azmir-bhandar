<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- <link rel="stylesheet" href="./output/tailwind.css" /> -->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<body class="h-screen bg-gray-100">
    <div class="text-center mx-[.4rem] bg-sky-600 rounded-b-lg">
        <p class="text-base sm:text-large md:text-xl lg:text-4xl text-white font-bold leading-5 pt-2">এডমিন প্যানেল</p>
        <p class="text-base sm:text-large md:text-xl lg:text-4xl text-white font-bold leading-5 pt-2">নিউ আজমীর ভান্ডার</p>
        <p class="text-xs sm:text-sm md:text-base lg:text-lg text-white leading-5 tracking-widest">যাবতীয় পেঁয়াজ রসুন আদা,ইত্যাদি বিক্রয়
            ও কমিশন এজেন্ট</p>
        <p class="text-xs sm:text-sm md:text-base lg:text-lg text-white leading-5">আবু বক্কর সড়ক,ইসলামপুর রোড,ফেনী</p>
    </div>
    <div class="mx-[.4rem] my-2 py-1 bg-gray-200 rounded-b-lg">
        <p class="text-sm pl-4 sm:text-sm md:text-base lg:text-lg font-bold leading-5"><a href="#">Home /</a> <a href="#">Saiful</a></p>
    </div>
    <div class="w-auto lg:flex pb-12">
        <div class="lg:w-3/12 m-3 border-solid border-2">
            <p class="text-sm pl-4 text-red-600 text-center sm:text-sm md:text-base lg:text-lg font-bold leading-5">
                Online Member</p>
            <div class="m-3" id="online_user">
                <!-- Online users -->
            </div>
            <div class="flex items-center justify-center h-20">
                <a href="{{route('admin.logout')}}" class="bg-red-600 shadow-md hover:bg-blue-700 text-center text-white font-bold py-1 px-4 rounded mt-2">Logout</a>
                <!-- <a href="logout.php">Logout<i class='fa fa-log-out' ></i></a> -->
            </div>

        </div>

        <div class="lg:w-6/12 m-3 border-solid border-2">
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px">

                    <li class="mr-2">
                        <button id="setupBtn" class="inline-block p-4 border-b-2 active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500">সেটাপ</button>
                    </li>
                    <li class="mr-2">
                        <button id="entryBtn" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">এন্ট্রি</button>
                    </li>
                </ul>
            </div>
            <br>
            <div id="setupDiv" class="grid grid-cols-3 lg:grid-cols-5 gap-x-2 gap-y-2 border-solid">
                <a href="{{route('mohajon_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/supplier.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">মহাজন সেটাপ এডমিন</p>
                </a>
                <a href="{{route('ponno_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/product.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য সেটাপ</p>
                </a>
                <a href="{{route('ponno_size_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/medal.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য়ের সাইজ সেটাপ</p>
                </a>
                <a href="{{route('ponno_marka_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/medal.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য়ের মার্কা সেটাপ</p>
                </a>
                <a href="{{route('kreta_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/buyer.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্রেতার সেটাপ</p>
                </a>
                <a href="{{route('bikroy_marfot_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/bikroy_marfot.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">বিক্রয় মারফত সেটাপ</p>
                </a>
                <a href="{{route('bank_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/bank.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ব্যাংক সেটাপ</p>
                </a>
                <a href="{{route('bank_check_book_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/bank.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ব্যাংকের চেক বই সেটাপ</p>
                </a>
                <a href="{{route('amanot_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/other_cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">আমানত সেটাপ</p>
                </a>
                <a href="{{route('hawlat_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/borrow.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">হাওলাত সেটাপ</p>
                </a>
                <a href="{{route('other_joma_khoroc_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/budget.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">অন্যান্য জমা খরচ সেটাপ</p>
                </a>
                <a href="{{route('mohajon_commission_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/commission_product.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">মহাজন কমিশন সেটাপ</p>
                </a>
                <a href="{{route('kreta_commission_setup.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/commission_product.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্রেতার কমিশন সেটাপ</p>
                </a>
                <a href="{{route('user_setup.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/supplier.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ইউজার সেটাপ এডমিন</p>
                </a>
            </div>

            <div id="entryDiv" class="grid grid-cols-3 lg:grid-cols-5 gap-x-2 gap-y-2 border-solid">
                <a href="{{route('ponno_purchase_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/import.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য গ্রহন</p>
                </a>
                <a href="{{route('ponno_sales_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/bikroy_marfot.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য বিক্রয়</p>
                </a>
                <a href="{{route('arod_chotha.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/order.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">আড়ৎ চৌথা</p>
                </a>
                <a href="{{route('kreta_joma_entry.admin')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/kyc.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্রেতার জমা</p>
                </a>
                <a href="{{route('bank_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/bank.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ব্যাংক উত্তোলন/জমা</p>
                </a>
                <a href="{{route('mohajon_payment_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/postman.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">মহাজন পেমেন্ট</p>
                </a>
                <a href="{{route('mohajon_return_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/postman.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">মহাজন ফেরত</p>
                </a>
                <a href="{{route('amanot_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/postman.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">আমানতী জমা/খরচ</p>
                </a>
                <a href="{{route('hawlat_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/postman.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">হাওলাত জমা/খরচ</p>
                </a>
                <a href="{{route('other_joma_khoroc_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/postman.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">অন্যান্য জমা/খরচ</p>
                </a>
                <a href="{{route('kreta_koifiyot_entry.index')}}" onclick="return false;" class="grid justify-center items-center p-4 border url">
                    <img src="{{asset('frontend')}}/image/cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্রেতার কৈফিয়ত খরচ</p>
                </a>
            </div>
        </div>
    </div>
    <!-- Notification section -->
    <!-- <div class="lg:w-3/12  border-solid border-2">
            <p class="text-sm pl-4 text-red-600 text-center sm:text-sm md:text-base lg:text-lg font-bold leading-5">
                Notification</p>
            <div class="m-3">
               
            </div>
        </div> -->
    </div>

    <footer class="fixed h-8 text-center bottom-0 left-0 z-20 w-full px-4 bg-white border-t border-gray-200 shadow md:flex md:items-center justify-center  dark:bg-gray-800 dark:border-gray-600">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© Development by Saiful Islam 2023 . All Rights Reserved.
        </span>
    </footer>

    <script>
        $(document).ready(function() {
            $('#entryDiv').hide();
        })

        $("#setupBtn").click(function() {
            $("#setupBtn").addClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
            $("#setupBtn").removeClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
            $('#entryBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
            $('#entryBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
            $('#setupDiv').show();
            $('#entryDiv').hide();
            $('#reportDiv').hide();
        });

        $("#entryBtn").click(function() {
            $("#entryBtn").addClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
            $("#entryBtn").removeClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
            $('#setupBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
            $('#setupBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
            $('#entryDiv').show();
            $('#setupDiv').hide();
            $('#reportDiv').hide();
        });


        $('.url').click(function(){
            var left = (screen.width - 800) / 2;
            var top = (screen.height - 700) / 4;

            var url = $(this).attr('href');

            var myWindow = window.open(url, url,
            'resizable=yes, width=' + '800'
            + ', height=' + '700' + ', top='
            + top + ', left=' + left);
        })
    </script>
</body>

</html>