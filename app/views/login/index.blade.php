@extends('_layouts.login')

@section('main')
<div class="account-container login-box">

    <div class="content clearfix ">

        <?php echo Form::open(array('url' => 'login/auth', 'method' => 'post')); ?>

        <h1>Member Login</h1>		

        <div class="login-fields">

            <p>Masukkan data akun anda...</p>

            <?php $errtext = $errors->first(); ?>
            
            <div class="alrt alert alert-error">
                Username/Password salah, periksa kembali.
            </div>
            
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" autofocus />
            </div> <!-- /field -->

            <div class="field">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
            </div> <!-- /password -->


        </div> <!-- /login-fields -->

        <div class="login-actions">

            <span class="login-checkbox">
                <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
                <!--<label class="choice" for="Field">Keep me signed in</label>-->
            </span>

            <button class="button btn btn-success btn-large btn-sign-in"  >Sign In</button>

        </div> <!-- .actions -->

        <?php echo Form::close(); ?>

    </div> <!-- /content -->

</div> <!-- /account-container -->

<!--<div class="span12">
    <div class="login-fields">
    <div  id="jam"></div>
</div>
</div>-->


<!--
<div class="login-extra ">
        <a href="#">Reset Password</a>
</div>  -->

@stop


@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function() {
//        //setting jam
//        var options2 = {format: '%A, %d %B %Y [%H:%M:%S]'};
//        var jamLengkap = {format: '<div class="clock light"><p id="jamnya" data-date="%d %B %Y" data-ampm="{{ "TA : " }}" >%H:%M:%S</p></div>'};
//        var jamTok = {format: '%H:%M:%S'};
//        var tanggalTok = {format: '%A, %d %B %Y'};
//        jQuery('#jam').jclock(jamLengkap);
        var isLoginError = "{{ $errors->first() }}";
        jQuery('.alrt').hide();

        /**
         * Shake element
         * @returns {jQuery.fn}
         */
        jQuery.fn.shake = function() {
            this.each(function(i) {
                $(this).css({"position": "relative"});
                for (var x = 1; x <= 3; x++) {
                    $(this).animate({left: -25}, 10).animate({left: 0}, 50).animate({left: 25}, 10).animate({left: 0}, 50);
                }
            });
            return this;
        }

        function shakeLogin() {
            jQuery('.login-box').shake();
            //clear input
            jQuery('input[name=username]').val('')
            jQuery('input[name=password]').val('')
            //tampilkan pesan error
            jQuery('.alrt').show();
            //focus
            jQuery('input[name=username]').focus();
        }


        jQuery('.btn-sign-in').click(function(e) {
            var usrnm = jQuery('input[name=username]').attr('value');
            var pass = jQuery('input[name=password]').attr('value');

            e.preventDefault();
            
            if (usrnm == '' || pass == '') {
                alert('Lengkapi data yang kosong.');
            }else{
                var loginPost = "{{ URL::to('login/auth') }}";
                jQuery.post(loginPost,{
                    'username':usrnm,
                    'password':pass
                },function(data){
                    if(data == 'loginerror'){
                        shakeLogin();
                    }else{
                        location.href="{{URL::to('home')}}";
                    }
                    
                })
            }
        });
    });
</script>
@stop
