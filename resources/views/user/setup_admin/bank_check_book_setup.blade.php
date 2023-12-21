@extends('user.layout.master')
@section('body')

<form action="{{ isset($data) ? route('bank_check_book_setup.update',$data->id) : '' }}" id="form_data" method="POST">
@csrf
@method('PUT')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ব্যাংক চেক বই সেটাপ</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

              <div class="md:col-span-2">
                <label for="shakha">শাখা :</label>
                <select name="shakha" id="shakha" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getBankNameByShakha();" required>
                    <option value="" selected>সিলেক্ট</option>
                    
                </select>
                @if($errors->has('shakha'))
                <span class="text-sm text-red-600">{{ $errors->first('shakha') }} </span>
                @endif
              </div>
              
              <div class="md:col-span-3">
                <label for="bank_name">ব্যাংকের নাম :</label>
                <select name="bank_name" id="bank_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getAccNameByBankName();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('bank_name'))
                <span class="text-sm text-red-600">{{ $errors->first('bank_name') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="account_name">একাউন্টের নাম :</label>
                <select name="account_name" id="account_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getAccNoByAccName();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('account_name'))
                <span class="text-sm text-red-600">{{ $errors->first('account_name') }} </span>
                @endif
              </div>

              <div class="md:col-span-3">
                <label for="account_no">একাউন্ট নাম্বার :</label>
                <select name="account_no" id="account_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('account_no'))
                <span class="text-sm text-red-600">{{ $errors->first('account_no') }} </span>
                @endif
              </div>

              <div class="md:col-span-5">
                
                <label>চেকের পাতার নাম্বার :</label>
                <input type="text" name="page_from" id="page_from" class="h-10 border mt-1 rounded px-4 w-1/3 bg-gray-50 page" value="" required/>
                
                <label> হইতে </label>
                <input type="text" name="page_to" id="page_to" class="h-10 border mt-1 rounded px-4 w-1/3 bg-gray-50 page" value="" required/>

              </div>

              <div class="md:col-span-2">
                <label for="total_page">মোট চেকের পাতা :</label>
                <input type="text" name="total_page" id="total_page" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                @if($errors->has('total_page'))
                <span class="text-sm text-red-600">{{ $errors->first('total_page') }} </span>
                @endif
              </div>
      
              <!-- <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সেভ</button>
                </div>
              </div> -->

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
                মোট পাতা
            </th>
            <th scope="col" class="px-6 py-3">
                স্টেটাস
            </th>
            <th scope="col" class="px-6 py-3">
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
            ajax: "{{ route('bank_check_book_setup.admin') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account_no', name: 'account_no'},
                {data: 'shakha', name: 'shakha'},
                {data: 'total_page', name: 'total_page'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
            
            ]
        });

        });
    }

    loadCurrentData();

    function bankCheckBookSetupStatusChange(id)
    {
      if(id > 0)
      {
        var message =@json(__ ('স্ট্যাটাস পরিবর্তন হয়েছে'));
        var  message_type = @json(__ ('সফল'));

        $.ajax({
          header : {
            'X-CSRF-TOKEN' : '{{ csrf_token() }}'
          },

          url : '{{url('bankCheckBookSetupStatusChange')}}/'+id,
          type : 'GET',
          success:function(data)
          {
            toastr.success(message, message_type);
          }
        })
      }
    }

    function getBankNameByShakha()
    {
        var shakha = $('#shakha').val();

        if(shakha != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url('getBankNameByShakha')}}',
                data : {
                    shakha : shakha,
                },
                success:function(response)
                {
                    $('#bank_name').html(response);
                }

            });
        }
    }

    function getAccNameByBankName()
    {
        var bank_name = $('#bank_name').val();

        if(bank_name != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url('getAccNameByBankName')}}',
                data : {
                    bank_name : bank_name,
                },
                success:function(response)
                {
                    $('#account_name').html(response);
                }

            });
        }
    }

    function getAccNoByAccName()
    {
        var account_name = $('#account_name').val();

        if(account_name != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url('getAccNoByAccName')}}',
                data : {
                    account_name : account_name,
                },
                success:function(response)
                {
                    $('#account_no').html(response);
                }

            });
        }
    }

    $('.page').keyup(function(){
        var page_from = $('#page_from').val();
        var page_to = $('#page_to').val();

        var total  = parseFloat(page_to) - parseFloat(page_from);

        $('#total_page').val(total+1);
    })


    $('#save').on('submit',function(e){

      $('#save').text('অপেক্ষা করুন ...');

    });
    
  </script>
@endsection