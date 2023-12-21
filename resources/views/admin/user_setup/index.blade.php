@extends('user.layout.master')
@section('body')

<form action="{{ route('user_setup.store') }}" id="form_data" method="POST">
@csrf

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ইউজার সেটাপ</p>
          </div>

          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

              <div class="md:col-span-2">
                <label for="name">নাম :</label>
                <input type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                @if($errors->has('name'))
                <span class="text-sm text-red-600">{{ $errors->first('name') }} </span>
                @endif
              </div>

              <div class="md:col-span-3">
                <label for="email">ইমেইল : </label>
                <input type="email" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=""  required/>
                @if($errors->has('email'))
                <span class="text-sm text-red-600">{{ $errors->first('email') }} </span>
                @endif
              </div>

              <div class="md:col-span-3">
                <label for="password">পাসওয়ার্ড :</label>
                <input type="password" name="password" id="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" />
                @if($errors->has('password'))
                <span class="text-sm text-red-600">{{ $errors->first('password') }} </span>
                @endif
              </div>
      
              <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সেভ</button>
                </div>
              </div>

            </div>
          </div>
       
        </div>
      </div>
    </div>
  </div>
</div>

</form>


<div class="mb-4">

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

<div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto shadow-lg sm:rounded-lg bg-white mb-6">
  <p class="text-lg text-gray-700 uppercase px-6 py-3 font-bold text-center barlow">এড কার্ট</p>
  <table id="" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 data-table">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th>
                    নং
                </th>
                <th scope="col" class="px-6 py-3">
                    নাম
                </th>
                <th scope="col" class="px-6 py-3">
                    ইমেইল
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    একশন
                </th>
            </tr>
        </thead>
        <tbody id="table_body">
           
        </tbody>
    </table>

</div>
</div>


<script type="text/javascript">
    function loadCurrentData()
    {
      $(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
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
            ajax: "{{ route('user_setup.index') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
            
            ]
        });

        });
    }

    loadCurrentData();

    $('#save').on('click',function(e){

      $('#save').text('অপেক্ষা করুন ...');

    });
    
  </script>
@endsection