<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 0; }
        .container { max-width: 1200px; margin: auto; }
        .hotel-header { text-align: center; }
        .hotel-images img { width: 100%; height: auto; border-radius: 10px; }
        .hotel-details, .price-list, .suggested-hotels { margin-top: 20px; }
        .suggested-hotels { display: flex; justify-content: space-between; }
        .hotel-card { width: 48%; padding: 10px; border: 1px solid #ddd; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="hotel-header">
            <h1>Hotel Name</h1>
            <p>Hotel location and description.</p>
        </div>
        
        <div class="hotel-images">
            <img src="hotel-image.jpg" alt="Hotel Image">
        </div>
        
        <div class="hotel-details">
            <h2>Details</h2>
            <p>Amenities, services, and other important details about the hotel.</p>
        </div>
        
        <div class="price-list">
            <h2>Room Prices</h2>
            <ul>
                <li>Standard Room - $100</li>
                <li>Deluxe Room - $150</li>
                <li>Suite - $250</li>
            </ul>
        </div>
        
        <div class="suggested-hotels">
            <div class="hotel-card">
                <h3>Suggested Hotel (Same Area)</h3>
                <p>Details about another hotel nearby.</p>
            </div>
            <div class="hotel-card">
                <h3>Suggested Hotel (Same Price Range)</h3>
                <p>Details about another hotel in a similar price range.</p>
            </div>
        </div>
    </div>
</body>
</html>
