<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Retrieval Pass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="p-8 border-2 border-black max-w-sm w-full text-center">
        <h1 class="text-2xl font-black uppercase">Retrieval Pass</h1>
        <hr class="my-4 border-black">
        
        <div class="mb-6 flex justify-center">
           <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(url('/admin/verify-claim/' . $claim->id)) }}" 
     alt="Verification QR Code" 
     class="mx-auto">
        </div>

        <div class="text-left space-y-2 mb-8">
            <p class="text-xs font-bold uppercase">Claimant: <span class="font-normal">{{ $claim->user->first_name }} {{ $claim->user->last_name }}</span></p>
            <p class="text-xs font-bold uppercase">Tracking-ID: <span class="font-normal">{{$claim->claim_reference}} </span></p>
            <p class="text-xs font-bold uppercase">Item: <span class="font-normal">{{$claim->item->item_name}}</span></p>
            <p class="text-xs font-bold uppercase">Email: <span class="font-normal">{{$claim->user->email}}</span></p>
            <p class="text-xs font-bold uppercase">Phone: <span class="font-normal">{{$claim->user->phone_number}}</span></p>
            <p class="text-xs font-bold uppercase">Date: <span class="font-normal">{{ now()->format('M d, Y') }}</span></p>
        </div>

        <button onclick="window.print()" class="no-print w-full py-3 bg-black text-white font-bold rounded">Click to Print</button>
    </div>
    <script>
    // Optional: Automatically open print dialog when page loads
    window.onload = function() {
        // Small delay to ensure QR code image is rendered
        setTimeout(() => {
            window.print();
        }, 500);
    };
</script>
</body>
</html>