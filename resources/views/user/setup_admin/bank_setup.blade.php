@extends('user.layout.master')
@section('body')

<form action="{{ isset($data) ? route('bank_setup.update',$data->id) : '' }}" id="form_data" method="POST">
@csrf
@method('PUT')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ব্যাংক সেটাপ এডমিন</p>
          </div>
          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

              <div class="md:col-span-3">
                <label for="bank_name">ব্যাংকের নাম :</label>
                <input type="text" name="bank_name" id="bank_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->bank_name : '' }}" required/>
                @if($errors->has('bank_name'))
                <span class="text-sm text-red-600">{{ $errors->first('bank_name') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="account_name">একাউন্টের নাম :</label>
                <input type="text" name="account_name" id="account_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->account_name : '' }}" required/>
                @if($errors->has('account_name'))
                <span class="text-sm text-red-600">{{ $errors->first('account_name') }} </span>
                @endif
              </div>

              <div class="md:col-span-3">
                <label for="account_no">একাউন্ট নাম্বার :</label>
                <input type="text" name="account_no" id="account_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->account_no : '' }}" required/>
                @if($errors->has('account_no'))
                <span class="text-sm text-red-600">{{ $errors->first('account_no') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="shakha">শাখা :</label>
                <input type="text" name="shakha" id="shakha" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->shakha : '' }}" required/>
                @if($errors->has('shakha'))
                <span class="text-sm text-red-600">{{ $errors->first('shakha') }} </span>
                @endif
              </div>
      
              <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">আপডেট</button>
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
                  ব্যাংকের নাম
                </th>
                <th scope="col" class="px-6 py-3">
                  একাউন্টের নাম
                </th>
                <th scope="col" class="px-6 py-3">
                   একাউন্ট নাম্বার
                </th>
                <th scope="col" class="px-6 py-3">
                   শাখা
                </th>
                <th scope="col" class="px-6 py-3">
                   স্টেটাস
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
            ajax: "{{ route('bank_setup.admin') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account_no', name: 'account_no'},
                {data: 'shakha', name: 'shakha'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
            
            ]
        });

        });
    }

    loadCurrentData();

    function bankSetupStatusChange(id)
    {
      if(id > 0)
      {
        var message =@json(__ ('স্ট্যাটাস পরিবর্তন হয়েছে'));
        var  message_type = @json(__ ('সফল'));

        $.ajax({
          header : {
            'X-CSRF-TOKEN' : '{{ csrf_token() }}'
          },

          url : '{{url('bankSetupStatusChange')}}/'+id,
          type : 'GET',
          success:function(data)
          {
            toastr.success(message, message_type);
          }
        })
      }
    }


    $('#save').on('click',function(e){

      $('#save').text('অপেক্ষা করুন ...');

    });
    
  </script>
@endsection