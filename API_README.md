# Hotel API Documentation

This Laravel application provides a RESTful API for hotel management that can be consumed by other applications.

## API Endpoints

All endpoints are prefixed with `/api` and do not require authentication (open routes).

### 1. Get All Hotels
```
GET /api/hotels
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Grand Plaza Hotel",
            "description": "Luxury 5-star hotel in the heart of the city",
            "address": "123 Main Street",
            "city": "New York",
            "country": "USA",
            "phone": "+1-555-0123",
            "email": "info@grandplaza.com",
            "website": "https://grandplaza.com",
            "stars": 5,
            "amenities": ["WiFi", "Pool", "Spa", "Restaurant", "Gym"],
            "images": ["hotel1.jpg", "hotel2.jpg"],
            "is_active": true,
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 2. Get Specific Hotel
```
GET /api/hotels/{id}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Grand Plaza Hotel",
        "description": "Luxury 5-star hotel in the heart of the city",
        "address": "123 Main Street",
        "city": "New York",
        "country": "USA",
        "phone": "+1-555-0123",
        "email": "info@grandplaza.com",
        "website": "https://grandplaza.com",
        "stars": 5,
        "amenities": ["WiFi", "Pool", "Spa", "Restaurant", "Gym"],
        "images": ["hotel1.jpg", "hotel2.jpg"],
        "is_active": true,
        "rooms": [...],
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### 3. Get Hotel Rooms
```
GET /api/hotels/{hotelId}/rooms
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "hotel_id": 1,
            "name": "Standard Room 1",
            "description": "Comfortable Standard room with modern amenities",
            "type": "Standard",
            "capacity": 2,
            "price_per_night": "150.00",
            "amenities": ["WiFi", "TV", "Air Conditioning", "Private Bathroom"],
            "images": ["room1.jpg", "room2.jpg"],
            "is_available": true,
            "room_number": "1100",
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 4. Get Available Rooms
```
GET /api/hotels/{hotelId}/available-rooms?check_in=2025-02-01&check_out=2025-02-03
```

**Parameters:**
- `check_in`: Check-in date (YYYY-MM-DD)
- `check_out`: Check-out date (YYYY-MM-DD)

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "hotel_id": 1,
            "name": "Standard Room 1",
            "description": "Comfortable Standard room with modern amenities",
            "type": "Standard",
            "capacity": 2,
            "price_per_night": "150.00",
            "amenities": ["WiFi", "TV", "Air Conditioning", "Private Bathroom"],
            "images": ["room1.jpg", "room2.jpg"],
            "is_available": true,
            "room_number": "1100",
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 5. Search Hotels
```
GET /api/hotels/search?q=search_term
```

**Parameters:**
- `q`: Search query (minimum 2 characters)

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Grand Plaza Hotel",
            "description": "Luxury 5-star hotel in the heart of the city",
            "address": "123 Main Street",
            "city": "New York",
            "country": "USA",
            "phone": "+1-555-0123",
            "email": "info@grandplaza.com",
            "website": "https://grandplaza.com",
            "stars": 5,
            "amenities": ["WiFi", "Pool", "Spa", "Restaurant", "Gym"],
            "images": ["hotel1.jpg", "hotel2.jpg"],
            "is_active": true,
            "rooms": [...],
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z"
        }
    ]
}
```

## Setup Instructions

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start the Server:**
   ```bash
   php artisan serve --port=8002
   ```

## Testing

Run the tests to verify API functionality:
```bash
php artisan test
```

## Database Schema

### Hotels Table
- `id` - Primary key
- `name` - Hotel name
- `description` - Hotel description
- `address` - Hotel address
- `city` - City
- `country` - Country
- `phone` - Contact phone
- `email` - Contact email
- `website` - Hotel website
- `stars` - Hotel rating (1-5)
- `amenities` - JSON array of amenities
- `images` - JSON array of image URLs
- `is_active` - Hotel availability status
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Rooms Table
- `id` - Primary key
- `hotel_id` - Foreign key to hotels table
- `name` - Room name
- `description` - Room description
- `type` - Room type (Standard, Deluxe, Suite, Executive)
- `capacity` - Maximum number of guests
- `price_per_night` - Price per night
- `amenities` - JSON array of room amenities
- `images` - JSON array of room image URLs
- `is_available` - Room availability status
- `room_number` - Unique room number
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Notes

- All API endpoints are open (no authentication required)
- The API runs on port 8002 by default
- Sample data is seeded automatically
- All responses follow a consistent format with `success` and `data` fields
- Error responses include appropriate HTTP status codes and error messages
