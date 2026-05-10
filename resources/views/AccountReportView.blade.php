
<html>
<head>
<title>Challan Report >> </title>
<link rel="stylesheet" href="dist/css/bootstrap.min.css">
<script src="dist/js/b1.5.1jquery.min.js"></script>
<!-- start: Favicon -->
<link rel="shortcut icon" href="img/favicon.ico">
<!-- end: Favicon -->
<style>
body{
margin:5px;
}	
.table{
font-size:15px;
white-space:nowrap;
font-family:verdana;
}
#table{
	border-color:black;
}
#table tr td{
	border-color:black;
}
#table tr th{
	border-color:black;
}
@media print {
 .dontPrint{
 display:none;
 }
}
</style>
</head>
<script>
$("document").ready(function() {
$("#table tr").toggle(function(){
    $(this).css('background-color','yellow');
},function(){
    $(this).css('background-color','white');
	
});	
});
</script>
<body>





<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> {{ $Company }} </th>
</tr>

<tr>
	<th style="text-align:center;">{{ $Address }} </th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Accounts Summary Report ({{ $type }})</th>
</tr>

@if ($type == 'Summary Wise')




<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="font-size:14px; text-align :center">Statement  OF: {{ $accountsInfo }}</th>
	<th style="font-size:14px; text-align :center">Statement  From: {{ $start_date }} To:  {{ $end_date }}</th>
</tr>



</table>

<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

    <tr>
        <th style="text-align:center;">S/L</th>
        <th style="text-align:center;">Date</th>
        <th style="text-align:Left;">Remarks</th>
        <th style="text-align:center;">Invoice</th>
        <th style="text-align:center;">Receive Amount</th>
        <th style="text-align:center;">Payment Amount</th>
        <th style="text-align:center;">Balance</th>
    </tr>

    @php
        $balance = 0;
        $sl =1;
        $totalReceive =0;
        $totalPayment=0;
    @endphp

    @foreach($transactions as $key => $row)

        @php
            $receive = 0;
            $payment = 0;

            if($row->type == 'Receive'){
                $receive = $row->amount;
                $balance += $receive;
            } else {
                $payment = $row->amount;
                $balance -= $payment;
            }
        @endphp

        <tr>

            <td>{{ $sl++ }}</td>

            <td>
                {{ \Carbon\Carbon::parse($row->entry_date)->format('d/m/Y') }}
            </td>

                <td style="text-align:right;">{{ $row->remarks ?? '-' }}</td>
   <th style="text-align:center;" title="Click Here To Open ChallanInvoice">
    <a onclick="window.open('ChallanInvoice.php?ChallanInvoice={{ $row->invoice_no ?? '-' }}',
'mywindow','menubar=1,resizable=1,width=900,height=800');" >{{ $row->invoice_no ?? '-' }}</a>
      
    </th>
      

            <td style="text-align:right;">{{ number_format($receive, 2) }}</td>

            <td style="text-align:right;">{{ number_format($payment, 2) }}</td>

            <td style="text-align:right;">{{ number_format($balance, 2) }}</td>
      

        </tr>

    @php
    $totalReceive +=$receive;
    $totalPayment+=$payment;

    @endphp    

    @endforeach



<tr>

    <th style="text-align:right;" colspan="4">  Total Amount</th>
 
    <th style="text-align:right;"> {{ $totalReceive  }}</th>
    <th style="text-align:right;"> {{ $totalPayment  }}</th>
    <th style="text-align:right;"> {{ $balance  }}</th>
   
</tr>

</tbody>
<tfoot>
	<tr>
		<th colspan=8>

            
			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;">Prepared by  </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"> </b>  
			</div>

			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;"> Manager  </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"> </b>  
			</div>

            
			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;"> Authorized </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"></b>  
			</div>
			</div>
		</th>
	</tr>
</tfoot>
</table>

@else

<table style="margin:10px;" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">
	<tr>
		<th style="text-align: center;"> <span>Data Not Found </span></th>
	</tr>	
</table>

@endif

</table>

<?php
## Challan Report Invoice Wise
if(!empty($_GET['type']) && ($_GET['type'] =='Invoice Wise') && !empty($_GET['start_date']) && !empty($_GET['end_date'])){

        //GET START DATE
        // $datestring_start_date =$_GET['start_date'];
        // list($day, $month, $year) = explode('/', $datestring_start_date);
        // $get_start_date = DateTime::createFromFormat('Ymd', $year . $month . $day);

        // //GET END DATE
        // $datestring_end_date =$_GET['end_date'];
        // list($day2, $month2, $year2) = explode('/', $datestring_end_date);
        // $get_end_date = DateTime::createFromFormat('Ymd', $year2 . $month2 . $day2);  
?>




<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="font-size:14px; text-align :center">Statement  From: {{ $start_date }} To:  {{ $end_date }}</th>
</tr>



</table>


<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Date </th>
	<th> Supplier </th>
	<th> Challan Invoice </th>
	<th> Challan Invoice Amount </th>
	<!-- <th> Discount </th>
	<th> Transport </th>
	<th> Payable </th> -->
</tr>
</thead>
<tbody>
<?php 

if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" AND A.`SupplierID` = '$_GET[SupplierID]' ";
}   

if(!empty($_GET['ItemCategoryID']) && $_GET['ItemCategoryID'] =='All'){
    $ItemCategoryID ="";
}else{
    $ItemCategoryID =" AND A.`ItemCategoryID` = '$_GET[ItemCategoryID]' ";
} 




$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

$sl =1;
$TotalAmount = 0;
$discount = 0;
$transport_cost = 0;
$payable = 0;

$query = $conn->prepare("SELECT A.*,SUM(`Amount`) AS `TotalAmount`, CONCAT(B.`Name`,'-',B.`MobileNo`) AS `SupplierInfo`  FROM `Challan` A 
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`)
WHERE A.`Cart` = 'Yes' AND A.`ChallanDate` BETWEEN '$start_date' AND '$end_date'  $SupplierID $ItemCategoryID GROUP BY A.`ChallanInvoice` ORDER BY A.`ChallanInvoice` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=7 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 

?>


<tr>
	<td><?php echo $sl++; ?> </td>
    <td style="text-align:left;"> <?php print date("d-m-Y",strtotime($fetch['ChallanDate'])); ?> </td>
    <td style="text-align:left;"><?php print $fetch['SupplierInfo']; ?></td>
    <th style="text-align:center;" title="Click Here To Open ChallanInvoice">
    <a onclick="window.open('ChallanInvoice.php?ChallanInvoice=<?php echo $fetch['ChallanInvoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['ChallanInvoice']; ?></a>
      
    </th>
    <td style="text-align:right;"> <?php print number_format($fetch['TotalAmount'],2,'.',''); ?> </td>
    <!-- <td style="text-align:right;"> <?php //print number_format($fetch['discount'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php //print number_format($fetch['transport_cost'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php //print number_format($fetch['payable'],2,'.',''); ?> </td> -->
   
</tr>

<?php	
$TotalAmount += $fetch['TotalAmount'];
// $discount += $fetch['discount'];
// $transport_cost += $fetch['transport_cost'];
// $payable += $fetch['payable'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="4"> TOTAL </th>
	<th style="text-align:right;"><?php print number_format($TotalAmount,2,'.',''); ?></th>
	<!-- <th style="text-align:right;"> <?php //print number_format($discount,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php //print number_format($transport_cost,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php //print number_format($payable,2,'.',''); ?></th> -->
</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan=8>

            
			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;">Prepared by  </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"> </b>  
			</div>

			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;"> Manager  </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"> </b>  
			</div>

            
			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;"> Authorized </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"></b>  
			</div>
			</div>
		</th>
	</tr>
</tfoot>
</table>

<?php 
	} // END 
?>



<?php 
	// }else{ 
?>
<!-- <table style="margin:10px;" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">
	<tr>
		<th><span class="label label-danger"> You do not have permission. </span></th>
	</tr>	
</table> -->
<?php 
	// } 
?>


<button onclick="window.print();" class="dontPrint">PRINT THIS PAGE </button>
<button id="download-button" class="dontPrint">Download CSV</button>

	<script type="text/javascript">

	function downloadCSVFile(csv, filename) {
	    var csv_file, download_link;

	    csv_file = new Blob([csv], {type: "text/csv"});

	    download_link = document.createElement("a");

	    download_link.download = filename;

	    download_link.href = window.URL.createObjectURL(csv_file);

	    download_link.style.display = "none";

	    document.body.appendChild(download_link);

	    download_link.click();
	}

		document.getElementById("download-button").addEventListener("click", function () {
		    var html = document.querySelector("table").outerHTML;
			htmlToCSV(html, "Challan Summary Report.csv");
		});


		function htmlToCSV(html, filename) {
			var data = [];
			var rows = document.querySelectorAll("table tr");
					
			for (var i = 0; i < rows.length; i++) {
				var row = [], cols = rows[i].querySelectorAll("td, th");
						
				 for (var j = 0; j < cols.length; j++) {
				        row.push(cols[j].innerText);
		                 }
				        
				data.push(row.join(","));		
			}

			//to remove table heading
			//data.shift()

			downloadCSVFile(data.join("\n"), filename);
		}

	</script>
</body>
</html>