<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{asset('js')}}/jquery.js"></script>
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
    
@if($sales)
<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
      <span class="p-1 text-white bg-blue-600">বিক্রয় মেমো</span>
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
          <p class="text-sm font-bold text-red-600">চৌথা/ইনভোয়েস নং : {{$sales->id}}</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">তারিখ : {{$sales->entry_date}}</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">বিক্রয় মারফত : {{$sales->marfot}}</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">ধরণ : @if($sales->sales_type == 1) নগদ @elseif($sales->sales_type == 2) বাকি @endif</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">ক্রেতার নাম : @if($sales->sales_type == 2){{$sales->kreta_setup->name}}@else{{$sales->cash_kreta_name}} @endif</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">ঠিকানা : @if($sales->sales_type == 2){{$sales->kreta_setup->address}}@else{{$sales->cash_kreta_address}} @endif</p>
        </div>
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">এরিয়া : @if($sales->sales_type == 2){{$sales->kreta_setup->area}} @endif</p>
        </div>
        
        <div class="col-span-2">
          <p class="text-sm font-bold text-red-600">মোবাইল নাম্বার : @if($sales->sales_type == 2){{$sales->kreta_setup->mobile}}@else{{$sales->cash_kreta_mobile}} @endif</p>
        </div>
      </div>
      <div class="container mt-2 h-full">
        <div class="mx-auto">
          <table class="w-full text-sm text-center border border-collapse border-slate-500">
            <thead class="text-xs text-gray-700">
              <tr>
                <th scope="col" class="border border-slate-500">নং</th>
                <th scope="col" class="border border-slate-500">পন্যের নাম</th>
                <th scope="col" class="border border-slate-500">মার্কা</th>
                <th scope="col" class="border border-slate-500">সাইজ</th>
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
                $total_kreta_commission = 0;
                $labour = 0;
                $other = 0;
                @endphp

    
                @foreach($sales->ponno_sales_entry as $s)

                @php
                $total_sale += $s->sales_weight * $s->sales_rate;
                $total_sale_qty += $s->sales_qty;
                $total_sale_weight += $s->sales_weight;
                $total_kreta_commission +=  $s->kreta_commission;
                $labour += $s->labour;
                $other += $s->other;
                @endphp
                <tr>
                    <td class="border border-slate-500">{{$count++}}</td>
                    <td class="border border-slate-500">{{$s->ponno_purchase_entry->ponno_setup->ponno_name}}</td>
                    <td class="border border-slate-500">{{$s->ponno_purchase_entry->ponno_marka_setup->ponno_marka}}</td>
                    <td class="border border-slate-500">{{$s->ponno_purchase_entry->ponno_size_setup->ponno_size}}</td>
                    <td class="border border-slate-500">{{$s->sales_qty}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight}}</td>
                    <td class="border border-slate-500">{{$s->sales_rate}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight * $s->sales_rate}}</td>
                </tr>
               @endforeach
                <tr>
                    <td colspan="4" class="font-bold border border-slate-500">মোট : </td>
                    <td class="font-bold border border-slate-500">{{$total_sale_qty}}</td>
                    <td class="font-bold border border-slate-500">{{$total_sale_weight}}</td>
                    <td class="font-bold border border-slate-500">-</td>
                    <td class="font-bold border border-slate-500">{{$total_sale}}</td>
                </tr>
               <tr>
                  <td colspan="7" class="border border-slate-500 font-bold">(+) ক্রেতা কমিশন : </td>
                  <td class="border border-slate-500"> {{$total_kreta_commission}}</td>
               </tr>
               @if($labour > 0)
                <tr>
                  <td colspan="7" class="border border-slate-500 font-bold">(+) লেবার : </td>
                  <td class="border border-slate-500"> {{$labour}}</td>
                </tr>
               @endif
               @if($other > 0)
                <tr>
                  <td colspan="7" class="border border-slate-500 font-bold">(+) অন্যান্য : </td>
                  <td class="border border-slate-500"> {{$other}}</td>
                </tr>
               @endif
               @if($sales->discount > 0)
                <tr>
                  <td colspan="7" class="border border-slate-500 font-bold">(-) ডিসকাউন্ট : </td>
                  <td class="border border-slate-500"> {{$sales->discount}}</td>
                </tr>
               @endif
               @php 
                $current_sale = $total_sale + $total_kreta_commission + $labour + $other - $sales->discount;
               @endphp
                <tr>
                    <td colspan="7" class="font-bold border border-slate-500 text-right">মোট টাকা : </td>
                    <td class="font-bold border border-slate-500">{{$current_sale}}</td>
                </tr>
                @if($sales->sales_type == 2)
                @php
                $sabek = 0;
                $sabek += $old_sales ? $old_sales : 0;
                $sabek -= $joma ? $joma : 0;
                $sabek -= $koifiyot ? $koifiyot : 0;
                $sabek += $kreta_old_amount ? $kreta_old_amount : 0;
                @endphp
                <tr>
                    <td colspan="7" class="font-bold border border-slate-500">সাবেক : </td>
                    <td class="font-bold border border-slate-500">{{$sabek - $current_sale}}</td>
                </tr>
                <tr>
                    <td colspan="7" class="font-bold border border-slate-500">সর্বমোট : </td>
                    <td class="font-bold border border-slate-500">{{$sabek}}</td>
                </tr>
                @endif
            </tbody>
          </table>
        </div>
        <div class="flex justify-around mt-12">
          <div class="text-center">
          <hr class="h-[2px] my-1 bg-black border-0">
            <h1 class="text-lg">ম্যানেজারের স্বাক্ষর</h1>
          </div>
          <div class="text-center">
          <hr class="h-[2px] my-1 bg-black border-0">
            <h1 class="text-lg ">অডিটরের স্বাক্ষর</h1>
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