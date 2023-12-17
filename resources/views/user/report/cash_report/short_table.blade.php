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

        <div class="w-full mx-auto p-4 relative overflow-x-auto sm:rounded-lg bg-white mb-6">
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ক্যাশ রিপোর্ট</p>
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-red-600">তারিখ : {{$search_date}}</p>
            <div class="flex">
                <div class="h-full w-full">
                    <table id="table1" class="w-full text-left text-gray-500 data-table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                                <td colspan="3" class="px-2 py-3 text-base text-center font-bold text-green-600"><a class="url" onclick="return false;" href="{{route('cash_report.all_joma',$search_date)}}">জমা</a></td>
                            </tr>
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                                <th scope="col" class="px-2 py-3 text-base">
                                    ক্রমিক
                                </th>
                                <th scope="col" class="px-2 py-3 text-base">
                                    জমা
                                </th>
                                <th scope="col" class="px-2 py-3 text-base">
                                    মোট টাকা
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                            @php
                            $total_joma = 0;
                            $total_khoroc = 0;
                            $total = 0;
                            @endphp

                            @foreach($joma as $v)
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                                <td class="px-2 py-3 text-base">{{ $v['sl'] }}</td>
                                <td class="px-2 py-3 text-base">{{ $v['reference'] }}</td>
                                <td class="px-2 py-3 text-base">{{ $v['total_taka'] ? $v['total_taka'] : 0 }}</td>
                            </tr>
                            @php
                            $total_joma += $v['total_taka'];
                            @endphp
                            @endforeach
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                                <td colspan="2" class="px-2 py-3 text-base font-bold text-green-600 text-center">মোট</td>
                                <td class="px-2 py-3 text-base font-bold text-green-600">{{$total_joma}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>


                <!-- খরচ টেবিল -->

                <div class="h-full w-full">
                    <table id="table2" class="w-full text-left text-gray-500 data-table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                                <td colspan="3" class="px-2 py-3 text-base text-center font-bold text-red-600"><a class="url" onclick="return false;" href="{{route('cash_report.all_khoroc',$search_date)}}">খরচ</a></td>
                            </tr>
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                                <th scope="col" class="px-2 py-3 text-base">
                                    ক্রমিক
                                </th>
                                <th scope="col" class="px-2 py-3 text-base">
                                    খরচ
                                </th>
                                <th scope="col" class="px-2 py-3 text-base">
                                    মোট টাকা
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                            @foreach($khoroc as $v)
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                                <td class="px-2 py-3 text-base">{{ $v['sl'] }}</td>
                                <td class="px-2 py-3 text-base">{{ $v['reference'] }}</td>
                                <td class="px-2 py-3 text-base">{{ $v['total_taka'] ? $v['total_taka'] : 0 }}</td>
                            </tr>
                            @php
                            $total_khoroc += $v['total_taka'];
                            @endphp
                            @endforeach
                            <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                                <td colspan="2" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট</td>
                                <td class="px-2 py-3 text-base font-bold text-red-600">{{$total_khoroc}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                @php
                $total = $total_joma - $total_khoroc;
                @endphp

            </div>
            <div class="w-full border border-collapse px-2 py-3">
                <p class="text-green-600 font-bold text-lg">মোট ক্যাশ : {{ $total }}</p>
            </div>
            <div class="w-full border border-collapse px-2 py-3">
                <form action="{{route('cash_report.transfer')}}" id="form_data" method="POST">
                @csrf
                <input type="text" name="amount" value="{{$total}}" hidden>
                <input type="text" name="date" value="{{$search_date}}" hidden>
                    <button type="submit" id="search" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ক্যাশ ট্রান্সফার</button>
                </form>
            </div>
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


@endsection