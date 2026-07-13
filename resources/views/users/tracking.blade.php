<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracker</title>
    <!-- Bootstrap CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* .hh-grayBox {
            background-color: #F8F8F8;
            margin-bottom: 20px;
            padding: 35px;
            margin-top: 20px;
        } */

        .pt45 {
            padding-top: 45px;
        }

        .row {
            display: flex;
            justify-content: center;
            width: 100%;
            padding-top: 80px;;
        }

        .order-tracking {
            text-align: center;
            width: 20%;
            position: relative;
        }
        .order-tracking.not-completed .is-complete{
            background-color: red;
        }
        .order-tracking .is-complete {
            display: block;
            position: relative;
            border-radius: 50%;
            height: 30px;
            width: 30px;
            background-color: #fcdc7c;
            margin: 0 auto;
            transition: background 0.25s linear;
            z-index: 2;
        }

        .order-tracking .is-complete:after {
            display: block;
            position: absolute;
            content: '';
            height: 14px;
            width: 7px;
            top: 5px;
            left: 5px;
            border: 0px solid #AFAFAF;
            border-width: 0px 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
        }

        .order-tracking.completed .is-complete {
            background-color: #27aa80;
        }

        .order-tracking.completed .is-complete:after {
            border-color: #fff;
            border-width: 0px 3px 3px 0;
            width: 7px;
            left: 11px;
            opacity: 1;
        }

        .order-tracking p {
            color: #1f1f1f;
            font-size: 16px;
            margin-top: 8px;
            margin-bottom: 0;
            line-height: 20px;
        }

        .order-tracking p span {
            font-size: 14px;
            color:red;
            padding-top: 10px;
        }

        .order-tracking.completed p {
            color: #000;
        }

        .order-tracking::before {
            content: '';
            display: block;
            height: 3px;
            width: 100%;
            background-color: #372b07;
            position: absolute;
            left: 0%;
            top: 13px;
            transform: translateX(-50%);
            z-index: 0;
        }

        .order-tracking:first-child::before {
            display: none;
        }

        .order-tracking.completed::before {
            background-color: #27aa80 !important;
        }
        .order-tracking.not-completed::before {
            background-color: red !important;
        }

    </style>
</head>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                <div class="row justify-content-between">

                    <div class="order-tracking {{$track ? 'completed' : ''}}">
                        <span class="is-complete"></span>
                        <p>Transfer Application<br</p>
                    </div>
                    <div class="order-tracking {{$track && $track->verify_status == null ? '' : ($track && $track->verify_status == 'No' ? 'not-completed' : 'complete')}}">
                        <span class="is-complete"></span>
                        <p>Status<br><span>{{$track && $track->verify_status == 'No' ? $track->remarks : ''}}</span></p>
                    </div>
                    <div class="order-tracking">
                        <span class="is-complete"></span>
                        <p>Appointment<br></p>
                    </div>
                    <div class="order-tracking">
                        <span class="is-complete"></span>
                        <p>Verification<br></p>
                    </div>
                    <div class="order-tracking">
                        <span class="is-complete"></span>
                        <p>Tranfer Order<br></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery (Optional, for interactivity if needed) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</x-app-layout>

