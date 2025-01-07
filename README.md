# IoT-based Attendance System with QR Code, NodeMCU ESP8266, and MQTT

This project demonstrates an **Internet of Things (IoT)**-based **attendance system** using **QR codes** for authentication, **NodeMCU ESP8266** for device control, and **MQTT** for communication. The system allows users to scan a QR code on an IoT device to mark their attendance. The data is stored in a MySQL database, and the system uses a simple web interface to manage and view the attendance data.

## Features

- **QR Code Generation**: Generates unique QR codes for each user for attendance.
- **IoT Integration**: Uses NodeMCU ESP8266 to control the attendance process.
- **MQTT Protocol**: MQTT is used to send attendance data to a server for processing.
- **Web Interface**: Simple web interface for users to log in, check attendance, and interact with the system.
- **MySQL Database**: Stores user credentials and attendance logs in a MySQL database.

## Components

### Hardware

- **NodeMCU ESP8266**: Used for handling the IoT device logic.
- **TFT LCD ST7735 1.77 inches**: Displays QR codes on the device.
- **MQTT Broker**: Communication between the IoT device and the server.
- **QR Code Scanner**: Scans QR codes for attendance.

### Software

- **PHP**: Used for server-side scripting to handle attendance data and web interactions.
- **MySQL**: Database management system to store users' credentials and attendance records.
- **MQTT Client**: Used for publishing attendance data to the server.
- **HTML5**: Front-end for the web interface.
- **CSS**: Styling for the web interface (using Tailwind CSS framework).

## Setup

### Prerequisites

- PHP 7.0 or higher
- MySQL
- Node.js (for managing MQTT communication)
- MQTT broker (e.g., Mosquitto)
- A web server (e.g., Apache or Nginx)
- **NodeMCU ESP8266** with Arduino IDE

### Installation Steps

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/Zkys4nn/IOT.git
   cd IOT
2. **Install Dependencies**:
   ```bash
   composer require php-mqtt/client

3. **Configuration Database**:
   ```bash
   CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
    );

    CREATE TABLE absen (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      nama VARCHAR(100),
      absensi VARCHAR(50),
      timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE tokens (
      id INT AUTO_INCREMENT PRIMARY KEY,
      token VARCHAR(255) NOT NULL
    );

4. Set up NodeMCU ESP8266:

    Use the Arduino IDE to upload the code to the NodeMCU.
    Install necessary libraries like Adafruit_GFX and Adafruit_ILI9341 for TFT LCD support.
    Configure the MQTT client in your NodeMCU code to connect to your MQTT broker and listen for attendance data.
    Start the MQTT Broker:

    Install and run an MQTT broker (e.g., Mosquitto) to handle communication between the IoT device and the server.
    Start the Web Server:

    If using Apache, configure httpd.conf or vhost for the project folder.
    Start the server and access the web application in your browser.
    Access the System:

    Open the index.php in your browser to log in.
    Use the QR code scanner to mark attendance.
    View attendance data on the view.php page.
   
    How It Works:
   
    QR Code Generation: When a user logs into the system, a unique QR code is generated using a random string and saved to the database.
    NodeMCU ESP8266: Displays the generated QR code on the TFT LCD, and waits for the user to scan it.
    MQTT Communication: When a QR code is scanned, the attendance data is sent via MQTT to the server for processing.
    PHP Backend: The PHP backend validates the QR code, records the attendance in the database, and updates the attendance logs.
    Web Interface: Users can log in to check their attendance history.
