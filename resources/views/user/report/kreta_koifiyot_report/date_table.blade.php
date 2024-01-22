@extends('user.layout.report_layout')
@section('report_body')

<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ক্রেতার কৈফিয়ত রিপোর্ট</p>
        <div class="grid grid-cols-2 mt-2 text-center px-4">
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার নাম : {{$kreta_setup->name}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার ঠিকানা : {{$kreta_setup->address}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার ঠিকানা : {{$kreta_setup->area}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">ক্রেতার মোবাইল : {{$kreta_setup->mobile}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">তারিখ শুরু : {{$request->date_from}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">তারিখ শেষ : {{$request->date_to}}</h1>
            </div>
        </div>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                    <th scope="col" class="px-2 py-3">
                        তারিখ
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ইনভয়েস/আইডি
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মারফত
                    </th>
                    <th scope="col" class="px-2 py-3">
                        টাকা
                    </th>

                </tr>
            </thead>
            <tbody id="table_body">
                @php
                use Illuminate\Support\Carbon;
                @endphp
                
                @if($kreta_koifiyot)

                @php
                $total = 0;
                @endphp

                @if($total_amount)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="6" class="px-2 py-3 text-right">সাবেক :</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600 ">{{$total += $total_amount}}</td>
                </tr>
                @endif

                @foreach($kreta_koifiyot as $v)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td class="px-2 py-3">{{ Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y')  }}</td>
                    <td class="px-2 py-3">{{ $v->id }}</td>
                    <td class="px-2 py-3">{{ $v->marfot }}</td>
                    <td class="px-2 py-3">{{ $v->taka }}</td>
                </tr>

                    @php
                    $total += $v->taka;
                    @endphp

                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="3" class="px-2 py-3 text-sm font-bold text-red-600 text-center">মোট</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600">{{ $v->total }}</td>
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
 

@endsection