#include <ESP8266WiFi.h>                    // Library untuk koneksi WiFi pada ESP8266
#include <PubSubClient.h>                   // Library untuk komunikasi MQTT
#include <Adafruit_GFX.h>                   // Library dasar untuk layar TFT
#include <Adafruit_ST7735.h>                // Library untuk tampilan TFT berbasis ST7735
#include <qrcode.h>                         // Library untuk menghasilkan QR Code

// Konfigurasi WiFi
const char* ssid = "qq";            // Nama SSID jaringan WiFi
const char* password = "88888888";         // Password jaringan WiFi

// Konfigurasi MQTT
const char* mqtt_server = "192.168.43.104";  // IP address broker MQTT
const int mqttPort = 1884;                  // Port untuk MQTT (1884 adalah port yang tidak standar, biasanya 1883)
const char* mqtt_topic = "esp/topic";       // Topik MQTT yang digunakan untuk berlangganan

// Objek untuk koneksi WiFi dan MQTT
WiFiClient espClient;                       // Objek untuk koneksi WiFi
PubSubClient client(espClient);             // Objek untuk koneksi MQTT

// Definisi pin untuk layar TFT
#define TFT_CS    4                         // Pin Chip Select TFT
#define TFT_RST   16                        // Pin Reset TFT
#define TFT_DC    5                         // Pin Data/Command TFT

// Inisialisasi objek layar TFT
Adafruit_ST7735 tft = Adafruit_ST7735(TFT_CS, TFT_DC, TFT_RST);

// Fungsi untuk menghubungkan ESP8266 ke WiFi
void setup_wifi() {
  Serial.begin(115200);                     // Inisialisasi komunikasi serial dengan baud rate 115200
  delay(10);

  WiFi.begin(ssid, password);               // Memulai koneksi ke WiFi dengan SSID dan password yang diberikan
  while (WiFi.status() != WL_CONNECTED) {   // Loop hingga ESP8266 terhubung ke WiFi
    delay(500);                             // Tunggu setengah detik
  }
}

// Fungsi untuk melakukan koneksi ke broker MQTT
void reconnect() {
  while (!client.connected()) {             // Selama tidak terhubung ke broker MQTT

    // Coba untuk terhubung dengan client ID "NodeMCU_Client"
    if (client.connect("NodeMCU_Client")) {
      client.subscribe(mqtt_topic);         // Langganan topik MQTT
    } else {
      // Jika gagal terhubung, tampilkan kode kesalahan dan coba lagi dalam 5 detik
      Serial.print(client.state());
      delay(5000);                          // Tunggu 5 detik sebelum mencoba lagi
    }
  }
}

// Callback fungsi yang akan dipanggil ketika pesan diterima dari broker MQTT
void callback(char* topic, byte* payload, unsigned int length) {
  String message = "";

  // Mengonversi payload byte array menjadi string
  for (unsigned int i = 0; i < length; i++) {
    message += (char)payload[i];
  }

  // Menampilkan QR code pada layar TFT
  tft.fillScreen(ST7735_WHITE);             // Mengisi layar dengan warna putih
  tft.setTextColor(ST7735_BLACK);           // Set warna teks menjadi hitam
  tft.setTextSize(1);                       // Ukuran teks kecil
  tft.setCursor(0, 0);                      // Set posisi kursor pada koordinat (0, 0)

  // Membuat QR Code dari pesan mqtt yang diterima
  QRCode qrcode;
  uint8_t qrcodeData[qrcode_getBufferSize(2)];                  // Buffer untuk menyimpan data QR
  qrcode_initText(&qrcode, qrcodeData, 2, 0, message.c_str());  // Inisialisasi QR Code dengan pesan

  // Ukuran setiap modul QR Code
  const int size = 4;
  const int qrCodeSize = qrcode.size * size;                    // Ukuran QR code dalam piksel

  // Menghitung posisi offset agar QR code berada di tengah layar
  const int xOffset = (tft.width() - qrCodeSize) / 2;
  const int yOffset = (tft.height() - qrCodeSize) / 2;

  // Menampilkan QR code pada layar TFT
  for (int y = 0; y < qrcode.size; y++) {           // Loop untuk baris QR Code
    for (int x = 0; x < qrcode.size; x++) {         // Loop untuk kolom QR Code
      if (qrcode_getModule(&qrcode, x, y)) {        // Jika modul QR Code pada posisi (x, y) adalah 1
        tft.fillRect(x * size + xOffset, y * size + yOffset, size, size, ST7735_BLACK);     // Gambar kotak hitam
      }
    }
  }
}

void setup() {
  setup_wifi();  // Panggil fungsi untuk koneksi WiFi
  client.setServer(mqtt_server, mqttPort);          // Set server MQTT
  client.setCallback(callback);                     // Set callback function untuk menerima pesan MQTT

  // Inisialisasi TFT display
  tft.initR(INITR_BLACKTAB);                        // Inisialisasi TFT dengan pengaturan default
  tft.setRotation(3);                               // Set orientasi layar TFT
  tft.fillScreen(ST7735_WHITE);                     // Mengisi layar dengan warna putih
}

void loop() {
  if (!client.connected()) {    // Jika client MQTT tidak terhubung
    reconnect();                // Coba untuk terhubung ke broker MQTT
  }
  client.loop();                // Loop untuk menjalankan client MQTT, untuk mendengarkan pesan
}
