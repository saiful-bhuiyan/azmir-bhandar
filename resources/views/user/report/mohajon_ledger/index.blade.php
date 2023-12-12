@extends('user.layout.master')
@section('body')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">মহাজন লেজার</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              
            <div class="md:col-span-1">
                <label for="area">এরিয়া :</label>
                <select name="area" id="area" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getMohajonAddressByArea();" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($mohajon_setup)
                    @foreach($mohajon_setup as $b)
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
                <select name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getMohajonNameByAddress();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('address'))
                <span class="text-sm text-red-600">{{ $errors->first('address') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="mohajon_setup_id">মহাজনের নাম :</label>
                <select name="mohajon_setup_id" id="mohajon_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('mohajon_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('mohajon_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_from">তারিখ শুরু :</label>
                <input type="text" name="date_from" id="date_from" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('date_from'))
                <span class="text-sm text-red-600">{{ $errors->first('date_from') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_to">তারিখ শেষ :</label>
                <input type="text" name="date_to" id="date_to" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('date_to'))
                <span class="text-sm text-red-600">{{ $errors->first('date_to') }} </span>
                @endif
              </div>
      
              <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="button" id="search" onclick="search();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সার্চ</button>
                </div>
              </div>

            </div>
          </div>
       
        </div>
      </div>
    </div>
  </div>
</div>




<div class="mb-4">


  
    

</div>

<script>

function search()
  {
    var mohajon_setup_id = $('#mohajon_setup_id').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    $.ajax({
      type : 'POST',
      url : "{{route('mohajon_ledger.search')}}",
      data :  {
        mohajon_setup_id : mohajon_setup_id,
        date_from : date_from,
        date_to : date_to
      },
      success : function(response)
      {
        var left = (screen.width - 800) / 2;
        var top = (screen.height - 700) / 4;

        var myWindow = window.open('','_blank',
        'resizable=yes, width=' + '800'
        + ', height=' + '700' + ', top='
        + top + ', left=' + left);
      
        myWindow.document.write(response.viewContent);

            
      },
      error: function(xhr, status, error) {
        console.error(error);
      }

    })
  }

function getMohajonAddressByArea()
    {
        var area = $('#area').val();

        if(area != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getMohajonAddressByArea")}}',
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

    function getMohajonNameByAddress()
    {
        var address = $('#address').val();

        if(address != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getMohajonNameByAddress")}}',
                data : {
                    address : address,
                },
                success:function(response)
                {
                    $('#mohajon_setup_id').html(response);
                }

            });
        }
    }

  $( function() {
    $( "#date_from" ).datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      maxDate: new Date(),
    });

    $( "#date_to" ).datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      maxDate: new Date(),
      onSelect: function() {
          if($("#date_from").val() > $("#date_to").val()){
            swal("সঠিক তারিখ ইনপুট করুন");
            $("#date_to").val("");
          }
        }
    });
  } );

  

</script>


@endsection