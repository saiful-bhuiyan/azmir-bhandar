@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
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

        <div class=" w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">বিক্রয় মারফত রিপোর্ট</p>


            <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
                @if($sales)
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="border border-collapse">
                        <th scope="col" class="px-6 py-3">
                            ইনভয়েস
                        </th>
                        @if($sales_type == 3)
                        <th scope="col" class="px-6 py-3">
                            ধরণ
                        </th>
                        @endif
                        @if($sales_type == 2)
                        <th scope="col" class="px-6 py-3">
                            এরিয়া
                        </th>
                        @endif
                        <th scope="col" class="px-6 py-3">
                            ঠিকানা
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ক্রেতার নাম
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ডিসকাউন্ট
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
                    $countRow = count($sales);
                    @endphp
                    @if($countRow > 0)
                    @foreach($sales as $s)
                    <tr class="border border-collapse">
                        <td class="px-6 py-3 font-bold text-blue-700"><a href="{{route('ponno_sales_report.memo',$s->id)}}" class="url" onclick="return false;">{{$s->id}}</a></td>
                        @if($sales_type == 3)
                        <td class="px-6 py-3">{{$s->sales_type}}</td>
                        @endif
                        @if($sales_type == 2)
                        <td class="px-6 py-3">{{$s->kreta_setup->area}}</td>
                        <td class="px-6 py-3">{{$s->kreta_setup->address}}</td>
                        <td class="px-6 py-3">{{$s->kreta_setup->name}}</td>
                        @else
                        <td class="px-6 py-3">{{$s->cash_kreta_address}}</td>
                        <td class="px-6 py-3">{{$s->cash_kreta_name}}</td>
                        @endif
                        <td class="px-6 py-3">{{$s->discount}}</td>
                        <td class="px-6 py-3">{{$s->bikroy_marfot_setup->marfot_name}}</td>
                        <td class="px-6 py-3">{{$s->total_taka}}</td>
                        <td class="px-6 py-3">{{$s->entry_date}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border border-collapse">
                        <td colspan="12" class="px-6 py-3 text-center">রেকর্ড পাওয়া যায়নি</td>
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

                @endif

@endsection