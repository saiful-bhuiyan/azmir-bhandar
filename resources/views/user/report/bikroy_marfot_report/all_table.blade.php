@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

        <div class=" w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
            <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">বিক্রয় মারফত রিপোর্ট</p>

            <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
                @if($sales)
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="border border-collapse">
                        <th scope="col" class="px-6 py-3">
                            ইনভয়েস
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ধরণ
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ঠিকানা
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ক্রেতার নাম
                        </th>
                        <th scope="col" class="px-6 py-3">
                            মারফত
                        </th>
                        <th scope="col" class="px-6 py-3">
                            মোট টাকা
                        </th>
                        <th scope="col" class="px-6 py-3">
                            তারিখ
                        </th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    @php
                    $count = count($sales);
                    @endphp
                    @if($count > 0)
                    @foreach($sales as $s)
                    <tr class="border border-collapse">
                        <td class="px-6 py-3 font-bold text-blue-700"><a class="url" onclick="return false;" href="{{route('ponno_sales_report.memo',$s->id)}}">{{$s->id}}</a></td>
                        <td class="px-6 py-3">@if($s->sales_type == 1) নগদ @elseif($s->sales_type == 2) বাকি @endif</td>
                        @if($s->sales_type == 2)
                        <td class="px-6 py-3">{{$s->kreta_setup->address}}</td>
                        <td class="px-6 py-3">{{$s->kreta_setup->name}}</td>
                        @else
                        <td class="px-6 py-3">{{$s->cash_kreta_address}}</td>
                        <td class="px-6 py-3">{{$s->cash_kreta_name}}</td>
                        @endif
                        <td class="px-6 py-3">{{$s->bikroy_marfot_setup->marfot_name}}</td>
                        <td class="px-6 py-3">{{$s->total_taka}}</td>
                        <td class="px-6 py-3">{{$s->entry_date}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border border-collapse">
                        <td colspan="12" class="px-6 py-3 text-center">রেকর্ড পাওয়া যায়নি</td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
        @endif
        
@endsection