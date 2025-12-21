# 🚆 RailBooker - Railway Reservation System

**RailBooker** is a web-based Railway Reservation System that allows users to view train information, book tickets, and manage their profiles. The system also includes an admin interface to manage train listings.

🔗 **Live Site**: [http://railbooker.devbyabhishek.infinityfreeapp.com/](http://railbooker.devbyabhishek.infinityfreeapp.com/)  
📂 **GitHub Repository**: [https://github.com/Abhishek-soni6904/RailBooker-RTS](https://github.com/Abhishek-soni6904/RailBooker-RTS)  
🗝️ **Admin Credentials**: ```gmail: admin@gmail.com password: 123```

---

## ✨ Features

- 🔐 **User Authentication** – Secure login and logout
- 🚄 **Train Listings** – Browse all available trains
- 📄 **Train Details** – Detailed view of each train
- 🎟️ **Ticket Booking** – Reserve seats for trains
- 👤 **User Profile** – Manage personal details
- 🛠️ **Admin Panel** – Add or manage train data

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: Apache (via XAMPP/WAMP)

---

## 🧑‍💻 Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Abhishek-soni6904/RailBooker-RTS
   cd RailBooker-RTS
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
   - Open `http://localhost/RailBooker-RTS` in your browser

---

## 🚀 Usage

- Browse trains from the homepage
- Log in to view profile or book tickets
- View train details by clicking on a train
- Use the ticket form to make bookings
- Admin can add new trains via the admin page

---

## 📸 Screenshots

**Homepage**  
![Homepage](assets/screenshots/home.png)

**Train Listings Page**  
![Train Listings](assets/screenshots/trains.png)

**Train Details Page**  
![Train Details](assets/screenshots/TrainDetails.png)

**Ticket Booking Page**  
![Ticket Booking](assets/screenshots/Tickets.png)

**User Profile Page**  
![User Profile](assets/screenshots/Profile.png)

**Admin Panel – Add New Train**  
![Admin Panel](assets/screenshots/addNewTrain.png)

---

## 📁 Project Structure

```
.
├── index.php              # Homepage
├── login.php              # User login
├── logout.php             # Logout script
├── profile.php            # User profile
├── tickets.php            # Book tickets
├── train-details.php      # Train details
├── trains.php             # Train listings
├── add_train.php          # Admin: Add train
├── railway.sql            # Database schema
│
├── assets/                # Static images
├── css/                   # Stylesheets
├── script/                # JavaScript files
├── include/               # PHP logic, components
│   ├── db.php             # DB connection
│   ├── nav.php, footer.php
│   └── *_*.php            # Logic handlers
```

---

## Contact📩

For any queries or support, feel free to reach out:

- **👤 Name**: Abhishek Soni
- **📧 Email**: abhisheks6904@gmail.com
- **🔗 GitHub**: [Abhishek-soni6904](https://github.com/Abhishek-soni6904)
- **📸 Instagram**: [Instagram Profile](https://www.instagram.com/_abhishek._.soni_/)
- **💼 LinkedIn**: [LinkedIn Profile](https://www.linkedin.com/in/abhishek-soni-662028331/)
