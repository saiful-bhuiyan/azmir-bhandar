@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ক্রেতা লেজার</p>
        <div class="grid grid-cols-2 mt-2 text-center px-4">
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার নাম : {{$kreta->name}}</h1>
            </div>
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার ঠিকানা : {{$kreta->address}}</h1>
            </div>
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার এরিয়া : {{$kreta->area}}</h1>
            </div>
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার মোবাইল : {{$kreta->mobile}}</h1>
            </div>
        </div>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                    <th scope="col" class="px-4 py-3">
                        তারিখ
                    </th>
                    <th scope="col" class="px-4 py-3">
                        ইনভয়েস
                    </th>
                    <th scope="col" class="px-4 py-3">
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-4 py-3">
                        মারফত
                    </th>
                    <th scope="col" class="px-4 py-3">
                        জমা
                    </th>
                    <th scope="col" class="px-4 py-3">
                        খরচ
                    </th>
                    <th scope="col" class="px-4 py-3">
                        মোট টাকা
                    </th>

                </tr>
            </thead>
            <tbody id="table_body">
                @php
                $total = 0;
                $total_joma = 0;
                $total_khoroc = 0;
                @endphp

                @if($kreta)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="6" class="px-4 py-3 text-right">সাবেক পাওনা :</td>
                    <td class="px-4 py-3 text-sm font-bold text-red-600 ">{{$total += number_format($kreta->old_amount,2)}}</td>
                </tr>
                @endif

                @if($record)
                @foreach($record as $data)
                @php
                if($data['table'] == 1)
                {
                $total_khoroc += $data['khoroc'];
                }
                else
                {
                $total_joma += $data['joma'];
                }

                @endphp
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td class="px-4 py-3">{{ $data['entry_date'] }}</td>
                    @if($data['table'] == 1)
                    <td class="px-4 py-3 font-bold text-blue-700 "><a href="{{route('ponno_sales_report.memo',$data['id'])}}" class="url" onclick="return false;">{{ $data['id'] }}</a></td>
                    @else
                    <td class="px-4 py-3">{{ $data['id'] }}</td>
                    @endif
                    <td class="px-4 py-3">{{ $data['payment'] }}</td>
                    <td class="px-4 py-3">{{ $data['marfot'] }}</td>
                    <td class="px-4 py-3">{{ $data['joma'] }}</td>
                    <td class="px-4 py-3">{{ $data['khoroc'] }}</td>

                    @if($data['table'] != 1)
                    <td class="px-4 py-3">{{ $total -= $data['joma'] }}</td>
                    @else
                    <td class="px-4 py-3">{{ $total += $data['khoroc'] }}</td>
                    @endif
                </tr>

                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="4" class="px-4 py-3 text-sm font-bold text-red-600 text-center">মোট</td>
                    <td class="px-4 py-3 text-sm font-bold text-red-600">{{$total_joma}}</td>
                    <td class="px-4 py-3 text-sm font-bold text-red-600">{{$total_khoroc}}</td>
                    <td class="px-4 py-3 text-sm font-bold text-red-600"></td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>


    <style>
        tr:nth-last-child(2) td:last-child {
            color: orangered;
            font-weight: bold;
            font-size: 1rem;
        }
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
                'resizable=yes, width=' + '400' +
                ', height=' + '700' + ', top=' +
                top + ', left=' + left);
        })
    </script>

@endsection