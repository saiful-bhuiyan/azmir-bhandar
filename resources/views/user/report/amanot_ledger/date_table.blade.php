@extends('user.layout.report_layout')
@section('report_body')

<div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
      @component('components.project_headline')
      @endcomponent
    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">আমানত লেজার</p>
        <div class="grid grid-cols-2 mt-2 text-center px-4">
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">আমানতের নাম : {{$amanot_setup->name}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">আমানতের ঠিকানা : {{$amanot_setup->address}}</h1>
            </div>
            <div class="col-span-1 py-1">
                <h1 class="text-base font-bold text-red-600">আমানতের মোবাইল : {{$amanot_setup->mobile}}</h1>
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
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মারফত
                    </th>
                    <th scope="col" class="px-2 py-3">
                        খরচ
                    </th>
                    <th scope="col" class="px-2 py-3">
                        জমা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মোট টাকা
                    </th>

                </tr>
            </thead>
            <tbody id="table_body">
                @php
                use Illuminate\Support\Carbon;
                @endphp
                
                @if($amanot)
                @php
                
                $total = 0;
                $total_joma = 0;
                $total_khoroc = 0;
                @endphp

                @if($total_amount)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="6" class="px-2 py-3 text-right">সাবেক :</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600 ">{{$total += $total_amount}}</td>
                </tr>
                @endif

                @foreach($amanot as $v)
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td class="px-2 py-3">{{ Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y')  }}</td>
                    <td class="px-2 py-3">{{ $v->id }}</td>
                    <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @elseif($v->payment_by == 2)
                         {{$v->bank_setup->bank_name}}/{{substr($v->bank_setup->account_no, -4)}} @endif</td>
                    <td class="px-2 py-3">{{ $v->marfot }}</td>
                    <td class="px-2 py-3">@if($v->type == 2){{ $v->taka }}@else - @endif</td>
                    <td class="px-2 py-3">@if($v->type == 1){{ $v->taka }}@else - @endif</td>
                    @if($v->type == 1)
                    <td class="px-2 py-3">{{ $total += $v->taka }}</td>
                    @else
                    <td class="px-2 py-3">{{ $total -= $v->taka }}</td>
                    @endif
                </tr>
                @if($v->type == 1)
                    @php
                    $total_joma += $v->taka;
                    @endphp
                @elseif($v->type == 2)
                    @php
                    $total_khoroc += $v->taka;
                    @endphp
                @endif

                

                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="4" class="px-2 py-3 text-sm font-bold text-red-600 text-center">মোট</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600">{{$total_khoroc}}</td>
                    <td class="px-2 py-3 text-sm font-bold text-red-600">{{$total_joma}}</td>
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
 

@endsection