<style type="text/css">

    .form{

    }

    .form .form-control-input{
        padding: 10px;
        width: 100%;
        border-radius: 3px;
        font-size: 14px;
        color: #585a58;
        border: 1px solid #d4d4d4;
        background-color: #f9f9f9;

    }
    .form .form-control-input:focus,
    .form-control:focus {
        outline: none;
        border-radius: 5px;
        border: 1px solid var(--blue);
        box-shadow: 0 0 3px 3px #CCC7D8;
    }
    .form .form-control-input{
        margin-bottom: 5px;
    }
    .form .label-area{
        text-align: right;
    }
    @media (max-width: 995px) {
        .form .label-area{
            text-align: left;
        }
    }

    .form label{
        margin-left: 5px;
        margin-top: 10px;
    }

    .form .error-area,.success-area{
        display: none;
    }

    .form .submit-btn{
        background-color: #305485;
        min-width: 200px;
        color: #ffffff;
        padding: 9px;
        font-weight: bold;
    }
    .form .submit-btn:focus{
        outline: none;
    }

    .form .error-input{
        border: solid 1px #ce9999;
    }

    .form .alert-area{
        margin-bottom: 15px;
    }
    </style>

    <form action="{{route('login')}}" class="form" id="login" method="post">
        @csrf
        <div class="alert-area">
            <div class="alert alert-danger error-area">ok</div>
            <div class="alert alert-success success-area"></div>
        </div>
        <div class='row' style="margin-bottom: 5px;">
            <div class='col-md-4 label-area'>
                <label> Handle or Email<font color="red">*</font>:</label>
            </div>
            <div class="col-md-8">
                <input type="text" class='form-control-input' name="login" placeholder="Enter Handle or Email">
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4 label-area'>
                <label> Password<font color="red">*</font>:</label>
            </div>
            <div class="col-md-8">
                <input type="password" class='form-control-input' name="password" placeholder="Enter Password">
            </div>
        </div>
        <div class='row'>
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <div>
                    <button type="submit" class="btn submit-btn" onclick="auth.login()" style="margin-top: 15px;">Login</button>
                </div>
            </div>
        </div>
</form>