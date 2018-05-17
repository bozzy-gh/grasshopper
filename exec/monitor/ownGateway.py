#!/usr/bin/python


# << ownGateway v.1.0>>
# Hashed password calculator for BTicino gateways


#   M O D U L E S  #

import ConfigParser
import socket


#   V A R I A B L E S   #

# Acknowledge
ACK='*#*1##'
# Monitor session
MONITOR='*99*1##'
# Commands session
COMMANDS='*99*0##'


#   F U N C T I O N S   #

def Connect(gwMode, first_time = True):
    # Read config from ownGateway.conf
    config = ConfigParser.RawConfigParser()
    config.read('/var/www/exec/ownGateway.conf')
    gwHost = config.get('GATEWAY', 'HOST');
    gwPort = int(config.get('GATEWAY', 'PORT'));
    gwPassword = config.get('GATEWAY', 'PASSWORD');
    # Connect to gateway
    can_return = first_time
    if not first_time:
        pass
        #print 'Start reconnect loop...'
        #WriteLog('Start reconnect loop...')
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    while 1:
        try:
            sock.connect((gwHost, gwPort))
            # Check the gateway answer
            if sock.recv(1024) != ACK:
                raise Exception('Did not receive expected ACK (1)!')
            # It's OK, open CMD or MON mode
            sock.send(gwMode)
            # If password is present, execute 'nonce-hash' authentication
            if gwPassword != '':
                # Receive 'Nonce' from gateway
                Nonce = sock.recv(1024)
                # Calculate hashed pwd
                hpwd = '*#' + str(CalcPass(gwPassword, Nonce)) + '##'
                # Send hashed pwd
                sock.send(hpwd)
                # Check the gateway answer
                if sock.recv(1024) != ACK:
                    raise Exception('Did not receive expected ACK (2)!')
            can_return = True
        except socket.error as e:
            #print 'Socket exception raised: n.{0}: {1}'.format(e.errno, e.strerror)
            #WriteLog('Socket exception raised: n.{0}: {1}'.format(e.errno, e.strerror))
            sock.close()
            if first_time:
                sock = None
        except Exception as e:
            #print 'Unexpected exception raised: {0}'.format(e.message)
            #WriteLog('Unexpected exception raised: {0}'.format(e.message))
            sock.close()
            if first_time:
                sock = None
        if can_return:
            if not first_time:
                pass
                #print 'Gateway connection restored!'
                #WriteLog('Gateway connection restored!')
            return sock
        time.sleep(1)


def CalcPass(password, nonce):
    m_1 = 0xFFFFFFFFL
    m_8 = 0xFFFFFFF8L
    m_16 = 0xFFFFFFF0L
    m_128 = 0xFFFFFF80L
    m_16777216 = 0XFF000000L
    flag = True
    num1 = 0L
    num2 = 0L
    password = long(password)
 
    for c in nonce:
        num1 = num1 & m_1
        num2 = num2 & m_1
        if c == '1':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 & m_128
            num1 = num1 >> 7
            num2 = num2 << 25
            num1 = num1 + num2
            flag = False
        elif c == '2':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 & m_16
            num1 = num1 >> 4
            num2 = num2 << 28
            num1 = num1 + num2
            flag = False
        elif c == '3':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 & m_8
            num1 = num1 >> 3
            num2 = num2 << 29
            num1 = num1 + num2
            flag = False
        elif c == '4':
            length = not flag
 
            if not length:
                num2 = password
            num1 = num2 << 1
            num2 = num2 >> 31
            num1 = num1 + num2
            flag = False
        elif c == '5':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 << 5
            num2 = num2 >> 27
            num1 = num1 + num2
            flag = False
        elif c == '6':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 << 12
            num2 = num2 >> 20
            num1 = num1 + num2
            flag = False
        elif c == '7':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 & 0xFF00L
            num1 = num1 + (( num2 & 0xFFL ) << 24 )
            num1 = num1 + (( num2 & 0xFF0000L ) >> 16 )
            num2 = ( num2 & m_16777216 ) >> 8
            num1 = num1 + num2
            flag = False
        elif c == '8':
            length = not flag
            if not length:
                num2 = password
            num1 = num2 & 0xFFFFL
            num1 = num1 << 16
            num1 = num1 + ( num2 >> 24 )
            num2 = num2 & 0xFF0000L
            num2 = num2 >> 8
            num1 = num1 + num2
            flag = False
        elif c == '9':
            length = not flag
            if not length:
                num2 = password
            num1 = ~num2
            flag = False
        else:
            num1 = num2
        num2 = num1
    return num1 & m_1


def Disconnect(sock):
    # Disconnect from Gateway
    sock.close()


def RecData(sock):
    # Read data from Gateway
    return sock.recv(1024)


def SendData(sock, cmdopen):
    # Send data to Gateway
    sock.send(cmdopen)
