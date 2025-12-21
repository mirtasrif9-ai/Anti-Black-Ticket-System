# Anti-Black-Ticket-System
A ticket booking system where there is no chance for ticket blackers
## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: Apache (via XAMPP/WAMP)

## ✨ Features

-  **User Authentication Using NID** – Secure login and logout
-  **Train Listings** – Browse all available trains
-  **Train Details** – Detailed view of each train
-  **Ticket Booking** – Reserve seats for trains
-  **Payment** – Pay ticket bill using STRIPE
-  **User Profile** – Manage personal details
-  **Admin Panel** – Add or manage train data
-  **QR Code** – Tap to show your Ticket Dynamically


## 🧑‍💻 Installation

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

4. **Run Locally**
   - Place the folder in your server directory (e.g., `htdocs`)
   - Start Apache & MySQL using XAMPP/WAMP
   - Open `http://localhost/Anti Black Ticket System` in your browser

---
