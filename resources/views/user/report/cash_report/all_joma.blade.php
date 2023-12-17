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

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-2">
        <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-blue-800">ক্যাশ জমা রিপোর্ট</p>
        <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-blue-600">তারিখ : {{$search_date}}</p>
        <div class="w-full p-2">
        <hr>
        </div>
    </div>

    <!-- নগদ বিক্রয় টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">নগদ বিক্রয়</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse text-base">
                    <th>
                        নং
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ইনভয়েস
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ধরণ
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ঠিকানা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ক্রেতার নাম
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
                
                @if($cash_sales)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($cash_sales as $v)
                    @php
                    $total += $v->total_taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3 font-bold text-blue-700"><a class="url" onclick="return false;" href="{{route('ponno_sales_report.memo',$v->id)}}">{{$v->id}}</a></td>
                        <td class="px-2 py-3">@if($v->sales_type == 1) নগদ @elseif($v->sales_type == 2) বাকি @endif</td>
                        @if($v->sales_type == 2)
                        <td class="px-2 py-3">{{$v->kreta_setup->address}}</td>
                        <td class="px-2 py-3">{{$v->kreta_setup->name}}</td>
                        @else
                        <td class="px-2 py-3">{{$v->cash_kreta_address}}</td>
                        <td class="px-2 py-3">{{$v->cash_kreta_name}}</td>
                        @endif
                        <td class="px-2 py-3">{{$v->bikroy_marfot_setup->marfot_name}}</td>
                        <td class="px-2 py-3">{{$v->total_taka}}</td>
                    </tr>
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="6" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- ব্যাংক উত্তোলন টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ব্যাংক উত্তোলন</p>
        
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
                
                @if($bank_uttolon)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($bank_uttolon as $v)
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
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="9" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- ক্রেতা জমা টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ক্রেতার জমা</p>
        
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
                        ক্রেতার নাম
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
                

                @if($kreta_joma)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($kreta_joma as $v)
                    @php
                    $total += $v->taka;
                    @endphp
                    <tr class="border border-collapse odd:bg-white even:bg-gray-100 text-base">
                        <td class="px-2 py-3">{{ $count++ }}</td>
                        <td class="px-2 py-3">{{ $v->kreta_setup->area }}</td>
                        <td class="px-2 py-3">{{ $v->kreta_setup->address }}</td>
                        <td class="px-2 py-3">{{ $v->kreta_setup->name }}</td>
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
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- মহাজন ফেরত টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">মহাজন ফেরত</p>
        
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
                
                @if($mohajon_return)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($mohajon_return as $v)
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
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- আমানত জমা টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">আমানত জমা</p>
        
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
                

                @if($amanot_joma)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($amanot_joma as $v)
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
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="7" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- হাওলাত জমা টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">হাওলাত জমা</p>
        
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
                

                @if($hawlat_joma)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($hawlat_joma as $v)
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
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="7" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

    <!-- অন্যান্য জমা টেবিল -->

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">অন্যান্য জমা</p>
        
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
                

                @if($other_joma)
                    @php
                    $total = 0;
                    $count = 1;
                    @endphp
                @foreach($other_joma as $v)
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
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="6" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                    <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

    

@endsection