@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">স্টক রিপোর্ট</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                    <th scope="col" class="px-2 py-3">
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ইনভয়েস
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ধরণ
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মহাজনের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        পন্যের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        সাইজ
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মার্কা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        গ্রহণ সংখ্যা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মজুদ সংখ্যা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        বিক্রি সংখ্যা
                    </th>

                </tr>
            </thead>
            <tbody id="table_body">  
                
                @if($stock)
                @php
                $total_stock_qty = 0;
                $count = 1;
                @endphp

                @foreach($stock as $p)
                <tr class="border border-collapse">
                    <td class="px-2 py-3">{{$count++}}</td>
                    <td class="px-2 py-3 font-bold text-blue-700"><a href="{{route('ponno_purchase_report.memo',$p->ponno_purchase_entry->id)}}" class="url" onclick="return false;">{{$p->purchase_id}}</a></td>
                    <td class="px-2 py-3">@if($p->ponno_purchase_entry->purchase_type == 1) নিজ খরিদ @elseif($p->ponno_purchase_entry->purchase_type == 2) কমিশন @endif</td>
                    <td class="px-2 py-3">@if($p->ponno_purchase_entry->purchase_type == 1) AB মার্কা @else {{$p->ponno_purchase_entry->mohajon_setup->name}} @endif</td>
                    <td class="px-2 py-3">{{$p->ponno_purchase_entry->ponno_setup->ponno_name}}</td>
                    <td class="px-2 py-3">{{$p->ponno_purchase_entry->ponno_size_setup->ponno_size}}</td>
                    <td class="px-2 py-3">{{$p->ponno_purchase_entry->ponno_marka_setup->ponno_marka}}</td>
                    <td class="px-2 py-3">{{$p->ponno_purchase_entry->quantity}}</td>
                    <td class="px-2 py-3">{{$p->quantity}}</td>
                    <td class="px-2 py-3">{{$p->ponno_purchase_entry->quantity - $p->quantity}}</td>
                </tr>
                @php
                $total_stock_qty += $p->quantity;
                @endphp
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="8" class="px-2 py-3 text-sm font-bold text-red-600 text-center">মোট</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600">{{$total_stock_qty}}</td>
                </tr>
                @endif
            </tbody>
         
        </table>
    </div>


    <style>

        @page { 
            size:210mm 297mm; 
            margin: 0;
        }
    </style>
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