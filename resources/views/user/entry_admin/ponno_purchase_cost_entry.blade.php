@extends('user.layout.master')
@section('body')


<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">পন্যের খরচ এন্ট্রি এডমিন</p>
          </div>
          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6 ">

              <div class="md:col-span-6 mx-auto">
                <div class="md:col-span-2 ">
                <label for="id">ইনভোয়েস :</label>
                  <input type="number" step="any" name="id" id="id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                  @if($errors->has('id'))
                  <span class="text-sm text-red-600">{{ $errors->first('id') }} </span>
                  @endif
                </div>
              </div>
      
              <div class="md:col-span-6 text-center mt-2">
                <div class="inline-flex items-end">
                  <button type="button" onclick="PurchaseCostEntry()"  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সার্চ</a>
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
.
</div>

<script>
  function PurchaseCostEntry()
  {
    var id = $('#id').val();
    if(id != "")
    {
        var left = (screen.width - 800) / 2;
        var top = (screen.height - 700) / 4;
        var url = "{{url('purchase_cost_form_admin')}}/"+id;

        var myWindow = window.open(url, url,
        'resizable=yes, width=' + '800' +
        ', height=' + '700' + ', top=' +
        top + ', left=' + left);
    }

    else
    {
        swal("দয়া করে ইনভয়েস ইনপুট করুন")
    }
  }
 
</script>
  @endsection