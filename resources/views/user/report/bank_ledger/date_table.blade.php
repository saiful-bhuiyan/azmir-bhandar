@extends('user.layout.report_layout')
@section('report_body')

<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
      <span class="p-1 text-white bg-blue-600">ব্যাংক লেজার</span>
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
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ব্যাংক লেজার</p>
        <div class="grid grid-cols-2 mt-2 text-center px-4">
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">ব্যাংকের নাম : {{$bank_setup->bank_name}}</h1>
            </div>
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">একাউন্টের নাম : {{$bank_setup->account_name}}</h1>
            </div>
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">একাউন্টের শাখা : {{$bank_setup->shakha}}</h1>
            </div>
            <div class="col-span-1">
                <h1 class="text-base font-bold text-red-600">একাউন্ট নাম্বার : {{$bank_setup->account_no}}</h1>
            </div>
        </div>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-center">
                    <th scope="col" class="px-2 py-3 w[5%]">
                        ক্রমিক
                    </th>
                    <th scope="col" class="px-2 py-3">
                        তারিখ
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ইনভয়েস
                    </th>
                    <th scope="col" class="px-2 py-3">
                        রেফারেন্স
                    </th>
                    <th scope="col" class="px-2 py-3">
                        চেকের পাতা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মারফত
                    </th>
                    <th scope="col" class="px-2 py-3">
                        জমা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        উত্তোলন
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যালেন্স
                    </th>

                </tr>
            </thead>
            <tbody id="table_body ">
                @php
                $count = 1;
                $total = 0;
                $total_joma = 0;
                $total_uttolon = 0;
                @endphp

                @if($old_amount)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                    <td colspan="8" class="px-2 py-3 text-right">সাবেক :</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600 ">{{$total += $old_amount}}</td>
                </tr>
                @endif


                @if($record)
                @foreach($record as $data)
                    @php
                    if($data['type'] == 1)
                    {
                    $total_joma += $data['joma'];
                    }
                    else if($data['type'] == 2)
                    {
                    $total_uttolon += $data['uttolon'];
                    }
                    @endphp
                <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                    <td class="px-2 py-3 w-[5%]">{{ $count++ }}</td>
                    <td class="px-2 py-3">{{ $data['entry_date'] }}</td>
                    <td class="px-2 py-3">{{ $data['id'] }}</td>
                    <td class="px-2 py-3">{{ $data['reference'] }}</td>
                    <td class="px-2 py-3">{{ $data['check_id'] }}</td>
                    <td class="px-2 py-3">{{ $data['marfot'] }}</td>
                    <td class="px-2 py-3">{{ $data['joma'] }}</td>
                    <td class="px-2 py-3">{{ $data['uttolon'] }}</td>
                    @if($data['type'] == 1)
                    <td class="px-2 py-3">{{ $total += $data['joma'] }}</td>
                    @else
                    <td class="px-2 py-3">{{ $total -= $data['uttolon'] }}</td>
                    @endif
                </tr>

                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                    <td colspan="6" class="px-2 py-3 text-sm font-bold text-red-600 text-center">মোট</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600">{{$total_joma}}</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600">{{$total_uttolon}}</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600"></td>
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
                'resizable=yes, width=' + '800' +
                ', height=' + '700' + ', top=' +
                top + ', left=' + left);
        })
    </script>

@endsection