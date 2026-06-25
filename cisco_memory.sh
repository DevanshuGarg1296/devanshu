#!/bin/bash
 
HOST="$1"
COMMUNITY="$2"
 
FREE=$(snmpget -v2c -c "$COMMUNITY" -Ovq "$HOST" .1.3.6.1.4.1.9.9.48.1.1.1.6.1 2>/dev/null)
BUFFER=$(snmpget -v2c -c "$COMMUNITY" -Ovq "$HOST" .1.3.6.1.4.1.9.9.48.1.1.1.6.2 2>/dev/null)
 
echo "free:$FREE buffer:$BUFFER"
