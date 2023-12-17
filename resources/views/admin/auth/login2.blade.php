<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login</title>
      <link rel="stylesheet" href="{{asset('css')}}/login_page.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="center">
         <div class="container">
            <div class="text">
               Admin Login Form
            </div>
            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf
               <div class="data">
                  <label>Email or Phone</label>
                  <input type="email" name="email" :value="old('email')" required autofocus>
               </div>
               <div class="data">
                  <label>Password</label>
                  <input type="password" name="password" required>
               </div>
               @if (Route::has('password.request'))
               <div class="forgot-pass">
                  <a href="{{ route('password.request') }}">Forgot Password?</a>
               </div>
               @endif
               <div class="btn">
                  <div class="inner"></div>
                  <button type="submit">login</button>
               </div>
            </form>
         </div>
      </div>
   </body>
</html>