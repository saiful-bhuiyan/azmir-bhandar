@extends('user.layout.report_layout')
@section('report_body')

<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
        <span class="p-1 text-white bg-blue-600">বিক্রয় রিপোর্ট</span>
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
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">বিক্রয় রিপোর্ট</p>

            <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
                @if($sales)
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="border border-collapse">
                        <th scope="col" class="px-6 py-3">
                            ইনভয়েস
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ধরণ
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ঠিকানা
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ক্রেতার নাম
                        </th>
                        <th scope="col" class="px-6 py-3">
                            মারফত
                        </th>
                        <th scope="col" class="px-6 py-3">
                            মোট টাকা
                        </th>
                        <th scope="col" class="px-6 py-3">
                            তারিখ
                        </th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    @php
                    $count = count($sales);
                    @endphp
                    @if($count > 0)
                    @foreach($sales as $s)
                    <tr class="border border-collapse">
                        <td class="px-6 py-3 font-bold text-blue-700"><a class="url" onclick="return false;" href="{{route('ponno_sales_report.memo',$s->id)}}">{{$s->id}}</a></td>
                        <td class="px-6 py-3">@if($s->sales_type == 1) নগদ @elseif($s->sales_type == 2) বাকি @endif</td>
                        @if($s->sales_type == 2)
                        <td class="px-6 py-3">{{$s->kreta_setup->address}}</td>
                        <td class="px-6 py-3">{{$s->kreta_setup->name}}</td>
                        @else
                        <td class="px-6 py-3">{{$s->cash_kreta_address}}</td>
                        <td class="px-6 py-3">{{$s->cash_kreta_name}}</td>
                        @endif
                        <td class="px-6 py-3">{{$s->bikroy_marfot_setup->marfot_name}}</td>
                        @php

                        $total_taka = 0;
                        $entry = DB::table('ponno_sales_entries')->where('sales_invoice',$s->id)->get();
                        foreach($entry as $v)
                        {
                        $total_taka += ($v->sales_weight * $v->sales_rate) + $v->other + $v->labour + $v->kreta_commission - $s->discount;
                        }
                        @endphp
                        <td class="px-6 py-3">{{$total_taka}}</td>
                        <td class="px-6 py-3">{{$s->entry_date}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border border-collapse">
                        <td colspan="12" class="px-6 py-3 text-center">রেকর্ড পাওয়া যায়নি</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
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
        @endif
        
@endsection