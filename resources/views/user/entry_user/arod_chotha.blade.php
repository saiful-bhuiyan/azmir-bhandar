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
                <select name="mohajon_setup_id" id="mohajon_setup_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                </select>
                @if($errors->has('mohajon_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('mohajon_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_from">তারিখ শুরু :</label>
                <input type="text" name="date_from" id="date_from" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" autocomplete="off" min="01-01-2020" placeholder="তারিখ সিলেক্ট করুন" readonly required/>
                @if($errors->has('date_from'))
                <span class="text-sm text-red-600">{{ $errors->first('date_from') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_to">তারিখ শেষ :</label>
                <input type="text" name="date_to" id="date_to" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" autocomplete="off" min="01-01-2020" placeholder="তারিখ সিলেক্ট করুন" readonly required/>
                @if($errors->has('date_to'))
                <span class="text-sm text-red-600">{{ $errors->first('date_to') }} </span>
                @endif
              </div>
      
              
              <div class="md:col-span-1 mt-0 md:mt-6">
                  <button onclick="getPurchaseIdByMohajonId();" type="button" id="save" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">দেখুন</button>
                </div>
              

              <div class="md:col-span-4">
                <label for="purchase_id">গ্রহণ সংখ্যা / পন্যের নাম / সাইজ / মার্কা / গ্রহনের ধরণ:</label>
                <select name="purchase_id" id="purchase_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" onchange="loadArodChothaTable();" required>
                  <option value="" selected>সিলেক্ট</option>
                  @if($incomplete_chotha)
                    @foreach($incomplete_chotha as $v)
                    <option value="{{$v->id}}">ই - {{$v->id}} / @if($v->purchase_type == 2){{$v->mohajon_setup->name}}@else AB মার্কা @endif / {{$v->quantity}} / {{$v->ponno_setup->ponno_name}} /
                       {{$v->ponno_size_setup->ponno_size}} / {{$v->ponno_marka_setup->ponno_marka}} /
                        @if($v->purchase_type == 1) নিজ খরিদ @else কমিশন @endif</option>
                    @endforeach
                  @endif
                </select>
                @if($errors->has('purchase_id'))
                <span class="text-sm text-red-600">{{ $errors->first('purchase_id') }} </span>
                @endif
              </div>

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
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        $('#purchase_id').html('<option value="" selected>অপেক্ষা করুন.......</option>');

        if(mohajon_setup_id != "" && date_from != "" && date_to != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getPurchaseIdByMohajonId")}}',
                data : {
                  mohajon_setup_id : mohajon_setup_id,
                  date_from : date_from,
                  date_to : date_to
                },
                success:function(response)
                {
                    $('#purchase_id').html(response);
                }

            });
        }else{
          swal("সঠিক তথ্য সিলেক্ট করুন")
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
            $('.short_sales').hide();

            $('.url').click(function() {
            var left = (screen.width - 800) / 2;
            var top = (screen.height - 700) / 4;

            var url = $(this).attr('href');

            var myWindow = window.open(url, url,
                'resizable=yes, width=' + '400' +
                ', height=' + '1200' + ', top=' +
                top + ', left=' + left);
                })

                $('#sales_btn').click(function(){
                  var current_text = $(this).text();
                  var newText = current_text === 'শর্ট বিক্রি' ? 'সকল বিক্রি' : 'শর্ট বিক্রি';
                  $('#sales_btn').text(newText);
                  $('.all_sales').toggle();
                  $('.short_sales').toggle();
                })
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