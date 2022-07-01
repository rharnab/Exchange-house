<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher for order number- </title>

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

  
    <!-- start -:- Customer Copy -->
    <div class="container">
       
        <img style="margin-left:-10px;" src="{{asset('support_files/img/pdf_img/exc.PNG')}}" alt="Bank Logo"  />
        
       
            <hr>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Reference No.  </span> <span style="margin-left:20px;">:</span> <span style="margin-left:5px;">{{ $trnData->transaction_pin }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Order Created On </span>  <span style="margin-left:20px;">:</span> <span style="margin-left:5px;"> {{ $trnData->created_at }} </span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Cust. A/C No.  </span> <span style="margin-left:20px;">:</span> <span style="margin-left:5px;"> @if($trnData->sender_account_number) {{$trnData->sender_account_number}} @endif </span> </div>
                <div style="float:left;width:50%;margin-left:50px;"> <span style="">Cashier Name </span>  <span style="margin-left:45px;">:</span> <span style="margin-left:5px;"> {{ $trnData->entry_by }} </span> </div>
            </p>

            <br>
            <hr>



        <b>Customer Details</b> <b style="margin-left:30px;">PIN N/A</b>

        <div style="">
           
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Customer Name.  </span> <span style="margin-left:40px;">:</span> <span style="margin-left:5px;">{{ $trnData->sender_name }}</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Remittance Purpose </span>  <span style="margin-left:20px;">:</span> <span style="margin-left:5px;"> {{ $trnData->purpose_of_sending }} </span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Phone  </span> <span style="margin-left:110px;">:</span> <span style="margin-left:5px;"> {{ $trnData->sender_contact }} </span> </div>
                <div style="float:left;width:50%;margin-left:50px;"> <span style="">Type </span>  <span style="margin-left:115px;">:</span> <span style="margin-left:10px;">   @if($trnData->trnTp=='A'){{'Account'}} @elseif($trnData->trnTp=='C'){{'Cash'}}  @endif</span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Email  </span> <span style="margin-left:110px;">:</span> <span style="margin-left:5px;">{{ $trnData->sender_email }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Amount </span>  <span style="margin-left:95px;">:</span> <span style="margin-left:5px;"> {{ $trnData->disbursement_amount }}  </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Post Code  </span> <span style="margin-left:85px;">:</span> <span style="margin-left:5px;"> 2001 </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Rate (BDT) </span>  <span style="margin-left:75px;">:</span> <span style="margin-left:5px;"> {{ $trnData->exchange_rate }} </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Address  </span> <span style="margin-left:100px;">:</span> <span style="margin-left:5px;">{{ $trnData->sender_address_line }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Equivalent (ZAR) </span>  <span style="margin-left:35px;">:</span> <span style="margin-left:5px;"> {{ $trnData->originated_amount }} </span> </div>
            </p>

            <br>
            <br>
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="font-size:16px;"><b> Beneficiary Details  </b></span> <span style="margin-left:115px;"></span> <span style="margin-left:5px;"> </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Gross Fees </span>  <span style="margin-left:85px;">:</span> <span style="margin-left:5px;">{{ $gross_fees = $trnData->originated_customer_fee }}  </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Beneficiary Name</span> <span style="margin-left:70px;">:</span> <span style="margin-left:5px;"> {{ $trnData->receiver_name }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">VAT </span>  <span style="margin-left:125px;">:</span> <span style="margin-left:5px;"> {{ $vat = ($trnData->originated_amount * 0.5) / 100 }} </span> </div>
            </p>

            <br> 
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Account No</span> <span style="margin-left:110px;">:</span> <span style="margin-left:5px;"> {{ $trnData->receiver_account_number }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Online Charge </span>  <span style="margin-left:65px;">:</span> <span style="margin-left:5px;"> @if($trnData->sender_transaction_receiving_mode=='2') {{ $online_charge = ($trnData->originated_amount * 1) / 100 }} @else {{ $online_charge = '0.00'}}  @endif</span> </div>
            </p>
            
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Bank</span> <span style="margin-left:155px;">:</span> <span style="margin-left:5px;"> @if($trnData->receiver_bank) {{ $trnData->receiverBank->name }} @endif</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Total Fees Received </span>  <span style="margin-left:30px;">:</span> <span style="margin-left:5px;"> {{$total_fees_received = $gross_fees + $vat + $online_charge}} </span> </div>
            </p>
            
            <br><br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">District</span> <span style="margin-left:135px;"> : </span> <span style="margin-left:5px;"> @if($trnData->receiver_sub_country_level_1) {{ $trnData->receiverCity->name }} @endif</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Discount </span>  <span style="margin-left:105px;">:</span> <span style="margin-left:5px;"> 0.00</span> </div>
            </p>
            
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Branch</span> <span style="margin-left:135px;"> : </span> <span style="margin-left:5px;"> @if($trnData->receiver_bank_branch) {{ $trnData->receiverBankBranch->name }} @endif</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Card Charge </span>  <span style="margin-left:80px;">:</span> <span style="margin-left:5px;"> 0.00</span> </div>
            </p>
            
            <br>
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Branch Address </span> <span style="margin-left:75px;"> : </span> <span style="margin-left:5px;">   </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Cash Amount </span>  <span style="margin-left:75px;">:</span> <span style="margin-left:5px;"> {{$cash_amt = $total_fees_received + $trnData->originated_amount}} </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Phone</span> <span style="margin-left:135px;"></span> : <span style="margin-left:155px;"> {{$trnData->receiver_contact}} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="font-size:16px;"><b>    Grand Total </b></span>  <span style="margin-left:80px;">:</span> <b style="margin-left:5px;"> {{$cash_amt = $total_fees_received + $trnData->originated_amount}} </b> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style=""><b>  </b></span> <span style="margin-left:115px;"></span> <span style="margin-left:5px;"> </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">  Paid By </span>  <span style="margin-left:115px;">:</span> <span style="margin-left:5px;"> Cash</span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style=""> Photo ID </span> <span style="margin-left:115px;"></span> : <span style="margin-left:5px;">
            545656776</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style=""> VAT Registration </span>  <span style="margin-left:50px;">:</span> <span style="margin-left:5px;"> 565676712234</span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style=""><b>  </b></span> <span style="margin-left:115px;"></span> <span style="margin-left:5px;"> </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style=""> Tax Registration No</span>  <span style="margin-left:40px;">:</span> <span style="margin-left:5px;"> 1233398788</span> </div>
            </p>

          
        </div>

      
    </div>     <!-- end container -->


    <br>
    <br>
    <img style="margin-left:-10px;" src="{{asset('support_files/img/pdf_img/footer.PNG')}}" alt="Not found img"  />
    
    <br>
    <!-- start bank copy -->
    <img style="margin-left:-10px;margin-top:300px;" src="{{asset('support_files/img/pdf_img/bank_copy_header.PNG')}}" alt="Not found img"  />
    
    
     <hr>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Reference No.  </span> <span style="margin-left:40px;">:</span> <span style="margin-left:5px;">{{ $trnData->transaction_pin }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Order Created On </span>  <span style="margin-left:20px;">:</span> <span style="margin-left:5px;"> {{ $trnData->created_at }} </span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Cust. A/C No.  </span> <span style="margin-left:40px;">:</span> <span style="margin-left:5px;"> @if($trnData->sender_account_number) {{$trnData->sender_account_number}} @endif </span> </div>
                <div style="float:left;width:50%;margin-left:50px;"> <span style="">Cashier Name </span>  <span style="margin-left:45px;">:</span> <span style="margin-left:5px;"> {{ $trnData->entry_by }} </span> </div>
            </p>

            <br>
            <hr>



        <b>Customer Details</b> <b style="margin-left:30px;">PIN N/A</b>

        <div style="">
           
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Customer Name.  </span> <span style="margin-left:70px;">:</span> <span style="margin-left:5px;">{{ $trnData->sender_name }}</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Remittance Purpose </span>  <span style="margin-left:20px;">:</span> <span style="margin-left:5px;"> {{ $trnData->purpose_of_sending }} </span> </div>
            </p>

            <p style="margin-left:5px;">
                <div style="float:left;width:50%;margin-left:5px;"> <span >Phone  </span> <span style="margin-left:140px;">:</span> <span style="margin-left:5px;"> {{ $trnData->sender_contact }} </span> </div>
                <div style="float:left;width:50%;margin-left:50px;"> <span style="">Type </span>  <span style="margin-left:115px;">:</span> <span style="margin-left:10px;">   @if($trnData->trnTp=='A'){{'Account'}} @elseif($trnData->trnTp=='C'){{'Cash'}}  @endif</span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Email  </span> <span style="margin-left:140px;">:</span> <span style="margin-left:5px;">{{ $trnData->sender_email }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Amount </span>  <span style="margin-left:95px;">:</span> <span style="margin-left:5px;"> {{ $trnData->disbursement_amount }}  </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Post Code  </span> <span style="margin-left:115px;">:</span> <span style="margin-left:5px;"> 2001 </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Rate (BDT) </span>  <span style="margin-left:75px;">:</span> <span style="margin-left:5px;"> {{ $trnData->exchange_rate }} </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span > Address  </span> <span style="margin-left:115px;">:</span> <span style="margin-left:5px;">{{ $trnData->sender_address_line }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Equivalent (ZAR) </span>  <span style="margin-left:35px;">:</span> <span style="margin-left:5px;"> {{ $trnData->originated_amount }} </span> </div>
            </p>

            <br>
            <br>
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="font-size:16px;"><b> Beneficiary Details  </b></span> <span style="margin-left:115px;"></span> <span style="margin-left:5px;"> </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Gross Fees </span>  <span style="margin-left:85px;">:</span> <span style="margin-left:5px;">{{ $gross_fees = $trnData->originated_customer_fee }}  </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Beneficiary Name</span> <span style="margin-left:70px;">:</span> <span style="margin-left:5px;"> {{ $trnData->receiver_name }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">VAT </span>  <span style="margin-left:125px;">:</span> <span style="margin-left:5px;"> {{ $vat = ($trnData->originated_amount * 0.5) / 100 }} </span> </div>
            </p>

            <br> 
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Account No</span> <span style="margin-left:110px;">:</span> <span style="margin-left:5px;"> {{ $trnData->receiver_account_number }} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Online Charge </span>  <span style="margin-left:65px;">:</span> <span style="margin-left:5px;"> @if($trnData->sender_transaction_receiving_mode=='2') {{ $online_charge = ($trnData->originated_amount * 1) / 100 }} @else {{ $online_charge = '0.00'}}  @endif</span> </div>
            </p>
            
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Bank</span> <span style="margin-left:155px;">:</span> <span style="margin-left:5px;"> @if($trnData->receiver_bank) {{ $trnData->receiverBank->name }} @endif</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Total Fees Received </span>  <span style="margin-left:30px;">:</span> <span style="margin-left:5px;"> {{$total_fees_received = $gross_fees + $vat + $online_charge}} </span> </div>
            </p>
            
            <br><br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">District</span> <span style="margin-left:135px;"> : </span> <span style="margin-left:5px;"> @if($trnData->receiver_sub_country_level_1) {{ $trnData->receiverCity->name }} @endif</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Discount </span>  <span style="margin-left:105px;">:</span> <span style="margin-left:5px;"> 0.00</span> </div>
            </p>
            
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Branch</span> <span style="margin-left:135px;"> : </span> <span style="margin-left:5px;"> @if($trnData->receiver_bank_branch) {{ $trnData->receiverBankBranch->name }} @endif</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Card Charge </span>  <span style="margin-left:80px;">:</span> <span style="margin-left:5px;"> 0.00</span> </div>
            </p>
            
            <br>
            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Branch Address </span> <span style="margin-left:75px;"> : </span> <span style="margin-left:5px;">   </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">Cash Amount </span>  <span style="margin-left:75px;">:</span> <span style="margin-left:5px;"> {{$cash_amt = $total_fees_received + $trnData->originated_amount}} </span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style="">Phone</span> <span style="margin-left:135px;"></span> : <span style="margin-left:155px;"> {{$trnData->receiver_contact}} </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="font-size:16px;"><b>    Grand Total </b></span>  <span style="margin-left:80px;">:</span> <b style="margin-left:5px;"> {{$cash_amt = $total_fees_received + $trnData->originated_amount}} </b> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style=""><b>  </b></span> <span style="margin-left:115px;"></span> <span style="margin-left:5px;"> </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style="">  Paid By </span>  <span style="margin-left:115px;">:</span> <span style="margin-left:5px;"> Cash</span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style=""> Photo ID </span> <span style="margin-left:115px;"></span> : <span style="margin-left:5px;">
            545656776</span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style=""> VAT Registration </span>  <span style="margin-left:50px;">:</span> <span style="margin-left:5px;"> 565676712234</span> </div>
            </p>

            <br>
            <p style="margin-left:5px;margin-top:-10px;">
                <div style="float:left;width:50%;margin-left:5px;"><span style=""><b>  </b></span> <span style="margin-left:115px;"></span> <span style="margin-left:5px;"> </span></div>
                <div style="float:left;width:50%;margin-left:50px;"><span style=""> Tax Registration No</span>  <span style="margin-left:40px;">:</span> <span style="margin-left:5px;"> 1233398788</span> </div>
            </p>

          
        </div>
        <br> <br>

            <img style="margin-left:-10px;" src="{{asset('support_files/img/pdf_img/footer.PNG')}}" alt="Not found img"  />
    
</body>
</html>

