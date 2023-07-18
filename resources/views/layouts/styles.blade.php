    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <style>
       .nav-sidebar .nav-item.menu-open .nav-link{
            padding: 10px 5px!important;
            font-size: 14px!important;
        }
        .nav-sidebar .nav-item .nav-link{
            padding: 10px 5px!important;
            font-size: 14px!important;
        }
        p{
        margin-bottom: 0!important;
       }
       .dataTables_filter label ,.dataTables_length label{
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            margin-top: 1rem;
       }
       .dataTables_length label select{
        width: 4rem;
        color: #343a40;
        margin-left: 10px;
        margin-right: 10px;
        box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
       }
       .dataTables_filter label input {
        box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
        margin-left: 10px;
        padding-left: 35px;
        height: 35px;
       }
       .form-control{
        box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);

       }
        .dataTables_filter label::before{
            font-family: fontAwesome;
            content: "\f002";
            width: 29px;
            top: 0;
            left: 95px;
            border-right: 2px solid #e3e0e0;
            position: relative;
            display: inline-block;
            color: #343a40;
         }
         /* .group{
             display: flex;
         } */
         .group label{
            width: 30%;
         }
         @media(max-width:768px){
            .dataTables_wrapper{
                overflow: auto;
            } 
         }
         @media(max-width:500px){
            .dataTables_filter label::before{
                top: 21px;
                left: 88px;
                position: absolute;
            }
         }
         .table th{
            font-size: 15px!important;
            padding: 11px 5px!important;
         }
         .table thead{
            background: #494e54!important;
            color: aliceblue!important;
         }
         .card-header{
             display: none;
         }
         .card-footer button{
            background-color: #494e54!important;
            border-color: #494e54!important;
         }
         .page-item.active .page-link{
            background-color: #494e54!important;
            border-color: #494e54!important;
            color:#fff!important;
         }
         .page-link{
            color: #494e54!important;
         }
         .card-primary.card-outline {
            border-top: 5px solid #494e54!important;
         }
         .box-profile form a{
            background-color: #494e54!important;
            border-color: #494e54!important;
         }
         /* #role{
            box-shadow: 0 0 8px 1px #494e54;
         } */
         /* #role .opt{
            background-color: #fff!important;
            box-shadow: 0 0 8px 1px #494e54!important; 
         } */
         .select-role{
        box-shadow: 0 0 6px 1px #494e54!important;
    }
    .group{
       display: flex;
    }
    </style>
    @stack('styles')
