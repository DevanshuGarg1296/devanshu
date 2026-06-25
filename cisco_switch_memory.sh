#!/bin/bash
 
HOST="$1"
COMMUNITY="$2"
 
FREE=$(snmpget -v2c -c "$COMMUNITY" -Ovq "$HOST" .1.3.6.1.4.1.9.9.109.1.1.1.1.13.1 2>/dev/null)
USED=$(snmpget -v2c -c "$COMMUNITY" -Ovq "$HOST" .1.3.6.1.4.1.9.9.109.1.1.1.1.12.1 2>/dev/null)
 
echo "free:$FREE used:$USED"
