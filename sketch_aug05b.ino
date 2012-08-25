#include <IRremote.h>
IRrecv irrecv(11); // Receive on pin 11
decode_results results;
IRsend irsend;
int incomingByte = 0;

void setup()
{
  Serial.begin(9600);
  irrecv.enableIRIn(); // Start the receiver
}
void setTemp(int temp)
{
  int range=30;
  temp=temp-60;
  for(int i=0; i<range; i++)
 {
    //Temperature Down Down
    irsend.sendNEC(0x10AFB04F, 32);
    delay(300);
 } 
 for(int i=0; i<temp; i++)
 {
   irsend.sendNEC(0x10AF708F, 32);
    delay(300);
 }
}
void loop() {
  
 if (irrecv.decode(&results)) {
   /* Serial.println(results.decode_type); 
   
     Serial.println(results.value, HEX);
    Serial.println(results.bits);
    */
    irrecv.resume(); // Continue receiving
  }
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

                // say what you got:
                Serial.print("I received: ");
                Serial.println(incomingByte, DEC);
        }
  
}

