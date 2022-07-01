<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher for order number- {{ $trnData->order_no }}</title>

    <style>
        .container {
            margin: 0 auto;
        }
        .row {
            display: flex;
        }
        .pull-right {
            float: right !important;
        }
        .text-center {
            text-align: center;
        }
        .padding-null {
            padding: 4px;
        }
        .margin-null {
            margin: 4px;
        }
        .col-md-6 {
            width: 50%;
        }

        /* table  */
        table, td, th {
            border: 1px solid black;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 5px;
            font-size: 12px;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        /* table */
        .customer_signature {
            float:left;
            border-top:1px solid black;
            width:40%;
            text-align:center;
            padding-top:5px;
            margin-top:30px;
        }
    </style>

</head>
<body>
    <!-- start -:- Bank Copy -->
    <div class="container">
        <img style="margin-left:40%;"  src="image/logo.png" alt="Bank Logo" height="40px" width="330px" />
        <span class="text-center pull-right" style="border : 1px solid black;padding:5px 10px;margin:15px 0px;"><strong>Bank Copy</strong></span>
        <p class="padding-null text-center" style="margin-top:5%;">
            <span style="font-size: 12px;"><u>{{ $trnData->agent->name }}</u></span>&nbsp;
            <span class="text-size-13"></span><strong>Branch Payment Receipt</strong>
        </p>

        <div class="row"  style="border-bottom: 0.5px solid black;">
            <div class="col-md-12 col-xs-12">
                <p class="padding-null margin-null text-left text-size">
                    <b>Transaction Summary:
                        @if($trnData->voucher_print == 1)
                            <span style='color:red'> Duplicate</span>
                        @else
                            <span style='color:green'> Original copy</span>
                        @endif
                    </b>
                </p>
            </div>
        </div><br>

        <!-- Transaction Summary: Duplicate -->
        <div style="border: 1px solid black;height:200px;">
            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > PIN No.  </span> <span style="margin-left:90px;">:</span> <span style="margin-left:5px;">{{ $trnData->transaction_pin }}</span></div>
                <div style="float:left;width:50%;"><span style="">Exchange House</span>  <span style="margin-left:20px;">:</span> <span style="margin-left:5px;">{{ $trnData->agent->name }}</span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Payout Date  </span> <span style="margin-left:65px;">:</span> <span style="margin-left:5px;">{{ $trnData->date_of_payment }}</span> </div>
                <div style="float:left;width:50%;"> <span style="">Remittance Amount</span>  <span style="margin-left:5px;">:</span> <span style="margin-left:5px;">{{ $trnData->disbursement_amount }} {{ $trnData->currency->name }} <small style="font-size:8px;color:red;">  PAID {{ $trnData->date_of_payment }}</small> </span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Transaction Type  </span>
                    <span style="margin-left:30px;">:</span>
                    <span style="margin-left:5px;">
                        @if($trnData->trnTp == 'A')
                            Account Credit
                        @else
                            Cash Payment
                        @endif
                    </span>
                </div>
                <div style="float:left;width:50%;">
                    <span style="">Incentive Amount</span>
                    <span style="margin-left:20px;">:</span>
                    <span style="margin-left:5px;">
                        {{ $trnData->disbursement_amount * 2.5 / 100 }}
                    </span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Transaction Status  </span> <span style="margin-left:25px;">:</span> <span style="margin-left:5px;">Paid</span> </div>
                <div style="float:left;width:50%;">
                    <span style="">Total Paid Amount</span>
                    <span style="margin-left:15px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100) }} {{ $trnData->currency->name }} </span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Paid Amount in word </span>
                    <span style="margin-left:5px;">:</span>
                    <span style="margin-left:5px; text-transform: capitalize" >{{ convertAmountInWord($trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100)) }}</span>
                </div>
            </p>
        </div>

        <!-- Transaction Summary: Duplicate --><br>
        <!-- Transaction Summary: Duplicate -->
        <div style="border: 1px solid black;height:200px;">
            <b style="margin-left:20%;">Receiver</b> <b style="margin-left:30%;">Sender</b>
            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span> Name  </span>
                    <span style="margin-left:70px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->receiver_name }}</span>
                </div>
                <div style="float:left;width:50%;">
                    <span style=""></span>
                    <span style="margin-left:20px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_name }}</span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Address  </span>
                    <span style="margin-left:55px;">:</span>
                    <span style="margin-left:5px;"> {{ $trnData->receiver_address }}</span>
                </div>
                <div style="float:left;width:50%;">
                    <span style=""></span>
                    <span style="margin-left:20px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_address_line }}</span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Sending Country  </span>
                    <span style="">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_country }}</span>
                </div>
                <div style="float:left;width:50%;">
                    <span style=""></span>
                    <span style="margin-left:15px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->country->name }}</span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Contact No </span>
                    <span style="margin-left:5px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->receiver_contact }}</span>
                </div>
                <div style="float:left;width:50%;margin-left:5px;">
                    <span> </span>
                    <span style="margin-left:5px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_contact }}</span>
                </div>
            </p>
        </div>

        <p>Customer Undertaking: I/We hereby undertake that I/We shall return the incentive if any irregularities is found against me/us in availing the incentive. I/We also authorize Bank to initiate legal action for such irregularities.</p>

        <div class="customer_signature" style="">
            Customer Signature
        </div>

        <div class="authorized_signature" style="">
            Authorized Signature
        </div>

        <p>Print date : {{  date('Y-m-d') }}</p>
        <p style="border-bottom:1px solid black;"></p>
        <!-- Transaction Summary: Duplicate -->
        <br><br><br><br><br><br><br><br><br><br><br><br>

        <img style="margin-left:40%;" src="image/logo.png" alt="Bank Logo" height="40px" width="330px" />
        <span class="text-center pull-right" style="border : 1px solid black;padding:5px 10px;margin:15px 0px;"><strong>Customer Copy</strong></span>

        <p class="padding-null text-center" style="margin-top:5%;">
            <span style="font-size: 12px;"><u>{{ $trnData->agent->name }}</u></span>&nbsp;
            <span class="text-size-13"></span><strong>Branch Payment Receipt</strong>
        </p>

        <div class="row"  style="border-bottom: 0.5px solid black;">
            <div class="col-md-12 col-xs-12">
                <b>Transaction Summary:
                    @if($trnData->voucher_print == 1)
                        <span style='color:red'> Duplicate</span>
                    @else
                        <span style='color:green'> Original copy</span>
                    @endif
                </b>
            </div>
        </div>
        <br>

        <!-- Transaction Summary: Duplicate -->
        <div style="border: 1px solid black;height:200px;">
            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > PIN No.  </span> <span style="margin-left:90px;">:</span> <span style="margin-left:5px;">{{ $trnData->transaction_pin }}</span></div>
                <div style="float:left;width:50%;"><span style="">Exchange House</span>  <span style="margin-left:20px;">:</span> <span style="margin-left:5px;">{{ $trnData->agent->name }}</span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Payout Date  </span> <span style="margin-left:65px;">:</span> <span style="margin-left:5px;">{{ $trnData->date_of_payment }}</span> </div>
                <div style="float:left;width:50%;"> <span style="">Remittance Amount</span>  <span style="margin-left:5px;">:</span> <span style="margin-left:5px;">{{ $trnData->disbursement_amount }} {{ $trnData->currency->name }} <small style="font-size:8px;color:red;">  PAID {{ $trnData->date_of_payment }}</small> </span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Transaction Type  </span>
                    <span style="margin-left:30px;">:</span>
                    <span style="margin-left:5px;">
                        @if($trnData->trnTp == 'A')
                            Account Credit
                        @else
                            Cash Payment
                        @endif
                    </span>
                </div>
                <div style="float:left;width:50%;">
                    <span style="">Incentive Amount</span>
                    <span style="margin-left:20px;">:</span>
                    <span style="margin-left:5px;">
                        {{ $trnData->disbursement_amount * 2.5 / 100 }}
                    </span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Transaction Status  </span> <span style="margin-left:25px;">:</span> <span style="margin-left:5px;">Paid</span> </div>
                <div style="float:left;width:50%;">
                    <span style="">Total Paid Amount</span>
                    <span style="margin-left:15px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100) }} {{ $trnData->currency->name }} </span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Paid Amount in word </span>
                    <span style="margin-left:5px;">:</span>
                    <span style="margin-left:5px;" class="text-capitalize">{{ convertAmountInWord($trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100)) }}</span>
                </div>
            </p>
        </div>
        <!-- Transaction Summary: Duplicate --><br>
        <!-- Transaction Summary: Duplicate -->
        <div style="border: 1px solid black;height:200px;">
            <b style="margin-left:20%;">Receiver</b> <b style="margin-left:30%;">Sender</b>
            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span> Name  </span>
                    <span style="margin-left:70px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->receiver_name }}</span>
                </div>
                <div style="float:left;width:50%;">
                    <span style=""></span>
                    <span style="margin-left:20px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_name }}</span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Address  </span>
                    <span style="margin-left:55px;">:</span>
                    <span style="margin-left:5px;"> {{ $trnData->receiver_address }}</span>
                </div>
                <div style="float:left;width:50%;">
                    <span style=""></span>
                    <span style="margin-left:20px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_address_line }}</span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Sending Country  </span>
                    <span style="">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_country }}</span>
                </div>
                <div style="float:left;width:50%;">
                    <span style=""></span>
                    <span style="margin-left:15px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->country->name }}</span>
                </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;">
                    <span >Contact No </span>
                    <span style="margin-left:5px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->receiver_contact }}</span>
                </div>
                <div style="float:left;width:50%;margin-left:5px;">
                    <span> </span>
                    <span style="margin-left:5px;">:</span>
                    <span style="margin-left:5px;">{{ $trnData->sender_contact }}</span>
                </div>
            </p>
        </div>

        <p>Customer Undertaking: I/We hereby undertake that I/We shall return the incentive if any irregularities is found against me/us in availing the incentive. I/We also authorize Bank to initiate legal action for such irregularities.</p>

        <div class="customer_signature" style="">
            Customer Signature
        </div>

        <div class="authorized_signature" style="">
            Authorized Signature
        </div>

        <p >Print date : {{  date('Y-m-d') }}</p>

        <p style="float:right;"> DEBIT VOUCHER</p>
        <br>
        <p style="margin-left:80%;"><b> DATE :</b> {{  date('Y-m-d') }}</p>

        <br><br><br><br><br><br><br><br><br>

        <img style="margin-left:40%;"  src="image/logo.png" alt="Bank Logo" height="40px" width="330px" />
        <p class="padding-null text-center" style="margin-top:5%;">
            <span style="font-size: 12px;"><u>{{ $trnData->agent->name }}</u></span>&nbsp;
        </p>

        <div class="row"  style="border-bottom: 0.5px solid black;">
            <div class="col-md-12 col-xs-12">
                <p class="padding-null margin-null text-left text-size">
                    <b>
                        @if($trnData->voucher_print == 1)
                            <span style='color:red'> Duplicate</span>
                        @else
                            <span style='color:green'> Original copy</span>
                        @endif
                    </b>
                </p>
            </div>
        </div>

        <!-- <div style="border-top: 1px solid black; font-weight: 700; font-size: 11px;"> -->
        <div class="row">
            <div class="col-md-12">
                <table class="table text-center" style="font-size: 11px;">
                    <thead>
                    <tr>
                        <td style="border: 1px solid black;">{{ $trnData->receiver_name }}</td>
                        <td style="border: 1px solid black;">{{ $trnData->sender_name }}</td>
                        <td style="border: 1px solid black;" colspan="2">Wge earners Remittance &
                            Incentive(GL):&nbsp;&nbsp;<span style="font-weight: bold;">{{ $trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100) }} {{ $trnData->currency->name }}</span></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;" >Branch Code&nbsp; : </td>
                        <td style="border: 1px solid black;" >Branch name : @if($trnData->receiver_bank_branch){{ $trnData->receiverBankBranch->name }} @endif</td>
                        <td style="border: 1px solid black;">
                            <p class="padding-null margin-null text-size-11 text-center">Mode of payment</p>
                            <p class="padding-null margin-null text-size-11 text-center">@if($trnData->payment_mode == 1) Cash Pickup @else Bank Deposit @endif</strong>
                            </p>
                        </td>
                        <td style="border: 1px solid black;">
                            <p class="padding-null margin-null text-size-11 text-center">TRAN CODE</p>
                            <p class="padding-null margin-null text-size-11 text-center">{{ $trnData->order_no }}</p>
                        </td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- <div class="text-center float-left" style="margin-top: 10px;"> -->
                <p style="text-align:center;"><strong>Currency</strong></p>
                <table class="table text-center">
                    <tr>
                        <td style="border: 1px solid black;width: 10px;">{{ $trnData->currency->name }}</td>
                    </tr>
                </table>
                <!-- </div> -->
            </div>

            <div class="" style="float: right;margin-top:-80px;">
                <div class="text-center" >
                    <div class="">
                        <div class="">
                            <p class="padding-null margin-null text-size-11 text-center" style="float:right;">
                                <strong>Value Date {{  date('Y-m-d') }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>


        <div class="row">
            <div class="col-md-12 col-xs-12">
                <!-- <div class="container"> -->
                <div>
                    <table class="table text-center" style="font-size: 11px;">
                        <tr>
                            <td style="border: 1px solid black;">Exchange House Name</td>
                            <td style="border: 1px solid black;">Pin/ Reference Number</td>
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;">Remittance</td>
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;">Incentive 2.5%</td>
                            <td style="border: 1px solid black;">Total</td>

                        </tr>
                        <tr>
                            <td style="border: 1px solid black;">{{ $trnData->agent->name }}</td>
                            <td style="border: 1px solid black;">{{ $trnData->order_no }}</td>
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;">{{ $trnData->disbursement_amount }} {{ $trnData->currency->name }}</td>
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;">{{ $trnData->disbursement_amount * 2.5 / 100 }} {{ $trnData->currency->name }}
                            </td>
                            <td style="border: 1px solid black;">{{ $trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100) }} {{ $trnData->currency->name }}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;" colspan="5">Total</td>
                            <td style="border: 1px solid black;">{{ $trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100) }} {{ $trnData->currency->name }}</td>
                        </tr>
                    </table>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <br><br>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <table class="table text-center" style="font-size: 12px;">
                    <tr>
                        <td style="border: 1px solid black;">Amount in words</td>
                        <td style="border: 1px solid black;">{{ convertAmountInWord($trnData->disbursement_amount + ($trnData->disbursement_amount * 2.5 / 100)) }} {{ $trnData->currency->name }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br><br>
        <div class="">
            <div class="" style="width:40%;float:left;">
                <table class="table text-center" style="font-size: 11px;">
                    <tr>
                        <td style="border-top: none;">Prepared</td>
                        <td style="border-top: none;">Posted</td>
                        <td style="border-top: none;">Checked</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">{{ $trnData->entry_by }}</td>
                        <td style="border: 1px solid black;">{{ $trnData->entry_by }}</td>
                        <td style="border: 1px solid black;">{{ $trnData->auth_by }}</td>
                    </tr>
                </table>
            </div>

            <div class="" style="float:left;border-top:1px solid black;margin-left:2%;margin-top:10px;">
                Customer Signature
            </div>

            <div class="" style="float:left;border-top:1px solid black;margin-left:10%;margin-top:10px;">
                Authorized Signature
            </div>
        </div>
        <br><br><br>
        <p style="margin-top:20px;">Print date :{{  date('Y-m-d') }}</p><br>
        <p style="border-top:1px solid black;"></p>
    </div>
    <!-- end second page -:- Bank Copy -->
</body>
</html>

