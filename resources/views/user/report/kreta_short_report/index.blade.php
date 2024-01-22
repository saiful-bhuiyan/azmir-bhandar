@extends('user.layout.report_layout')
@section('report_body')

<div class=" mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white md:p-8">
    @component('components.project_headline')
    @endcomponent

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto  sm:rounded-lg bg-white mb-6">
    <p class="text-xl uppercase w-[90%] py-3 font-bold text-center pl-4 barlow text-green-800">ক্রেতার সর্ট রিপোর্ট</p>
        
        <table id="table" class="w-full text-sm text-left text-gray-500 data-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr class="border border-collapse">
                    <th scope="col" class="px-2 py-3">
                        ক্রমিক
                    </th>
                    <th scope="col" class="px-2 py-3">
                        এরিয়া
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ঠিকানা
                    </th>
                    <th scope="col" class="px-2 py-3">
                        নাম
                    </th>
                    <th scope="col" class="px-2 py-3">
                        মোবাইল
                    </th>
                    <th scope="col" class="px-2 py-3">
                        ব্যালেন্স
                    </th>

                </tr>
            </thead>
            <tbody id="table_body">
               
            </tbody>
            
        </table>
    </div>

    <script>
         $(document).ready(function () {
            $('.data-table').DataTable({
                processing: true,
                serverSide: false,
                "language": {
                "emptyTable": "ডাটা পাওয়া যায়নি",
                "search": "সার্চ করুন : ",
                "info":  "",
                "infoEmpty":   "",
                "infoFiltered":   "",
                "lengthMenu":     "_MENU_টি এন্ট্রি দেখুন",
                "loadingRecords": "লোড হচ্ছে...",
                "zeroRecords":    "রেকর্ড পাওয়া যায়নি",
                "paginate": {
                    "first":      "প্রথম",
                    "last":       "শেষ",
                    "next":       "পরবর্তি",
                    "previous":   "পুর্বে"
                },
                },
                ajax: "{{ route('kreta_short_report.index') }}",
                columns: [
                    { data: 'sl' },
                    { data: 'area' },
                    { data: 'address' },
                    { data: 'name' },
                    { data: 'mobile' },
                    { data: 'total_taka' },
                ]
            });
        });
    </script>

@endsection