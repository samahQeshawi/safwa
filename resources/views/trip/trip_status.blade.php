@if($trip->status == 1)
New
@elseif($trip->status == 2)
Pending
@elseif($trip->status == 3)
No Driver Available
@elseif($trip->status == 4)
Driver Accepted
@elseif($trip->status == 5)
Driver Reached Pickup
@elseif($trip->status == 6)
Trip Started
@elseif($trip->status == 7)
Reached Desitnation
@elseif($trip->status == 8)
Completed Trip
@elseif($trip->status == 9)
Money Collected
@elseif($trip->status == 10)
Trip Cancelled by Driver
@elseif($trip->status == 11)
Cancelled by Driver
@endif