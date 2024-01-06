@extends('user.layout.master')
@section('body')

<form action="{{route('kreta_joma_entry.store')}}" id="form_data" method="POST">
@csrf

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ক্রেতার জমা</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

              <div class="md:col-span-1">
                <label for="area">এরিয়া :</label>
                <select name="area" id="area" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getkretaAddressByArea();" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($kreta_setup)
                    @foreach($kreta_setup as $b)
                    <option value="{{$b->area}}">{{$b->area}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('area'))
                <span class="text-sm text-red-600">{{ $errors->first('area') }} </span>
                @endif
              </div>
              
              <div class="md:col-span-2">
                <label for="address">ঠিকানা :</label>
                <select name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getKretaNameByAddress();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('address'))
                <span class="text-sm text-red-600">{{ $errors->first('address') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="kreta_setup_id">ক্রেতার নাম :</label>
                <select name="kreta_setup_id" id="kreta_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getKretaOldAmount();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('kreta_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('kreta_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="current_amount">বর্তমান পাওনা :</label>
                <input type="text" name="current_amount" id="current_amount" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" readonly/>
              </div>

              <div class="md:col-span-2">
                <label for="marfot">মারফত :</label>
                <input type="text" name="marfot" id="marfot" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                @if($errors->has('marfot'))
                <span class="text-sm text-red-600">{{ $errors->first('marfot') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="taka">টাকা :</label>
                <input type="text" name="taka" id="taka" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                @if($errors->has('taka'))
                <span class="text-sm text-red-600">{{ $errors->first('taka') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="payment_by">পেমেন্টের মাধ্যম :</label>
                <select name="payment_by" id="payment_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getBankSetupInfo();" required>
                    <option value="1">ক্যাশ</option>
                    <option value="2">ব্যাংক</option>
                </select>
                @if($errors->has('payment_by'))
                <span class="text-sm text-red-600">{{ $errors->first('payment_by') }} </span>
                @endif
              </div>

              <div class="md:col-span-4" id="bank_div">
                <label for="bank_setup_id">ব্যাংক তথ্য :</label>
                <select name="bank_setup_id" id="bank_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('bank_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('bank_setup_id') }} </span>
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
                এরিয়া
            </th>
            <th scope="col" class="px-6 py-3">
                ঠিকানা
            </th>
            <th scope="col" class="px-6 py-3">
                ক্রেতার নাম
            </th>
            <th scope="col" class="px-6 py-3">
                পেমেন্টের মাধ্যম
            </th>
            <th scope="col" class="px-6 py-3">
                ব্যাংক তথ্য
            </th>
            <th scope="col" class="px-6 py-3">
                মারফত
            </th>
            <th scope="col" class="px-6 py-3">
                টাকা
            </th>
        </tr>
    </thead>
    <tbody id="table_body">
        
    </tbody>
    </table>

</div>

</div>


<script type="text/javascript">

    $('#bank_div').hide();
 
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
            ajax: "{{ route('kreta_joma_entry.index') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'area', name: 'area'},
                {data: 'address', name: 'address'},
                {data: 'name', name: 'name'},
                {data: 'payment_by', name: 'payment_by'},
                {data: 'bank_info', name: 'bank_info'},
                {data: 'marfot', name: 'marfot'},
                {data: 'taka', name: 'taka'},
            
            ]
        });

        });
    }

    loadCurrentData();

    function getkretaAddressByArea()
    {
        var area = $('#area').val();

        if(area != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getkretaAddressByArea")}}',
                data : {
                    area : area,
                },
                success:function(response)
                {
                    $('#address').html(response);
                }

            });
        }
    }

    function getKretaNameByAddress()
    {
        var address = $('#address').val();

        if(address != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getKretaNameByAddress")}}',
                data : {
                    address : address,
                },
                success:function(response)
                {
                    $('#kreta_setup_id').html(response);
                }

            });
        }
    }

    function getKretaOldAmount()
    {
        var kreta_setup_id = $('#kreta_setup_id').val();

        if(kreta_setup_id != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getKretaOldAmount")}}',
                data : {
                  kreta_setup_id : kreta_setup_id,
                },
                success:function(response)
                {
                    $('#current_amount').val(response);
                }

            });
        }
    }

    function getBankSetupInfo()
    {
        var payment_by = $('#payment_by').val();

        if(payment_by == "2")
        {
            $('#bank_div').show();

            $.ajax({
                type : 'POST',
                url : '{{url("getBankSetupInfo")}}',
                success:function(response)
                {
                    $('#bank_setup_id').html(response);
                }

            });
        }
        else
        {
            $('#bank_div').hide();
            $('#bank_setup_id').html('<option value="" selected>সিলেক্ট</option>');
        }
    }

    $('#save').on('submit',function(e){

      $('#save').text('অপেক্ষা করুন ...');

    });
    
  </script>
@endsection