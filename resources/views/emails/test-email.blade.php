<!DOCTYPE html>
<html>
<head>
    <title>Your Order Details</title>
</head>
<body>
    <h1>Hey {{$name}},</h1>
    <p>Hope you are doing fine.</p>
    <p>Here are the details of your order:</p>
    <h1>Order ID: {{$id}}</h1>
    <h3>Price: {{$total}} BDT</h3>
    <p>To view the details of your order, click on the link below:</p>
    <a href="{{route('customer.order.orderdetail', $id)}}">View Order Details</a>
    <p>Thank you for shopping with us.</p>
    <p>Regards,</p>
    <p>Simple PRoduct Catalog</p>
</body>
</html>
