@extends('user.layout.report_layout')
@section('report_body')

<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
        
    @component('components.project_headline')
    @endcomponent

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
                $count = 1;
                $all_total_commission = 0;
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
                            মহাজন কমিশন
                        </th>
                        <th scope="col" class="px-2 py-3">
                            ক্রেতা কমিশন
                        </th>
                        <th scope="col" class="px-2 py-3">
                            মোট কমিশন
                        </th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    @php
                    $countRow = count($purchase);
                    @endphp
                    @if($countRow > 0)
                    @foreach($purchase as $p)
                    <tr class="border border-collapse">
                        <td class="px-2 py-3">{{$count++}}</td>
                        <td class="px-2 py-3 font-bold text-blue-700"><a href="{{route('ponno_purchase_report.memo',$p->id)}}" class="url" onclick="return false;">{{$p->id}}</a></td>
                        <td class="px-2 py-3">{{$p->gari_no}}</td>
                        <td class="px-2 py-3">{{$p->ponno_setup->ponno_name}}</td>
                        <td class="px-2 py-3">{{$p->ponno_marka_setup->ponno_marka}}</td>
                        <td class="px-2 py-3">{{$p->ponno_size_setup->ponno_size}}</td>
                        <td class="px-2 py-3">{{$p->quantity}}</td>
                        @php
                        $sales = ponno_sales_entry::where('purchase_id',$p->id)->get(); 
                        $total_commission = 0;
                        $mohajon_commission = $p->mohajon_commission;
                        $kreta_commission = 0;
                        foreach($sales as $s){
                            $kreta_commission += $s->kreta_commission;
                        }
                        $total_commission += $mohajon_commission;
                        $total_commission += $kreta_commission;
                        $all_total_commission += $total_commission;
                        @endphp
                        <td class="px-2 py-3">{{ number_format($mohajon_commission,2) }}</td>
                        <td class="px-2 py-3">{{ number_format($kreta_commission,2) }}</td>
                        <td class="px-2 py-3">{{ number_format($total_commission,2) }}</td>
                    </tr>
                    @endforeach
                    
                    <tr class="border border-collapse">
                        <td colspan="9" class="px-2 py-3 font-bold text-red-700 text-lg text-end">মোট : </td>
                        <td class="px-2 py-3 font-bold text-red-700 text-lg">{{ number_format($all_total_commission,2)}}</td>
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