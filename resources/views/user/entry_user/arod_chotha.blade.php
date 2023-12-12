@extends('user.layout.master')
@section('body')

<form action="#" id="form_data" method="POST">
@csrf

<div class="flex p-6 bg-gray-100 ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
        <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3">
          <div class="mb-2 text-center text-gray-600">
            <p class="text-2xl font-medium">আড়ত চৌথা</p>
          </div>
          
          <div class="lg:col-span-2">
            <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5">

              <div class="md:col-span-1">
                <label for="area">এরিয়া :</label>
                <select name="area" id="area" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" onchange="getMohajonAddressByArea();" required>
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
                <select name="address" id="address" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" onchange="getMohajonNameByAddress();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('address'))
                <span class="text-sm text-red-600">{{ $errors->first('address') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="mohajon_setup_id">মহাজনের নাম :</label>
                <select name="mohajon_setup_id" id="mohajon_setup_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" onchange="getPurchaseIdByMohajonId();" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('mohajon_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('mohajon_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-3">
                <label for="purchase_id">গ্রহণ সংখ্যা / পন্যের নাম / সাইজ / মার্কা / গ্রহনের ধরণ:</label>
                <select name="purchase_id" id="purchase_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" onchange="loadArodChothaTable();" required>
                  <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('purchase_id'))
                <span class="text-sm text-red-600">{{ $errors->first('purchase_id') }} </span>
                @endif
              </div>
      
              <!-- <div class="text-right md:col-span-5">
                <div class="inline-flex items-end">
                  <button type="submit" id="save" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">দেখুন</button>
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

<div class="flex p-6 bg-gray-100" id="table_form">
 
</div>

<script>
  function getCommissionPurchaseMonth()
  {
    var txtMonth = $('#txtMonth').val();
    if(txtMonth != "")
    {
      $.ajax({
        type : 'POST',
        url : '{{url("getCommissionPurchaseMonth")}}',
        data : {
          txtMonth : txtMonth,
        },
        success : function(response)
        {
          $('#purchase_id').html(response)
        }
      });
    }
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

    function getPurchaseIdByMohajonId()
    {
        var mohajon_setup_id = $('#mohajon_setup_id').val();

        if(mohajon_setup_id != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getPurchaseIdByMohajonId")}}',
                data : {
                  mohajon_setup_id : mohajon_setup_id,
                },
                success:function(response)
                {
                    $('#purchase_id').html(response);
                }

            });
        }
    }

    function loadArodChothaTable()
    {
      var purchase_id = $('#purchase_id').val();

      if(purchase_id != "")
      {
        $.ajax({
          type : 'POST',
          url : '{{url("loadArodChothaTable")}}',
          data : {
            purchase_id : purchase_id,
          },
          success:function(response)
          {
            document.getElementById('table_form').innerHTML = response;
          }
        });
      }
    }

</script>

@endsection