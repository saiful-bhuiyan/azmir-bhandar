@extends('user.layout.report_layout')
@section('report_body')

<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
        <span class="p-1 text-white bg-blue-600">পণ্য গ্রহণ</span>
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
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">পন্য গ্রহণ</p>

            <table id="table" class="w-full text-sm text-left text-gray-500 data-table">

                @if($purchase)
                @php
                $count = 1;
                @endphp
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            নং
                        </th>
                        <th scope="col" class="px-2 py-3">
                            ধরণ
                        </th>
                        <th scope="col" class="px-2 py-3">
                            এরিয়া
                        </th>
                        <th scope="col" class="px-2 py-3">
                            ঠিকানা
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
                            সংখ্যা
                        </th>
                        <th scope="col" class="px-2 py-3">
                            ওজন
                        </th>
                        @if($purchase_type == 1)
                        <th scope="col" class="px-2 py-3">
                            দর
                        </th>
                        @endif
                        <th scope="col" class="px-2 py-3">
                            মোট টাকা
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
                        <td class="px-2 py-3 font-bold text-blue-700"><a href="{{route('ponno_purchase_report.memo',$p->id)}}" class="url" onclick="return false;">{{$count++}}</a></td>
                        <td class="px-2 py-3">@if($p->purchase_type == 1) নিজ খরিদ @elseif($p->purchase_type == 2) কমিশন @endif</td>
                        <td class="px-2 py-3">{{$p->mohajon_setup->area}}</td>
                        <td class="px-2 py-3">{{$p->mohajon_setup->address}}</td>
                        <td class="px-2 py-3">{{$p->mohajon_setup->name}}</td>
                        <td class="px-2 py-3">{{$p->ponno_setup->ponno_name}}</td>
                        <td class="px-2 py-3">{{$p->ponno_size_setup->ponno_size}}</td>
                        <td class="px-2 py-3">{{$p->ponno_marka_setup->ponno_marka}}</td>
                        @if($purchase_type == 1)
                        @php
                        $total_taka = ($p->weight * $p->rate) + $p->labour_cost + $p->other_cost + $p->truck_cost + $p->van_cost +$p->tohori_cost;
                        @endphp
                        @else
                        @php
                        $total_taka = "-";
                        @endphp
                        @endif
                        <td class="px-2 py-3">{{$p->quantity}}</td>
                        <td class="px-2 py-3">{{$p->weight}}</td>
                        @if($purchase_type == 1)
                        <td class="px-2 py-3">{{$p->rate}}</td>
                        @endif
                        <td class="px-2 py-3">{{$total_taka}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border border-collapse">
                        <td colspan="12" class="px-2 py-3 text-center">রেকর্ড পাওয়া যায়নি</td>
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