<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Payment Invoice</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div class="invoice-box" style="max-width: 800px;margin: auto;padding: 30px;border: 1px solid #eee;box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);font-size: 16px;line-height: 24px;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;color: #555;">
			<table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
				<tr class="top">
					<td colspan="2" style="padding: 5px;vertical-align: top;">
						<table style="width: 100%;line-height: inherit;text-align: left;">
							<tr>
								<td class="title" style="padding: 5px;vertical-align: top;padding-bottom: 20px;font-size: 25px;line-height: 45px;color: #333;">
									
									<div style="display: flex;align-items: center;user-select: none;color: black;">
										<img src="{{ asset('icons/tab-icon.png') }}" alt="logo" style="width: 100%; max-width: 50px">
										<div style="padding-left: 10px;">Tripkhata®</div>
									</div>
								</td>
								<td style="padding: 5px;vertical-align: top;text-align: right;padding-bottom: 20px;">
									Invoice #: {{ $user['invoice_id'] }}<br>
									Created: {{$user['invoice_created'] }}<br>
									{{-- Due: February 1, 2015 --}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information ml-3">
					<td colspan="2" style="padding: 5px;vertical-align: top;">
						<table style="width: 100%;line-height: inherit;text-align: left;">
							<tr>
								<td style="padding: 5px;vertical-align: top;padding-bottom: 40px;">
									Lights Lab.<br>
									Shantinagar,Banewshor<br>
									Kathmandu,Nepal
								</td>

								<td style="padding: 5px;vertical-align: top;text-align: right;padding-bottom: 40px;">
									{{ $user['name'] }}<br>
									{{ $user['email'] }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">Payment Method</td>

					<td style="padding: 5px;vertical-align: top;text-align: right;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">Payment Type</td>
				</tr>

				<tr class="details">
					<td style="padding: 5px;vertical-align: top;padding-bottom: 20px;">{{ $user['payment_method'] }}</td>

					<td style="padding: 5px;vertical-align: top;text-align: right;padding-bottom: 20px;">{{ $user['payment_type'] }}</td>
				</tr>

				<tr class="heading">
					<td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">Item</td>

					<td style="padding: 5px;vertical-align: top;text-align: right;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">Price</td>
				</tr>

				<tr class="item">
					<td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;">{{ $user['item']}}</td>

					<td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 1px solid #eee;">{{ $user['amount'] }}</td>
				</tr>

				<tr class="total">
					<td style="padding: 5px;vertical-align: top;"></td>

					<td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">Total: {{ $user['amount']}}</td>
				</tr>
			</table>
		</div>
	</body>
</html>