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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" />

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

<body class="">
@if($purchase)
  <div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white rounded shadow-lg md:p-8">
      <span class="p-1 text-white bg-blue-600">পন্যের বিবরনী</span>
      <h1 class="pt-4 text-3xl font-bold text-red-600">নিউ আজমীর ভান্ডার</h1>
      <p class="text-lg font-bold text-blue-600">হলুদ,মরিচ,বাদাম,পেঁয়াজ,রসুন,আদা এবং যাবতীয় কাচা মালের আড়ত</p>
      <p class="text-lg font-bold text-red-600">সাথী মার্কেট ইসলামপুর রোড,ফেনী</p>
      <div class="flex justify-center pt-1 space-x-4 divide-x-2 divide-red-600 item-center">
        <div class="text-center ">
          <p class="text-red-600">জাহিদুল ইসলাম নাহিদ</p>
          <p class="text-blue-600">01839398051</p>
        </div>
        <div class="pl-4 text-center">
          <p class="text-red-600">ওমর ফয়সাল মজুমদার</p>
          <p class="text-blue-600">01843875890</p>
        </div>
      </div>
      <div class="grid grid-cols-4 gap-4 pt-4 text-sm text-left gap-y-2 md:grid-cols-4">
        <div class="col-span-2">
          <p class="text-base font-bold text-red-600">চৌথা/ইনভোয়েস নং : {{$purchase->id}}</p>
        </div>
        <div class="col-span-2">
          <p class="text-base font-bold text-red-600">ধরণ : @if($purchase->purchase_type == 1) নিজ খরিদ @elseif($purchase->purchase_type == 2) কমিশন @endif</p>
        </div>
      </div>
      <div class="flex mt-4">
        <div class="relative w-2/3 mb-6 bg-red-100">
          <table class="w-full text-sm text-center border border-collapse border-slate-500">
            <thead class="text-xs text-gray-700">
              <tr>
                <th scope="col" class="border border-slate-500">নং</th>
                <th scope="col" class="border border-slate-500">তারিখ</th>
                <th scope="col" class="border border-slate-500">ইনভয়েস</th>
                <th scope="col" class="border border-slate-500">সংখ্যা</th>
                <th scope="col" class="border border-slate-500">ওজন</th>
                <th scope="col" class="border border-slate-500">দর</th>
                <th scope="col" class="border border-slate-500">মোট টাকা</th>
              </tr>
            </thead>
            <tbody>
                @php
                $count = 1;
                $total_sale = 0;
                $total_sale_qty = 0;
                $total_sale_weight = 0;
                $total_mohajon_commission = 0;
        
                
            
                @endphp
    
                @foreach($sales as $s)

                @php
                $total_sale += $s->sales_weight * $s->sales_rate;
                $total_sale_qty += $s->sales_qty;
                $total_sale_weight += $s->sales_weight;
                $total_mohajon_commission += $purchase->mohajon_commission * $s->sales_weight;
                @endphp
                <tr>
                    <td class="border border-slate-500">{{$count++}}</td>
                    <td class="border border-slate-500">{{date('d-m-Y', strtotime($s->ponno_sales_info->entry_date))}}</td>
                    <td class="border border-slate-500 font-bold text-blue-700"><a class="url" onclick="return false;" href="{{route('ponno_sales_report.memo',$s->sales_invoice)}}">{{$s->sales_invoice}}</a></td>
                    <td class="border border-slate-500">{{$s->sales_qty}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight}}</td>
                    <td class="border border-slate-500">{{$s->sales_rate}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight * $s->sales_rate}}</td>
                </tr>
               @endforeach

               @php 
                $total_cost = $purchase->labour_cost + $purchase->truck_cost +
                            $purchase->van_cost + $purchase->other_cost + $purchase->tohori_cost;
              
                $total_cost += $total_mohajon_commission;
                $total_cost += $purchase->weight * $purchase->rate;
             
                $total_amount = $total_sale - $total_cost;
                
              @endphp
            </tbody>
            <tfoot class="">
              <tr>
                <td colspan="3" class="font-bold border border-slate-500">সর্বমোট বিক্রি :</td>
                <td class="font-bold border border-slate-500">{{$total_sale_qty}}</td>
                <td class="font-bold border border-slate-500">{{$total_sale_weight}}</td>
                <td class="font-bold border border-slate-500"></td>
                <td class="font-bold border border-slate-500">{{$total_sale}}</td>
              </tr>
              @if($total_amount < 0)
              @if($purchase->quantity == $total_sale_qty)
              @php 
              $loss = 0 - $total_amount;
              @endphp
              <tr>
                <td colspan="6" class="font-bold border border-slate-500">দেনা : </td>
                <td class="font-bold border border-slate-500">{{$loss}}</td>
              </tr>
              <tr>
                <td colspan="6" class="font-bold border border-slate-500">সর্বমোট টাকা : </td>
                <td class="font-bold border border-slate-500">{{$total_sale + $loss}}</td>
              </tr>
              @endif
              @endif
              <tr>
            </tfoot>
          </table>
        </div>
        <div class="relative w-1/3 mb-6 overflow-x-auto bg-white">
          <div class="font-bold">
            <div class="bg-blue-600">
              <p class="text-white">পন্যের বিবরনী</p>
            </div>
            <div class="text-left bg-sky-200">
              <p class="p-1 text-xs text-gray-800">আমদানী তারিখ : {{date('d-m-Y', strtotime($purchase->entry_date))}}</p>
              <p class="p-1 text-xs text-gray-800">ট্রাক নং : {{$purchase->gari_no}}</p>
              <p class="p-1 text-xs text-gray-800">মহাজনের নাম : {{$purchase->mohajon_setup->name}}</p>
              <p class="p-1 text-xs text-gray-800">ঠিকানা : {{$purchase->mohajon_setup->address}}</p>
              <p class="p-1 text-xs text-gray-800">এরিয়া : {{$purchase->mohajon_setup->area}}</p>
              <p class="p-1 text-xs text-gray-800">পন্যের নাম : {{$purchase->ponno_setup->ponno_name}}</p>
              <p class="p-1 text-xs text-gray-800">মার্কা : {{$purchase->ponno_marka_setup->ponno_marka}}</p>
              <p class="p-1 text-xs text-gray-800">সাইজ : {{$purchase->ponno_size_setup->ponno_size}}</p>
              <p class="p-1 text-xs text-gray-800">গ্রহণ সংখ্যা : {{$purchase->quantity}}</p>
            </div>
          </div>
          <div class="font-bold">
            <div class="bg-blue-600">
              <p class="text-white">খরচের বিবরনী</p>
            </div>
            <div class="text-left bg-sky-200">
              <p class="p-1 text-xs text-gray-800">বিক্রি সংখ্যা : {{$total_sale_qty}}</p>
              <p class="p-1 text-xs text-gray-800">মহাজন কমিশন : {{$total_mohajon_commission}}</p>
              <p class="p-1 text-xs text-gray-800">লেবার খরচ : {{$purchase->labour_cost + $labour_cost}}</p>
              <p class="p-1 text-xs text-gray-800">ট্রাক ভাড়া : {{$purchase->truck_cost + $truck_cost}}</p>
              <p class="p-1 text-xs text-gray-800">ভ্যান ভাড়া : {{$purchase->van_cost + $van_cost}}</p>
              <p class="p-1 text-xs text-gray-800">অন্যান্য খরচ : {{$purchase->other_cost + $other_cost}}</p>
              <p class="p-1 text-xs text-gray-800">তহরি : {{$purchase->tohori_cost + $tohori_cost}}</p>
              
              @if($purchase->purchase_type == 1)
              <p class="p-1 text-xs text-gray-800">মোট ক্রয় : {{$purchase->weight * $purchase->rate}}</p>
              @endif
              <p class="p-1 text-xs text-gray-800">মোট খরচ : {{$total_cost}}</p>

              @if($total_amount > 0)
              @if($purchase->quantity == $total_sale_qty)
              <p class="p-1 text-xs text-gray-800">চৌথা : {{$total_amount}}</p>
              @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  @else
  <h1>no record found</h1>
  @endif




</body>

</html>

<script>
    $('.url').click(function() {
        var left = (screen.width - 800) / 2;
        var top = (screen.height - 700) / 4;

        var url = $(this).attr('href');

        var myWindow = window.open(url, url,
            'resizable=yes, width=' + '400' +
            ', height=' + '1200' + ', top=' +
            top + ', left=' + left);
    })
</script>
