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

    <div class=" w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">আড়ৎ চৌথা রিপোর্ট</p>
        <div class="grid grid-cols-2 mt-2 text-center px-4">
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">তারিখ শুরু : {{$request->date_from}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">তারিখ শেষ : {{$request->date_to}}</h1>
            </div>
        </div>
        
        <table id="table" class="w-full text-sm text-center text-gray-500 data-table ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                     <th scope="col" class="px-4 py-3">
                        ক্রমিক
                    </th>
                    <th scope="col" class="px-4 py-3">
                        তারিখ
                    </th>
                    <th scope="col" class="px-4 py-3">
                        ইনভয়েস
                    </th>
                    <th scope="col" class="px-4 py-3">
                        এরিয়া
                    </th>
                    <th scope="col" class="px-4 py-3">
                        ঠিকানা
                    </th>
                    <th scope="col" class="px-4 py-3">
                        নাম 
                    </th>
                    <th scope="col" class="px-4 py-3">
                        পন্যের বিবরণ
                    </th>
                    <th scope="col" class="px-4 py-3">
                        মারফত
                    </th>
                    <th scope="col" class="px-4 py-3">
                        টাকা
                    </th>

                </tr>
            </thead>
            <tbody id="table_body">
                @php
                $total = 0;
                $count = 1;
                @endphp

                @if($record)
                @foreach($record as $data)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-center">
                    <td class="px-4 py-3">{{ $count++ }}</td>
                    <td class="px-4 py-3">{{ $data['entry_date'] }}</td>
                    <td class="px-4 py-3 font-bold text-blue-700 "><a href="{{route('arod_chotha.memo',$data['purchase_id'])}}" class="url" onclick="return false;">{{ $data['purchase_id'] }}</a></td>
                    <td class="px-4 py-3">{{ $data['area'] }}</td>
                    <td class="px-4 py-3">{{ $data['address'] }}</td>
                    <td class="px-4 py-3">{{ $data['name'] }}</td>
                    <td class="px-4 py-3">{{ $data['ponno_info'] }}</td>
                    <td class="px-4 py-3">{{ $data['marfot'] }}</td>
                    <td class="px-4 py-3">{{ $data['taka'] }}</td>
                </tr>
                @php
                $total += $data['taka'];
                @endphp
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="8" class="px-4 py-3 text-sm font-bold text-red-600 text-center">মোট</td>
                    <td class="px-4 py-3 text-sm font-bold text-red-600">{{$total}}</td>
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