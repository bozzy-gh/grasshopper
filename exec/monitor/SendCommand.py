#! /usr/bin/python


# << SimpleSendCommand v.1.0 >>
# Send command to MyHOME BUS


#   M O D U L E S  #

import sys
import ownGateway


#   F U N C T I O N S   #

if __name__=='__main__':
    # Connect to gateway in COMMAND mode.
    scmd = ownGateway.Connect(ownGateway.COMMANDS)
    if scmd is None:
        raise Exception('Unable to connect to gateway!')
    try:
        ownGateway.SendData(scmd, sys.argv[1])
    finally:
        ownGateway.Disconnect(scmd)
        sys.exit()
