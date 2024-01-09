<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sales Memo Template</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap');
    .font-bangla{
      font-family: 'Noto Sans Bengali', sans-serif;
    }
    @media print {
    body {
      -webkit-print-color-adjust: exact;
      width: 400px;
      height: auto;
    }
    }
  </style>
</head>
<body>
@if($sales)
  <div class="mx-auto w-[400px] h-[400px]">
    <div class="my-2 text-center">
      <h1 class="text-2xl font-bold text-indigo-800 font-bangla">নিউ আজমির ভান্ডার</h1>
    </div>
    <div class="bg-indigo-800 text-center py-2">
      <p class="text-sm text-white font-bangla">যাবতীয় কাঁচা ও পাকা মালের কমিশন এজেন্ট</p>
    </div>
    <div class="my-1 px-2 text-center">
      <p class="text-xs text-indigo-800 font-bangla">ইসলামপুর রোড , ফেনী | দোকান ০১৬৮৯৩০৬১৩১</p>
      <p class="text-xs text-indigo-800 font-bangla">নাহিদ ০১৮৩৯৩৯৮০৫১ , ফয়সাল ০১৮৪৩৮১৫৮৯০</p>
    </div>
    <div class="px-4 py-1">
      <hr class="bg-indigo-600 h-[2px]">
      <hr class="bg-indigo-600 h-[2px]">
    </div>
    <div class="px-4 mt-2">
      <div class="flex place-content-stretch text-left text-gray-600">
        <h1 class="font-bold text-sm w-1/2">তারিখ : <span class="text-gray-900">{{date('d-m-Y', strtotime($sales->entry_date))}}</span></h1>
        <h1 class="font-bold text-sm w-1/2">ইনভয়েস : <span class="text-gray-900">{{$sales->id}}</span></h1>
      </div>
      <div class="py-1 text-gray-600">
        <h1 class="py-1 font-bold text-sm">ক্রেতার নাম : <span class="text-gray-900 text-right">@if($sales->sales_type == 2){{$sales->kreta_setup->name}}@else{{$sales->cash_kreta_name}} @endif</span></h1>
        <h1 class="py-1 font-bold text-sm">ক্রেতার ঠিকানা : <span class="text-gray-900">@if($sales->sales_type == 2){{$sales->kreta_setup->address}}@else{{$sales->cash_kreta_address}} @endif</span></h1>
        <h1 class="py-1 font-bold text-sm">এরিয়া : <span class="text-gray-900">@if($sales->sales_type == 2){{$sales->kreta_setup->area}} @endif</span></h1>
        <h1 class="py-1 font-bold text-sm">মোবাইল : <span class="text-gray-900">@if($sales->sales_type == 2){{$sales->kreta_setup->mobile}}@else{{$sales->cash_kreta_mobile}} @endif</span></h1>
        <h1 class="py-1 font-bold text-sm">ধরণ : <span class="text-gray-900">@if($sales->sales_type == 1) নগদ @elseif($sales->sales_type == 2) বাকি @endif</span></h1>
      </div>
      
    </div>

    <div class="px-2 mt-2 h-full">
      <div class="mx-auto">
        <table class="w-full text-sm text-center border border-collapse border-slate-500">
          <thead class="text-xs bg-gray-100 text-gray-700">
            <tr>
              <th scope="col" class="border border-slate-500">নং</th>
              <th scope="col" class="border border-slate-500">পন্যের নাম</th>
              <th scope="col" class="border border-slate-500">মার্কা</th>
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
                    <td class="border border-slate-500">{{$s->sales_qty}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight}}</td>
                    <td class="border border-slate-500">{{$s->sales_rate}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight * $s->sales_rate}}</td>
                </tr>
               @endforeach
                <tr>
                    <td colspan="3" class="font-bold border border-slate-500">মোট : </td>
                    <td class="font-bold border border-slate-500">{{$total_sale_qty}}</td>
                    <td class="font-bold border border-slate-500">{{$total_sale_weight}}</td>
                    <td class="font-bold border border-slate-500">-</td>
                    <td class="font-bold border border-slate-500">{{$total_sale}}</td>
                </tr>
               <tr>
                  <td colspan="6" class="border border-slate-500 font-bold px-2">(+) ক্রেতা কমিশন : </td>
                  <td class="border border-slate-500"> {{$total_kreta_commission}}</td>
               </tr>
                <tr>
                  <td colspan="6" class="border border-slate-500 font-bold  px-2">(+) লেবার : </td>
                  <td class="border border-slate-500"> {{$labour ? $labour : 0}}</td>
                </tr>
                <tr>
                  <td colspan="6" class="border border-slate-500 font-bold px-2">(+) অন্যান্য : </td>
                  <td class="border border-slate-500"> {{$other ? $other : 0}}</td>
                </tr>
                <tr>
                  <td colspan="6" class="border border-slate-500 font-bold  px-2">(-) ডিসকাউন্ট : </td>
                  <td class="border border-slate-500"> {{$sales->discount ? $sales->discount : 0}}</td>
                </tr>
               @php 
                $current_sale = $total_sale + $total_kreta_commission + $labour + $other - $sales->discount;
               @endphp
                <tr>
                    <td colspan="6" class="font-bold border border-slate-500 text-right px-2">মোট টাকা : </td>
                    <td class="font-bold border border-slate-500">{{$current_sale}}</td>
                </tr>
                @if($sales->sales_type == 2)
                @php
                $sabek = 0;
                $sabek += $kreta_old_amount;
                @endphp
                <tr>
                    <td colspan="6" class="font-bold border border-slate-500 text-right px-2">(+) সাবেক : </td>
                    <td class="font-bold border border-slate-500">{{$sabek - $current_sale}}</td>
                </tr>
                <tr>
                    <td colspan="6" class="font-bold border text-base border-slate-500 text-right px-2">সর্বমোট : </td>
                    <td class="font-bold border border-slate-500 text-base">{{$sabek}}</td>
                </tr>
                @endif
            </tbody>
        </tbody>
        </table>

        
      </div>
      <div class="bottom-0 mt-4">
          <h1 class="text-sm font-bold font-bangla text-gray-600">বি.দ্র : বিক্রিত মাল ফেরত যোগ্য নয়</h1>
        </div>
    </div>

    
  </div>
  
  @else
  <h1>no record found</h1>
  @endif
</body>
</html>