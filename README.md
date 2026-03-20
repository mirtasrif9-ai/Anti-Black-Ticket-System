# Anti Black Ticket System
A ticket booking system where there is no chance for ticket blackers
## Video
https://github.com/user-attachments/assets/53886481-a377-4b2f-ada1-ec9b2c941001

## WorkFlow
<img width="1101" height="1766" alt="Image" src="https://github.com/user-attachments/assets/824b7f93-7838-4baa-93c2-c4678c9cf5cb" />

## Features

-  **User Authentication Using NID** – Secure login and logout
-  **Train Listings** – Browse all available trains
-  **Train Details** – Detailed view of each train
-  **Ticket Booking** – Reserve seats for trains
-  **Payment** – Pay ticket bill using STRIPE
-  **User Profile** – Manage personal details
-  **Admin Panel** – Add or manage train data
-  **QR Code** – Tap to show your Ticket Dynamically
-  Frontend inspired from Abishek Soni


## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/mirtasrif9-ai/Anti-Black-Ticket-System
   cd Anti-Black-Ticket-System
   ```

2. **Import the Database**

   - Open phpMyAdmin
   - Create a database named `railway`
   - Import `railway.sql`

3. **Configure DB Connection**  
   Edit `include/db.php`:

   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "railway";
   ```

4. **Unzip Stripe:**  
   Extract stripe-php.zip located in Anti Black Ticket System/vendor/stripe


5. **Run Locally**
   - Place the folder in your server directory (e.g., `htdocs`)
   - Start Apache & MySQL using XAMPP/WAMP
   - Open `http://localhost/Anti%20Black%20Ticket%20System` in your browser

---

🗝️ **Admin Credentials**: ```gmail: admin@gmail.com password: 123```

## Contact📩

- ** Name**: Mir Tasrif Ahmed
- ** Email**: mir.tasrif.cse@gmail.com
- ** LinkedIn**: [LinkedIn Profile](https://www.linkedin.com/in/mir-tasrif-91b0252a4/)


