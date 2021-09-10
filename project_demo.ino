#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include "DHT.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
WiFiServer server(1234);
LiquidCrystal_I2C lcd(0x27,16,2);

float  temperature;
float  humidity;
char  per;
int  light;
long i;
DHT dht14(14,DHT11);

WiFiClient client;
String thingSpeakAddress= "http://api.thingspeak.com/update?";
String writeAPIKey;
String tsfield1Name;
String request_string;

HTTPClient http;

byte termometru[8] = //icon for termometer
{
    B00100,
    B01010,
    B01010,
    B01110,
    B01110,
    B11111,
    B11111,
    B01110
};

byte picatura[8] = //icon for water droplet
{
    B00100,
    B00100,
    B01010,
    B01010,
    B10001,
    B10001,
    B10001,
    B01110,
};

void init_wifi() {
   WiFi.begin("Noo","26072563");
  do {
    Serial.print(".");
    delay(500);
  } while ((!(WiFi.status() == WL_CONNECTED)));Serial.println("WiFi Connected");
  Serial.print("IP address: ");
  Serial.println((WiFi.localIP().toString()));
}

void light2() {
  light = analogRead(A0);
  lcd.setCursor(0, 0);
  lcd.print("Value: ");
  lcd.print(light);
  lcd.setCursor(0, 1);
  lcd.print("State: ");
  if (light >= 800) {
    lcd.print("dark");
    delay(4000);

  } else if (light <= 400) {
    lcd.print("bright");
    delay(4000);
  } else {
    lcd.print("moderate");
    delay(4000);
  }
}

void setup()
{
  Serial.begin(9600);
  init_wifi();
  temperature = 0;
  humidity = 0;
  i = 0;
  light = 0;
  per = 223;
  pinMode(2, OUTPUT);
  digitalWrite(2, HIGH);
  
  lcd.begin();
  lcd.createChar(0,termometru);
  lcd.createChar(1,picatura);
  lcd.home();

  dht14.begin();
}

void loop()
{
    lcd.setCursor(0, 0);
    lcd.write(0);
    lcd.print(" Temp: ");
    lcd.print(temperature);
    lcd.print(" ");
    lcd.print(per);
    lcd.print("C");

    Serial.print(" Temp:");
    Serial.print(temperature);

    lcd.setCursor(0, 1);
    lcd.write(1);
    lcd.print(" Hum:  ");
    lcd.print(humidity);
    lcd.print(" %");

    Serial.print(" Hum:");
    Serial.println(humidity);
    
    delay(4000);
    lcd.clear();
    light2();
    lcd.clear();

    light = analogRead(A0);
    Serial.print(" Value = ");
    Serial.print(light);
    if (light >= 800) {
      i = 0; //dark
      Serial.print(" Status:");
      Serial.println(i);

    } else {
      i = 1; //light
      Serial.print(" Status:");
      Serial.println(i);

    }
    
    humidity = (dht14.readHumidity());
    temperature = (dht14.readTemperature( ));
    if (client.connect("api.thingspeak.com",80)) {
      request_string = thingSpeakAddress;
      request_string += "key=";
      request_string += "18BSMONORNUHVADE";
      request_string += "&field1=";
      request_string += humidity;
      request_string += "&field2=";
      request_string += temperature;
      request_string += "&field3=";
      request_string += light;
      request_string += "&field4=";
      request_string += i;
      
      http.begin(client,request_string);
      http.GET();
      http.end();
      request_string="";

    }
    
}
