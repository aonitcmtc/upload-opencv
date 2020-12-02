import cv2
import urllib.request

cap = cv2.VideoCapture('http://192.168.13.106:30002/videostream.cgi?rate=0&user=admin&pwd=888888')

defult = 'http://192.168.13.106:30002/decoder_control.cgi?loginuse=admin&loginpas=888888&command=25&onestep=0'
up = 'http://192.168.13.106:30002/decoder_control.cgi?loginuse=admin&loginpas=888888&command=0'
down = 'http://192.168.13.106:30002/decoder_control.cgi?loginuse=admin&loginpas=888888&command=2'
left = 'http://192.168.13.106:30002/decoder_control.cgi?loginuse=admin&loginpas=888888&command=4'
right = 'http://192.168.13.106:30002/decoder_control.cgi?loginuse=admin&loginpas=888888&command=6'


while(True):
    # Capture frame-by-frame
    ret, frame = cap.read()

    cv2.imshow('frame',frame)
    key = cv2.waitKey(1) & 0xFF

    if key == ord('w'):
        for x in range(80):
          urllib.request.urlopen(up+'&onestep=0') # up
          if x >= 79 :
             urllib.request.urlopen(up+'&onestep=1') # up stop

    if key == ord('s'):
        for x in range(80):
          urllib.request.urlopen(down+'&onestep=0') # down
          if x >= 79 :
             urllib.request.urlopen(down+'&onestep=1') # down stop

    if key == ord('a'):
        for x in range(80):
          urllib.request.urlopen(left+'&onestep=0') # left
          if x >= 79 :
             urllib.request.urlopen(left+'&onestep=1') # left stop

    if key == ord('d'):
        for x in range(80):
          urllib.request.urlopen(right+'&onestep=0') # right
          if x >= 79 :
             urllib.request.urlopen(right+'&onestep=1') # right stop

    if key == ord('r'):
        urllib.request.urlopen(defult) # rotation


    if key == ord('q'): #key exit()
        break

# When everything done, release the capture
cap.release()
cv2.destroyAllWindows()
