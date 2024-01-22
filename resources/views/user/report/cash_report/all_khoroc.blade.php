@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-2">
        <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-blue-800">ক্যাশ খরচ রিপোর্ট</p>
        <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-blue-600">তারিখ : {{$search_date}}</p>
        <div class="w-full p-2">
        <hr>
        </div>
    </div>

    @php
    $total_amount = 0;
    @endphp

    <!-- ব্যাংক জমা টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ব্যাংক জমা</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-xs">
                    <th>
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংকের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        একাউন্টের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        একাউন্ট নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        শাখা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংক তথ্য
                    </th>
                    <th scope="col" class="px-2 py-3">
                        চেকের পাতার নাম্বার
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
                
                @if($bank_joma)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($bank_joma as $v)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-xs">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">{{ $v->bank_setup->bank_name }}</td>
                        <td class="px-2 py-3">{{ $v->bank_setup->account_name }}</td>
                        <td class="px-2 py-3">{{ $v->bank_setup->account_no }}</td>
                        <td class="px-2 py-3">{{ $v->bank_setup->shakha }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                @endforeach

                @foreach($kreta_joma as $v)
                    @if($v->payment_by == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-xs">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">ক্রেতা জমা</td>
                        <td class="px-2 py-3">{{ $v->kreta_setup->area }}</td>
                        <td class="px-2 py-3">{{ $v->kreta_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->kreta_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">-</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                @endforeach

                @foreach($mohajon_return as $v)
                    @if($v->payment_by == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-xs">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">মহাজন ফেরত</td>
                        <td class="px-2 py-3">{{ $v->mohajon_setup->area }}</td>
                        <td class="px-2 py-3">{{ $v->mohajon_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->mohajon_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">-</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                @endforeach

                @foreach($amanot as $v)
                    @if($v->type == 1)
                    @if($v->payment_by == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-xs">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td colspan="2" class="px-2 py-3">আমানত জমা</td>
                        <td class="px-2 py-3">{{ $v->amanot_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->amanot_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                    @endif
                @endforeach

                @foreach($hawlat as $v)
                    @if($v->type == 1)
                    @if($v->payment_by == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-xs">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td colspan="2" class="px-2 py-3">হাওলাত জমা</td>
                        <td class="px-2 py-3">{{ $v->hawlat_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->hawlat_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                    @endif
                @endforeach

                @foreach($other as $v)
                    @if($v->type == 1)
                    @if($v->payment_by == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-xs">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td colspan="2" class="px-2 py-3">অন্যান্য জমা</td>
                        <td colspan="2" class="px-2 py-3">{{ $v->other_joma_khoroc_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                    @endif
                @endforeach

                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="9" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @php
                $total_amount +=$total;
                @endphp
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- মহাজন পেমেন্ট টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">মহাজন পেমেন্ট</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-base">
                    <th>
                        নং
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
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংক তথ্য
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
                
                @if($mohajon_payment)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($mohajon_payment as $v)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">{{ $v->mohajon_setup->area }}</td>
                        <td class="px-2 py-3">{{ $v->mohajon_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->mohajon_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="7" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @php
                $total_amount +=$total;
                @endphp
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- আমানত খরচ টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">আমানত খরচ</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-base">
                    <th>
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ঠিকানা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        আমানতের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংক তথ্য
                    </th>
                    <th scope="col" class="px-2 py-3">
                        চেকের পাতার নাম্বার
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
                @if($amanot)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($amanot as $v)
                    @if($v->type == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">{{ $v->amanot_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->amanot_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="7" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @php
                $total_amount +=$total;
                @endphp
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- হাওলাত খরচ টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">হাওলাত খরচ</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-base">
                    <th>
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ঠিকানা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        হাওলাতকারীর নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংক তথ্য
                    </th>
                    <th scope="col" class="px-2 py-3">
                        চেকের পাতার নাম্বার
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
                

                @if($hawlat)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($hawlat as $v)
                    @if($v->type == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">{{ $v->hawlat_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->hawlat_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="7" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @php
                $total_amount +=$total;
                @endphp
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- অন্যান্য খরচ টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">অন্যান্য খরচ</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-base">
                    <th>
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        খাতের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        পেমেন্টের মাধ্যম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যাংক তথ্য
                    </th>
                    <th scope="col" class="px-2 py-3">
                        চেকের পাতার নাম্বার
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
                
                @if($other)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($other as $v)
                    @if($v->type == 2)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">{{ $v->other_joma_khoroc_setup->name }}</td>
                        <td class="px-2 py-3">@if($v->payment_by == 1) ক্যাশ @else ব্যাংক @endif</td>
                        <td class="px-2 py-3">@if($v->bank_setup_id == "" or null) - @else {{$v->bank_setup->bank_name .'/'.$v->bank_setup->account_name}} @endif</td>
                        <td class="px-2 py-3">@if($v->check_id == null or "") - @else {{$v->check_book_page_setup->page}} @endif</td>
                        <td class="px-2 py-3">{{ $v->marfot }}</td>
                        <td class="px-2 py-3">{{ $v->taka }}</td>
                    </tr>
                    @endif
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="6" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @php
                $total_amount +=$total;
                @endphp
                @endif
            </tbody>
            
        </table>
    </div>

     <!-- লেবার ও পন্য গ্রহণ টেবিল -->

     <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">বিক্রয় লেবার ও পন্য গ্রহণ খরচ</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-base">
                    <th>
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        খাতের নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        টাকা
                </th>

                </tr>
            </thead>
            <tbody id="table_body">
                <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                    <td class="px-2 py-3">{{ $count++ }}</td>
                    <td class="px-2 py-3">বিক্রয় লেবার</td>
                    <td class="px-2 py-3">{{ $total_labour ? $total_labour : 0 }}</td>
                </tr>
                <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                    <td class="px-2 py-3">{{ $count++ }}</td>
                    <td class="px-2 py-3">পন্য গ্রহণ খরচ</td>
                    <td class="px-2 py-3">{{ $total_purchase_cost ? $total_purchase_cost : 0 }}</td>
                </tr>
                   
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="2" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @php
                $total_amount += $total_labour ? $total_labour : 0;
                $total_amount += $total_purchase_cost ? $total_purchase_cost : 0;
                @endphp
            </tbody>
            
        </table>
    </div>

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
        <h1 class="text-2xl font-bold text-green-700">সর্বমোট খরচ : {{$total_amount}}</h1>
    </div>


    

@endsection