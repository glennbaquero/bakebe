<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
	<title> {{ $item->reference_number }}</title>
</head>

<link rel="stylesheet" type="text/css" href="{{ mix('assets/admin/app.css') }}">



<style type="text/css">
	
	table {
		width: 100%;
	}

	th, td {
		padding: 5px;	
		text-align: center;
	}

	.inlineBlock-parent > * {
		display: inline-block;
		vertical-align: middle;
	}

	.align-t {
		vertical-align: top;
	}

	.invoice--number {
		font-size: 2em !important;
		color: #e8627c !important;
	}

	.w-100 {
		width: 100%;
	}

	.w-50 {
		width: 50%;
	}

	.bold {
		font-weight: bold;
	}

	.marginy-5 {
		margin: 20px 0px;
	}

	.invoice--img {
		width: 30px;
		height: 30px;
		/*background-color: red;*/
		object-fit: contain;
		margin-right: 10px;
	}

	thead {
		border: solid 2px #000;
	}

	th {
		padding: 20px 50px;
		border-right: solid 2px #000;
	}

	th:last-child {
		border-right: 0;
	}

	tr {
		padding: 15px 0px;
		border: solid 2px #000;
	}

	td {
		padding: 15px 50px;
		text-align: center;
	}

	.width-90 {
		width: 90%;
		margin: 0 auto;
	}


</style>
 
<body  style="background-color: #fff">

<div class="frm-cntnr">
		<div class="width-90 mx-auto py-3">
			{{-- <div class="row">
				<div class="col-md-12">
					<img src="{{ $logo }}" class="export--image">
				</div>
			</div> --}}

			<h5 class="invoice--number bold">#{{ $item->reference_number }}</h5>
			<div class="w-100 inlineBlock-parent">
				<div class="w-50">

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Customer Name: </p> <p class="text-muted">{{ $item->user->renderName() }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Type of Booking:</p> <p class="text-muted">{{ $item->cart->bookingType->name }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Booking Date:</p> <p class="text-muted">{{ $item->renderDate() }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Location:</p> <p class="text-muted">{{ $item->cart->branch->name }}</p>
					</div>
				</div
				><div class="w-50">
					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Payment Option:</p> <p class="text-muted">{{ $item->renderPaymentTypeLabel() }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Voucher Code:</p> <p class="text-muted"> {{ $item->payment_code ? $item->payment_code : 'none'}} </p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted bold">Total Amount:</p> <p class="text-muted">P {{ $item->total_payment}}</p>
					</div>
				</div>
			</div>


			<div class="w-100 mt-4 desktop-show">
				<p class="text-muted bold marginy-5">Pastries Booked:</p>
				<table class="table selected--table">
				  <thead>
				    <tr class="text-center">
				    	<th scope="col"></th>							    	
				    	<th scope="col">Pastry</th>
				      	<th scope="col">Duration</th>
				      	<th scope="col">Difficulty</th>
				      	<th scope="col">Guest</th>
				      	<th scope="col">Scheduled Date</th>
				      	<th scope="col">Time</th>
				    </tr>
				  </thead>
				  <tbody>
					@foreach($item->invoiceItems as $invoiceItem)
					    <tr class="text-center">
				    	<td><img class="img-contain mr-2 sel-book__img" src="{{ url('storage/'.json_decode($invoiceItem->pastry_data)->image_path) }}" height="50px" width="50px"alt=""></td>
					      <td><small class="text-muted"> {{ json_decode($invoiceItem->pastry_data)->name }} </small></td>
					      <td><small class="text-muted">{{ $item->convertToHoursMins(json_decode($invoiceItem->pastry_data)->duration) }} </small></td>
					      <td><small class="text-muted">{{ json_decode($invoiceItem->pastry_data)->difficulty }}/5 </small></td>
					      <td><small class="text-muted">{{ $invoiceItem->attendees }}</small></td>
					      <td><small class="text-muted">{{ $invoiceItem->scheduled_date }}</small></td>
					      <td><small class="text-muted">{{ $invoiceItem->start_time }}</small></td>
					    </tr>
					@endforeach
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>