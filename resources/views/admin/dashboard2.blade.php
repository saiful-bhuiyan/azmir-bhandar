

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src = "https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<body class="h-screen bg-gray-100">
    <div class="text-center mx-[.4rem] bg-sky-600 rounded-b-lg">
        <p class="text-base sm:text-large md:text-xl lg:text-4xl text-white font-bold leading-5 pt-2">নিউ আজমীর ভান্ডার</p>
        <p class="text-xs sm:text-sm md:text-base lg:text-lg text-white leading-5 tracking-widest">যাবতীয় পেঁয়াজ রসুন আদা,ইত্যাদি বিক্রয়
            ও কমিশন এজেন্ট</p>
        <p class="text-xs sm:text-sm md:text-base lg:text-lg text-white leading-5">আবু বক্কর সড়ক,ইসলামপুর রোড,ফেনী</p>
    </div>
    <div class="mx-[.4rem] my-2 py-1 bg-gray-200 rounded-b-lg">
        <p class="text-sm pl-4 sm:text-sm md:text-base lg:text-lg font-bold leading-5"><a href="#">Home /</a> <a
                href="#">Saiful</a></p>
    </div>
    <div class="w-auto lg:flex pb-12">
        <div class="lg:w-3/12 m-3 border-solid border-2">
            <p class="text-sm pl-4 text-red-600 text-center sm:text-sm md:text-base lg:text-lg font-bold leading-5">
                Online Member</p>
            <div class="m-3" id="online_user">
                <!-- Online users -->
            </div>
            <div class="flex items-center justify-center h-20">
            <a href="logout.php" class="bg-red-600 shadow-md hover:bg-blue-700 text-center text-white font-bold py-1 px-4 rounded mt-2">Logout</a>
                <!-- <a href="logout.php">Logout<i class='fa fa-log-out' ></i></a> --> 
            </div>
           
        </div>
        
        <div class="lg:w-6/12 m-3 border-solid border-2">
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px">
                    
                    <li class="mr-2">
                        <button id="setupBtn" class="inline-block p-4 border-b-2 active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500" >সেটাপ</button>
                    </li>
                    <li class="mr-2">
                        <button id="entryBtn" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">এন্ট্রি</button>
                    </li>
                    <li class="mr-2">
                        <button id="reportBtn" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">রিপোর্ট</button>
                    </li>
                    <li class="mr-2">
                        <button id="ponnoBtn" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">পণ্য রিপোর্ট</button>
                    </li>
                    <li class="mr-2 md:ml-20 lg:30">
                        <button id="AdminBtn" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Admin Panel</button>
                    </li>
                </ul>
            </div>
            <br>
            <div id="setupDiv" class="grid grid-cols-3 lg:grid-cols-5 gap-x-2 gap-y-2 border-solid">
                <a href="setup_amanot/amanot_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/supplier.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">আমানতী সেটাপ</p> 
                </a>
                <a href="setup_ponno/ponno_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/product.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য সেটাপ</p> 
                </a>
                <a href="setup_quality/quality_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/medal.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য কোয়ালিটি সেটাপ</p> 
                </a>
                <a href="setup_kreta/kreta_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/buyer.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্রেতা সেটাপ</p> 
                </a>
                <a href="setup_bikroy_marfot/bikroy_marfot_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/bikroy_marfot.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">বিক্রয় মারফত</p> 
                </a>
                <a href="setup_bank/bank_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/bank.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ব্যাংক ও একাউন্ট সেটাপ</p> 
                </a>
                <a href="setup_onno_khoroc/onno_khoroc_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/other_cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">অন্যান্য খরচ সেটাপ</p> 
                </a>
                <a href="setup_commission/commission_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/commission_product.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">কমিশন সেটাপ</p> 
                </a>
                <a href="setup_hawlat/hawlat_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/borrow.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">হাওলাত সেটাপ</p> 
                </a>
                <a href="setup_teriz/teriz_setup.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/budget.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">তেরিজ হিসাব সেটাপ</p> 
                </a>
            </div>

            <div id="entryDiv" class="grid grid-cols-3 lg:grid-cols-5 gap-x-2 gap-y-2 border-solid">
                <a href="entry_amdani/entry_amdani.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/import.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য আমদানী</p> 
                </a>
                <a href="entry_kharid/entry_kharid.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/order.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য খরিদ</p> 
                </a>
                <a href="entry_ponno_khoroc/entry_ponno_khoroc.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্যের খরচ</p> 
                </a>
                <a href="entry_bikroy/entry_bikroy.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/bikroy_marfot.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য বিক্রয়</p> 
                </a>
                <a href="entry_amanot_joma/entry_amanot_joma.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/postman.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">আমানতী জমা খরচ</p> 
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/bikroy_marfot.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">বিক্রয় মারফত এন্ট্রি</p> 
                </a>
                <a href="entry_bank/entry_bank.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/bank.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ব্যাংক হিসাব</p> 
                </a>
                <a href="entry_other_cost/entry_other_cost.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/other_cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">অন্যান্য খরচ এন্ট্রি</p> 
                </a>
                <a href="entry_monthly_cost/entry_monthly_cost.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/budget.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">মাসিক খরচ এন্ট্রি</p> 
                </a>
                <a href="entry_kreta_joma/entry_kreta_joma.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/kyc.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্রেতা জমা হিসাব</p> 
                </a>
            </div>

            <div id="reportDiv" class="grid grid-cols-3 lg:grid-cols-5 gap-x-2 gap-y-2 border-solid md:mb-16">
                <a href="report_amdani/report_amdani.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/import_ledger.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য আমদানী রিপোর্ট</p> 
                </a>
                <a href="report_kharid/report_kharid.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/payment-method.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">খরিদ রিপোর্ট</p> 
                </a>
                <a href="report_bikroy/report_bikroy.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/sale.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">বিক্রয় রিপোর্ট</p> 
                </a>
                <a href="report_cash/report_cash.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/document.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ক্যাশ রিপোর্ট</p> 
                </a>
                <a href="report_commission_ponno/report_commission_ponno.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/commission.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">কমিশন পন্যের রিপোর্ট</p> 
                </a>
                <a href="report_kharid_ponno/report_kharid_ponno.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/commission.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">খরিদ পন্যের রিপোর্ট</p> 
                </a>
                <a href="report_onno_khoroc/report_onno_khoroc.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/other_cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">অন্যান্য খরচ রিপোর্ট</p> 
                </a>
                <a href="report_bank/report_bank.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/bank.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">ব্যাংক রিপোর্ট</p> 
                </a>
                <a href="report_stock/report_stock.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/product.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">স্টক রিপোর্ট</p> 
                </a>
                <a href="report_commission/report_commission.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/commission.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">কমিশন রিপোর্ট</p> 
                </a>
                <a href="report_amanoti/report_amanoti.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/borrow.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">আমানতী লেজার</p> 
                </a>
                <a href="report_kreta/report_kreta.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/kyc.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">কাস্টমার রিপোর্ট</p> 
                </a>
                <a href="report_lav_loss/report_lav_loss.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/financial-profit.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">লাভ লস রিপোর্ট</p> 
                </a>
                <a href="report_koifiyot/report_koifiyot.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/borrow.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">কৈফিয়ত রিপোর্ট</p> 
                </a>
                <a href="report_ponno_khoroc/report_ponno_khoroc.php" target="_blank" rel="noopener noreferrer" class="grid justify-center items-center p-4 border" >
                    <img src="images/product_cost.png" alt="" class="w-8 h-8 mx-auto">
                    <p class="text-center mt-2">পন্য খরচ রিপোর্ট</p> 
                </a>
            </div>
            </div>
        </div>
        <!-- Notification section -->
        <div class="lg:w-3/12 m-3 border-solid border-2">
            <p class="text-sm pl-4 text-red-600 text-center sm:text-sm md:text-base lg:text-lg font-bold leading-5">
                Notification</p>
            <div class="m-3">
               
            </div>
        </div>
    </div>

    <footer class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow md:flex md:items-center justify-center md:p-6 dark:bg-gray-800 dark:border-gray-600">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© Development by Saiful Islam 2023 . All Rights Reserved.
        </span>
    </footer>

<script>

    $(document).ready(function(){
        $('#entryDiv').hide();
        $('#reportDiv').hide();
        $('#ponnoDiv').hide();
    })

    $("#setupBtn").click(function(){
      $("#setupBtn").addClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $("#setupBtn").removeClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#entryBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#entryBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#reportBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#reportBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#ponnoBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#ponnoBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#setupDiv').show();
      $('#entryDiv').hide();
      $('#reportDiv').hide();
      $('#ponnoDiv').hide();
    });

    $("#entryBtn").click(function(){
      $("#entryBtn").addClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $("#entryBtn").removeClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#setupBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#setupBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#reportBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#reportBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#ponnoBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#ponnoBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#entryDiv').show();
      $('#setupDiv').hide();
      $('#reportDiv').hide();
      $('#ponnoDiv').hide();
    });

    $("#reportBtn").click(function(){
      $("#reportBtn").addClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $("#reportBtn").removeClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#entryBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#entryBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#setupBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#setupBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#ponnoBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#ponnoBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#reportDiv').show();
      $('#setupDiv').hide();
      $('#entryDiv').hide();
      $('#ponnoDiv').hide();
    });

    $("#ponnoBtn").click(function(){
      $("#ponnoBtn").addClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $("#ponnoBtn").removeClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#reportBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#reportBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#entryBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#entryBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#setupBtn').removeClass("active text-blue-600 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500");
      $('#setupBtn').addClass("border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300");
      $('#ponnoDiv').show();
      $('#reportDiv').hide();
      $('#setupDiv').hide();
      $('#entryDiv').hide();
    });
</script>
</body>

</html>
