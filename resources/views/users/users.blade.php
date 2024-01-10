<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
        body {
    background-color: rgb(137, 137, 142);
    }
</style>
</head>
<body>
    <div class="container">

        <div class="row border-bottom mt-3">
            <h3 class="d-flex align-items-center">
                    <i class="bi bi-list-check me-2 text-dark"></i>
                    <span class="text-white">Online Todo</span>
                    <span class="text-danger">&nbspA</span>
                    <span class="text-white">pplication</span>
                </h3>
        <div class="col-lg-6 border-end border-start border-top mt-3">
            <header class="modal-header">
                <h4>Sign Up:</h4>
            </header>
            <div class="form-group">
                <label><b>Name:</b></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name">
            </div>
                <div class="form-group">
                <label><b>Email:</b></label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
            </div>
                        <div class="form-group">
                <label><b>Phone:</b></label>
                <input type="number" name="phone" id="phone" class="form-control" placeholder="Enter phone number">
            </div>
                        <div class="form-group">
                <label><b>Password:</b></label>
                <input type="password" name="pass1" id="pass1" class="form-control" placeholder="Enter password">
            </div>
                        <div class="form-group">
                <label><b>Confirm Password:</b></label>
                <input type="password" name="pass_confirmation" id="pass_confirmation" class="form-control" placeholder="Enter confirm password">
                <div class="form-group">
                <button id="btnSignUP" class="btn btn-md btn-outline-dark mt-2">Signup</button>
            </div>
            </div>
        </div>
            {{-- Sign In --}}
            <div class="col-lg-6 border-end border-top mt-3">
                <header class="modal-header">
                    <h4>Sign In</h4>
                </header>
            <div class="form-group">
                <label><b>Email :</b></label>
                <input type="text" name="loginEmail" id="loginEmail" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label><b>Password:</b></label>
                <input type="password" name="loginPass" id="loginPass" class="form-control" placeholder="Enter password">
            </div>
            <div class="form-group">
                <button id="btnLogin" class="btn btn-md btn-outline-light mt-2" type="button">Login</button>
            </div>
            </div>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        console.log('jQuery loaded');
        $("#btnSignUP").click(function(){
            console.log('button Clicked');
            $.ajax({
                'url':`{{url('/users/signup')}}`,
                'method':'POST',
                'data':{
                    'name'  :$("#name").val(),
                    'email' :$("#email").val(),
                    'phone' :$("#phone").val(),
                    'pass1' :$("#pass1").val()
                },
                'success':function(data,status){
                    if(status=='success'){
                        if(data.message=='success'){
                        alert("users signup successfull...");
                        }else{
                            alert('Something went Wrong!')
                        }
                    }
                },
                'error': function(error){
                            console.log(error);
                        }
            });
        });
        $("#btnLogin").click(function(){
            var email = $('#loginEmail').val();
            var pass1 = $('#loginPass').val();
            $.ajax({
                'url': `{{url('/users/signin')}}`,
                'method': 'POST',
                'data':{'email':email,'pass1':pass1},
                'success':function(data,status){
                                    if(status =='success'){
                            if(data.message =='success')
                                    {
                                        window.location.href='{{url('/')}}';
                                    }else{
                                        alert(data.message);
                                    }
                            }
                },
                'error' :function(error){
                        console.log(error);
                    }
            });
        });
    });
</script>
</body>
</html>