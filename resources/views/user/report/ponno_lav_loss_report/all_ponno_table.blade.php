@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
        
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

        <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">{{$title}}</p>
            <div class="grid grid-cols-2 mt-2 text-center px-4">
                @if(isset($mohajon_setup))
                <div class="col-span-1 py-1">
                    <h1 class="text-base font-bold text-red-600">মহাজনের নাম : {{$mohajon_setup->name}}</h1>
                </div>
                <div class="col-span-1 py-1">
                    <h1 class="text-base font-bold text-red-600">ঠিকানা : {{$mohajon_setup->address}}</h1>
                </div>
                <div class="col-span-1 py-1">
                    <h1 class="text-base font-bold text-red-600">এরিয়া : {{$mohajon_setup->area}}</h1>
                </div>
                @endif
                <div class="col-span-1 py-1">
                    <h1 class="text-base font-bold text-red-600">তারিখ শুরু : {{$request->date_from}}</h1>
                </div>
                <div class="col-span-1 py-1">
                    <h1 class="text-base font-bold text-red-600">তারিখ শেষ : {{$request->date_to}}</h1>
                </div>
                </div>
            </div>
            <table id="table" class="w-full text-sm text-left text-gray-500 data-table">

                
                @php
                use App\Models\ponno_sales_entry;
                use App\Models\arod_chotha_entry;
                use App\Models\arod_chotha_info;
                use App\Models\ponno_purchase_cost_entry;
                $count = 1;
                $total_purchase = 0;
                $total_lav = 0;
                $total_loss = 0;
                @endphp
       
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            ক্রমিক
                        </th>
                        <th scope="col" class="px-2 py-3">
                            গ্রহণ ইনভোয়েস
                        </th>
                        <th scope="col" class="px-2 py-3">
                            ধরণ
                        </th>
                        <th scope="col" class="px-2 py-3">
                            গাড়ি নং
                        </th>
                        <th scope="col" class="px-2 py-3">
                            পন্যের নাম
                        </th>
                        <th scope="col" class="px-2 py-3">
                            মার্কা
                        </th>
                        <th scope="col" class="px-2 py-3">
                            সাইজ
                        </th>
                        <th scope="col" class="px-2 py-3">
                            গ্রহণ সংখ্যা
                        </th>
                        <th scope="col" class="px-2 py-3">
                            মোট ক্রয়
                        </th>
                        <th scope="col" class="px-2 py-3">
                            বিক্রয় সংখ্যা
                        </th>
                        <th scope="col" class="px-2 py-3">
                            মোট বিক্রয়
                        </th>
                        <th scope="col" class="px-2 py-3">
                            লাভ
                        </th>
                        <th scope="col" class="px-2 py-3">
                            লস
                        </th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    @php
                    $countRow = count($purchase);
                    @endphp
                    @if($countRow > 0)
                    @foreach($purchase as $p)
                    @php
                    $arod_chotha_info_count = arod_chotha_info::where('purchase_id',$p->id)->first(); 
                    $arod_chotha_qty = arod_chotha_entry::where('purchase_id',$p->id)->sum('sales_qty'); 
                    @endphp
                    @if($p->purchase_type == 1 || $arod_chotha_info_count && $arod_chotha_qty == $p->quantity)
                        @if($p->purchase_type == 1 && $p->weight != 0 || $p->rate != 0)
                    <tr class="border border-collapse even:bg-gray-100 odd:bg-white">
                        <td class="px-2 py-3">{{$count++}}</td>
                        @if($p->purchase_type == 1)
                        <td class="px-2 py-3 font-bold text-blue-700"><a href="{{route('ponno_purchase_report.memo',$p->id)}}" class="url" onclick="return false;">{{$p->id}}</a></td>
                        @else
                        <td class="px-2 py-3 font-bold text-blue-700"><a href="{{route('arod_chotha.memo',$p->id)}}" class="url" onclick="return false;">{{$p->id}}</a></td>
                        @endif
                        <td class="px-2 py-3">@if($p->purchase_type == 1) নিজ খরিদ (AB মার্কা) @elseif($p->purchase_type == 2) কমিশন/{{$p->mohajon_setup->name}} @endif</td>
                        <td class="px-2 py-3">{{$p->gari_no}}</td>
                        <td class="px-2 py-3">{{$p->ponno_setup->ponno_name}}</td>
                        <td class="px-2 py-3">{{$p->ponno_marka_setup->ponno_marka}}</td>
                        <td class="px-2 py-3">{{$p->ponno_size_setup->ponno_size}}</td>
                        <td class="px-2 py-3">{{$p->quantity}}</td>
                        
                        @php
                        $total_amount = 0;
                        $purchase_amount = 0;
                        $cost_amount = 0;
                        $total_mohajon_commission = 0;
                        $sales_qty = 0;
                        $sales_amount = 0;
                        if($p->purchase_type == 1)
                        {
                            $purchase_amount += $p->weight * $p->rate;
                            $purchase_amount += $p->labour_cost;
                            $purchase_amount += $p->other_cost;
                            $purchase_amount += $p->truck_cost;
                            $purchase_amount += $p->van_cost;
                            $purchase_amount += $p->tohori_cost;
                            
                            $sales = ponno_sales_entry::where('purchase_id',$p->id)->get(); 
                            foreach($sales as $s)
                            {
                                $sales_qty += $s->sales_qty;
                                $sales_amount += $s->sales_weight * $s->sales_rate;
                                $purchase_amount += $p->mohajon_commission * $s->sales_weight;
                            }
                        }
                        else if($p->purchase_type == 2)
                        {
                            $arod_chotha_info = arod_chotha_info::where('purchase_id',$p->id)->first(); 
                            $chotha_count = arod_chotha_entry::where('purchase_id',$p->id)->sum('sales_qty'); 
                            $arod_chotha = arod_chotha_entry::where('purchase_id',$p->id)->get(); 
                            if($arod_chotha_info && $chotha_count == $p->quantity)
                            {
                                foreach($arod_chotha as $a)
                                {
                                    $purchase_amount += $a->sales_weight * $a->sales_rate;
                                    $total_mohajon_commission += $p->mohajon_commission * $a->sales_weight;
                                }
                                $cost_amount += $arod_chotha_info->labour_cost;
                                $cost_amount += $arod_chotha_info->other_cost;
                                $cost_amount += $arod_chotha_info->truck_cost;
                                $cost_amount += $arod_chotha_info->van_cost;
                                $cost_amount += $arod_chotha_info->tohori_cost;
                                $cost_amount += $total_mohajon_commission;
                                
                                $sales = ponno_sales_entry::where('purchase_id',$p->id)->get(); 
                                $old_mohajon_commission = 0;
                                foreach($sales as $s)
                                {
                                    $sales_qty += $s->sales_qty;
                                    $sales_amount += $s->sales_weight * $s->sales_rate;
                                    $old_mohajon_commission += $p->mohajon_commission * $s->sales_weight;
                                }
                                

                                $ponno_cost = ponno_purchase_cost_entry::where('purchase_id',$p->id)->get();

                                $labour_cost = 0;
                                $other_cost = 0;
                                $truck_cost = 0;
                                $van_cost = 0;
                                $tohori_cost = 0;

                                foreach($ponno_cost as $v)
                                {
                                    if($v->cost_name == 1){
                                        $labour_cost += $v->taka;
                                    }else if($v->cost_name == 2){
                                        $other_cost += $v->taka;
                                    }else if($v->cost_name == 3){
                                        $truck_cost += $v->taka;
                                    }else if($v->cost_name == 4){
                                        $van_cost += $v->taka;
                                    }else if($v->cost_name == 5){
                                        $tohori_cost += $v->taka;
                                    }
                                }

                                $cost_amount -= $p->labour_cost + $labour_cost;
                                $cost_amount -= $p->other_cost + $other_cost;
                                $cost_amount -= $p->truck_cost + $truck_cost;
                                $cost_amount -= $p->van_cost + $van_cost;
                                $cost_amount -= $p->tohori_cost + $tohori_cost;
                                $cost_amount -= $old_mohajon_commission;
                            }
                            
                        }
                        
                        $total_amount = ($sales_amount + $cost_amount) - $purchase_amount;

                        @endphp
                        <td class="px-2 py-3">{{ intval($purchase_amount) }}</td>
                        <td class="px-2 py-3">{{ $sales_qty }}</td>
                        <td class="px-2 py-3">{{ intval($sales_amount) }}</td>
                        @if($total_amount >= 0)
                        @php
                        $total_lav += $total_amount ;
                        @endphp
                        <td class="px-2 py-3 font-bold text-sm text-black">{{ intval($total_amount) }}</td>
                        <td class="px-2 py-3 font-bold text-sm text-black">-</td>
                        @else
                        @php
                        $total_loss += $total_amount;
                        @endphp
                        <td class="px-2 py-3 font-bold text-sm text-black">-</td>
                        <td class="px-2 py-3 font-bold text-sm text-black">{{ intval($total_amount) }}</td>
                        @endif
                        @endif
                    </tr>
                    @endif
                    @endforeach
                    
                    <tr class="border border-collapse even:bg-gray-100 odd:bg-white">
                        @if($total_lav >= 0)
                        <td colspan="13" class="px-2 py-3 text-center font-bold text-base text-green-600">আপনার মোট লাভ হয়েছে : {{$total_lav}} টাকা</td>
                        @else
                        <td colspan="13" class="px-2 py-3 text-center font-bold text-base text-red-600">আপনার মোট লস হয়েছে : {{$total_loss}} টাকা</td>
                        @endif
                    </tr>

                    @else
                    <tr class="border border-collapse text-center">
                        <td colspan="12" class="px-2 py-3 ">রেকর্ড পাওয়া যায়নি</td>
                    </tr>
                    @endif
                </tbody>

                <script>
                    $('.url').click(function() {
                        var left = (screen.width - 800) / 2;
                        var top = (screen.height - 700) / 4;

                        var url = $(this).attr('href');

                        var myWindow = window.open(url, url,
                            'resizable=yes, width=' + '800' +
                            ', height=' + '700' + ', top=' +
                            top + ', left=' + left);
                    })
                </script>

               

@endsection