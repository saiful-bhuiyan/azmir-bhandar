@if($purchase)
<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white rounded shadow-lg md:p-8">
      <span class="p-1 text-white bg-blue-600">আড়ত চৌথা</span>
      @component('components.project_headline')
      @endcomponent

      <div class="grid grid-cols-6 gap-4 pt-4 text-sm text-left gap-y-2 md:grid-cols-6">
        <div class="col-span-2">
          <p class="text-base font-bold text-red-600">চৌথা/ইনভোয়েস নং : {{$purchase->id}}</p>
        </div>
        <div class="col-span-2">
          <p class="text-base font-bold text-red-600">ধরণ : @if($purchase->purchase_type == 1) নিজ খরিদ @elseif($purchase->purchase_type == 2) কমিশন @endif</p>
        </div>
        <div class="col-span-2">
          <p class="text-base font-bold text-red-600">চৌথার তারিখ : {{date('d-m-Y', strtotime($sales_info->entry_date))}}</p>
        </div>
      </div>
      <div class="flex mt-4">
        <div class="relative w-2/3 mb-6 bg-red-100">
          <table class="w-full text-sm text-center border border-collapse border-slate-500">
            <thead class="text-xs text-gray-700">
              <tr>
                <th scope="col" class="border border-slate-500">নং</th>
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
                $total_cost = 0;
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
                    <td class="border border-slate-500">{{$s->sales_qty}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight}}</td>
                    <td class="border border-slate-500">{{$s->sales_rate}}</td>
                    <td class="border border-slate-500">{{$s->sales_weight * $s->sales_rate}}</td>
                </tr>
               @endforeach

               @php 
               if($sales_info)
               {
                  $total_cost = $sales_info->labour_cost + $sales_info->truck_cost +
                  $sales_info->van_cost + $sales_info->other_cost + $sales_info->tohori_cost;
               }
                
                $total_cost += $total_mohajon_commission;
             
                $total_amount = $total_sale + $total_cost;
                
              @endphp
            </tbody>
            <tfoot class="">
              <tr>
                <td class="font-bold border border-slate-500">মোট :</td>
                <td class="font-bold border border-slate-500">{{$total_sale_qty}}</td>
                <td class="font-bold border border-slate-500">{{$total_sale_weight}}</td>
                <td class="font-bold border border-slate-500"></td>
                <td class="font-bold border border-slate-500">{{$total_sale}}</td>
              </tr>
              <tr>
                <td colspan="4" class="font-bold border text-base border-slate-500">নগদ পাওনা : </td>
                <td class="font-bold border text-base border-slate-500">{{$total_sale - $total_cost}}</td>
              </tr>
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
              @if($sales_info)
              <p class="p-1 text-xs text-gray-800">লেবার খরচ : {{$sales_info->labour_cost}}</p>
              <p class="p-1 text-xs text-gray-800">ট্রাক ভাড়া : {{$sales_info->truck_cost}}</p>
              <p class="p-1 text-xs text-gray-800">ভ্যান ভাড়া : {{$sales_info->van_cost}}</p>
              <p class="p-1 text-xs text-gray-800">অন্যান্য খরচ : {{$sales_info->other_cost}}</p>
              <p class="p-1 text-xs text-gray-800">তহরি : {{$sales_info->tohori_cost}}</p>
              <p class="p-1 text-xs text-gray-800">মোট খরচ : {{$total_cost}}</p>
              <p class="p-1 text-xs text-gray-800">নগদ পাওনা : {{$total_sale - $total_cost}}</p>
              <p class="p-1 text-xs text-gray-800">সর্বমোট বিক্রয় : {{$total_sale}}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

  
    <div class="w-32 my-8 mx-auto">
      <a href="{{url('arod_chotha_entry')}}/{{$purchase->id}}" onclick="window.open(this.href, 'আড়ত চৌথা',
'left=(screen.width - 800) / 2,top=(screen.width - 700) / 2,width=800,height=700,toolbar=1,resizable=0'); return false;" class="bg-blue-700 text-white text-xl px-4 py-2 rounded-md hover:bg-blue-600">চৌথা ইডিট</a>
    </div>
    
  </div>

  @else
  <h1>no record found</h1>
  @endif
