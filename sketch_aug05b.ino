/******************************
  house-automation
  code for turning on the ac from the arduino board by sending
  codes by an infrared led using the IRemote library
 ********************************/
#include <IRremote.h>
IRrecv irrecv(11); // Receive on pin 11
IRsend irsend;
int incomingByte = 0;

void setup()
{
    Serial.begin(9600);
    irrecv.enableIRIn(); // Start the receiver
}
/* 
   Kowing that the temperature can range from 60 to 90 (30 degrees difference)
   we can implement a simple setTemperature function that just goes down 30 times
   and then goes up enough times to set the temperature you wanted, starting from 60
 */
void setTemp(int temp)
{
    int range=30;
    temp=temp-60;
    for(int i=0; i<range; i++)
    {
        //Temperature Down
        irsend.sendNEC(0x10AFB04F, 32);
        delay(300);
    } 
    // we should be at 60 now
    // Go up to the specified temperature
    for(int i=0; i<temp; i++)
    {
        irsend.sendNEC(0x10AF708F, 32);
        delay(300);
    }
}
void loop() {
    /**
      Using the USB interface serial, we accept bytes
      and compare them to what we want.
      And then use the irsend library to send a specific code
     **/  
    if (Serial.available() > 0) {
        // read the incoming byte:
        incomingByte = Serial.read();
        switch (incomingByte) {
            /*
               LG
             */
            case 49:
                // Power
                irsend.sendNEC(0x19F69867, 32);
                break;
            case 50:
                // Temperature UP
                irsend.sendNEC(0x19F6A05F, 32);
                break;
            case 51:
                // Temperature DOWN
                irsend.sendNEC(0x19F6906F, 32);
                break;
                /*
                   Kenmore
                 */
            case 52:
                // Power

                irsend.sendNEC(0x10AF8877, 32);
                break;
            case 53:
                // Temperature UP

                irsend.sendNEC(0x10AF708F, 32);
                break;
            case 54:
                // Temperature Down
                irsend.sendNEC(0x10AFB04F, 32);
                break;

        }

        // Echo back  what you got:
        // See it on the serial manager, or cat your ttyl
        Serial.print("I received: ");
        Serial.println(incomingByte, DEC);
    }

}

