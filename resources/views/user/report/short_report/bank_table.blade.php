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
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ব্যাংক সর্ট রিপোর্ট</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                    <th scope="col" class="px-2 py-3">
                        ক্রমিক
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংকের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        একাউন্টের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        একাউন্ট নাম্বার
                    </th>
                    <th scope="col" class="px-2 py-3">
                        শাখা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যালেন্স
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
                @php
                $total += $data['total_taka'];
                @endphp
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td class="px-2 py-3">{{ $count++ }}</td>
                    <td class="px-2 py-3">{{ $data['bank_name'] }}</td>
                    <td class="px-2 py-3">{{ $data['account_name'] }}</td>
                    <td class="px-2 py-3">{{ $data['account_no'] }}</td>
                    <td class="px-2 py-3">{{ $data['shakha'] }}</td>
                    <td class="px-2 py-3">{{ $data['total_taka'] }}</td>
                </tr>
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="5" class="px-2 py-3 text-lg font-bold text-red-600 text-center">মোট : </td>
                    <td class="px-2 py-3 text-lg font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

@endsection