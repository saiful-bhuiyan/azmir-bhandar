@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">অন্যান্য জমা খরচ সর্ট রিপোর্ট</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                    <th scope="col" class="px-2 py-3">
                        ক্রমিক
                    </th>
                    <th scope="col" class="px-2 py-3">
                        নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ঠিকানা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মোবাইল নাম্বার
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
                    <td class="px-2 py-3">{{ $data['name'] }}</td>
                    <td class="px-2 py-3">{{ $data['address'] }}</td>
                    <td class="px-2 py-3">{{ $data['mobile'] }}</td>
                    <td class="px-2 py-3">{{ $data['total_taka'] }}</td>
                </tr>
                @endforeach
                <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                    <td colspan="4" class="px-2 py-3 text-lg font-bold text-red-600 text-center">মোট : </td>
                    <td class="px-2 py-3 text-lg font-bold text-red-600 text-left">{{$total}}</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>

@endsection