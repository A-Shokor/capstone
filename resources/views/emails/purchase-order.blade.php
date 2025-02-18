<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order #{{ $purchaseOrder->id }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto;">
        <h1 style="color: #0d6efd;">Purchase Order #{{ $purchaseOrder->id }}</h1>
        <p>Hello {{ $purchaseOrder->supplier?->name ?? 'Supplier' }},</p>
        <p>Please find below the details of your purchase order:</p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #0d6efd; color: #fff;">
                    <th style="padding: 10px; text-align: left;">Product Name</th>
                    <th style="padding: 10px; text-align: left;">Ordered Quantity</th>
                    <th style="padding: 10px; text-align: left;">Unit Cost</th>
                    <th style="padding: 10px; text-align: left;">Total Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->items as $item)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">{{ $item->product?->name ?? 'N/A' }}</td>
                    <td style="padding: 10px;">{{ $item->ordered_quantity }}</td>
                    <td style="padding: 10px;">${{ number_format($item->unit_cost, 2) }}</td>
                    <td style="padding: 10px;">${{ number_format($item->ordered_quantity * $item->unit_cost, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 20px;">Thank you for your cooperation. Please confirm receipt of this order.</p>
        <p>Best regards,<br>Your Company Name</p>
    </div>
</body>
</html>