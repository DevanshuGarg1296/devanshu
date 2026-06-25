#!/bin/bash

HOST="$1"
COMMUNITY="$2"

OID=".1.3.6.1.4.1.9.9.109.1.1.1.1.8.1"

VALUE=$(snmpget -v2c -c "$COMMUNITY" -Ovq "$HOST" "$OID" 2>/dev/null)

echo "$VALUE"
