@extends('user.layout.master')
@section('body')

<form action="{{ isset($data) ? route('bank_entry.update',$data->id) : '' }}" id="form_data" method="POST">
@csrf
@method('PUT')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ব্যাংক জমা/উত্তোলন</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

              <div class="md:col-span-1">
                <label for="type">ব্যাংক জমা/উত্তোলন :</label>
                <select name="type" id="type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    <option value="1" {{ isset($data) && $data->type == 1 ? 'selected' : '' }} >জমা</option>
                    <option value="2" {{ isset($data) && $data->type == 2 ? 'selected' : '' }} >উত্তোলন</option>
                </select>
                @if($errors->has('type'))
                <span class="text-sm text-red-600">{{ $errors->first('type') }} </span>
                @endif
              </div>

              <div class="md:col-span-3">
                <label for="bank_setup_id">ব্যাংক তথ্য :</label>
                <select name="bank_setup_id" id="bank_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($bank_setup)
                    @foreach($bank_setup as $v)
                    <option value="{{$v->id}}" {{ isset($data) && $data->bank_setup->id == $v->id ? 'selected' : '' }} >{{$v->shakha.' / '.$v->bank_name.' /'.$v->account_name.' /'.$v->account_no}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('bank_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('bank_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-2" id="check_div">
                <label for="check_id">চেক বই নাম্বার (প্রয়োজন হলে):</label>
                <select name="check_id" id="check_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    <option value="" selected>সিলেক্ট</option>
                    @if(isset($selected_check->id))
                    <option value="{{$selected_check->id}}" selected>{{$selected_check->page}}</option>
                    @endif
                    @if($check_book)
                    @foreach($check_book as $v)
                    <option value="{{$v->id}}">{{$v->page}}</option>
                    @endforeach
                    @endif
                </select>
              </div>

              <div class="md:col-span-2">
                <label for="marfot">মারফত :</label>
                <input type="text" name="marfot" id="marfot" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->marfot : '' }}" required/>
                @if($errors->has('marfot'))
                <span class="text-sm text-red-600">{{ $errors->first('marfot') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="taka">টাকা :</label>
                <input type="text" name="taka" id="taka" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->taka : '' }}" required/>
                @if($errors->has('taka'))
                <span class="text-sm text-red-600">{{ $errors->first('taka') }} </span>
                @endif
              </div> 

              <div class="md:col-span-2 ">
                <label for="entry_date">তারিখ :</label>
                <input type="text" name="entry_date" id="entry_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="{{ isset($data) ? date('d-m-Y',strtotime($data->entry_date)) : '' }}" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('entry_date'))
                <span class="text-sm text-red-600">{{ $errors->first('entry_date') }} </span>
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
                ধরণ
            </th>
            <th scope="col" class="px-6 py-3">
                ব্যাংক তথ্য
            </th>
            <th scope="col" class="px-6 py-3">
                চেকের পাতার নাম্বার
            </th>
            <th scope="col" class="px-6 py-3">
                মারফত
            </th>
            <th scope="col" class="px-6 py-3">
                টাকা
            </th>
            <th scope="col" class="px-6 py-3">
                তারিখ
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
            ajax: "{{ route('bank_entry.admin') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'type', name: 'type'},
                {data: 'bank_setup_id', name: 'bank_setup_id'},
                {data: 'check_id', name: 'check_id'},
                {data: 'marfot', name: 'marfot'},
                {data: 'taka', name: 'taka'},
                {data: 'entry_date', name: 'entry_date'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
            
            ]
        });

        });
    }

    loadCurrentData();

    function getCheckByBankId()
    {
        var bank_setup_id = $('#bank_setup_id').val();

        if(bank_setup_id != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getCheckByBankId")}}',
                data : {
                  bank_setup_id : bank_setup_id,
                },
                success:function(response)
                {
                    $('#check_id').html(response);
                }

            });
        }
    }

    $('#type').change(function(){
      var type = $('#type').val();
      if(type == 2)
      {
        $('#check_div').show();
        $('#check_id').val("");
      }
      else
      {
        $('#check_div').hide();
        $('#check_id').val("");
      }
        
    });

    $( function() {
      $( "#entry_date" ).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
      });
    } );

    $('#save').on('submit',function(e){

      $('#save').text('অপেক্ষা করুন ...');

    });
    
  </script>
@endsection