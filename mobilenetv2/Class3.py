import urllib.request
import requests
import cv2
import io
import time
from PIL import Image

model = cv2.dnn.readNetFromTensorflow('ssd_mobilenet_v2/frozen_inference_graph.pb', 'ssd_mobilenet_v2/ssd_mobilenet_v2.pbtxt')
cap1 = cv2.VideoCapture('http://192.168.13.111:30001/videostream.cgi?rate=0&user=admin&pwd=605232060')
cap2 = cv2.VideoCapture('http://192.168.13.112:30002/videostream.cgi?rate=0&user=admin&pwd=605232060')

#hz60 = 'http://192.168.13.111:30001/camera_control.cgi?loginuse=admin&loginpas=605232060&param=3&value=1'
fps30 = 'http://192.168.13.111:30001/camera_control.cgi?loginuse=admin&loginpas=605232060param=12&value=30'
fps31 = 'http://192.168.13.112:30002/camera_control.cgi?loginuse=admin&loginpas=605232060param=12&value=30'
urllib.request.urlopen(fps30)
urllib.request.urlopen(fps31) #

#URL Control webcam
defult = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=25&onestep=0'
up = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=0'
down = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=2'
left = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=4'
right = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=6'

#Line setup
url = 'https://notify-api.line.me/api/notify'
token = 'WeJw2Wxa33ry6nS87oucx1CkJPZokIe9D6UjgvVWTzh'
headers = {'Authorization':'Bearer '+token}


#label calss mobilenetV2
COCO_labels = { 0: 'background',
    1: 'person', 2: 'bicycle', 3: 'car', 4: 'motorcycle',
    5: 'airplane', 6: 'bus', 7: 'train', 8: 'truck', 9: 'boat',
    10: 'traffic light', 11: 'fire hydrant', 13: 'stop sign', 14: 'parking meter',
    15: 'zebra', 16: 'bird', 17: 'cat', 18: 'dog',19: 'horse',20: 'sheep',21: 'cow',22: 'elephant',
    23: 'bear', 24: 'zebra', 25: 'giraffe', 27: 'backpack', 28: 'umbrella',
    31: 'handbag', 32: 'tie', 33: 'suitcase', 34: 'frisbee', 35: 'skis',
    36: 'snowboard', 37: 'sports ball', 38: 'kite', 39: 'baseball bat', 40: 'baseball glove',
    41: 'skateboard', 42: 'surfboard', 43: 'tennis racket', 44: 'bottle', 
    46: 'wine glass', 47: 'cup', 48: 'fork', 49: 'knife', 50: 'spoon', 51: 'bowl', 52: 'banana',
    53: 'apple', 54: 'sandwich', 55: 'orange', 56: 'broccoli', 57: 'carrot', 58: 'hot dog', 59: 'pizza',
    60: 'donut', 61: 'cake', 62: 'chair', 63: 'couch', 64: 'potted plant', 65: 'bed', 
    67: 'dining table',70: 'toilet', 72: 'tv', 73: 'laptop',
    74: 'mouse', 75: 'remote', 76: 'keyboard', 78: 'microwave', 79: 'oven', 80: 'toaster', 81: 'sink',
    82: 'refrigerator',84: 'book', 85: 'clock', 86: 'vase', 87: 'scissors',
    88: 'teddy bear', 89: 'hair drier', 90: 'toothbrush' }


def getClassLabel(class_id, classes):
    for key,value in classes.items():
        if class_id == key:
            return value

#msg = 'Hello LINE Notify'
#r = requests.post(url, headers=headers, params={"message": msg}, files={"imageFile": data})

def sendimg(img,msg):
    f = io.BytesIO()
    Image.fromarray(img).save(f, 'png')
    data = f.getvalue()
    r = requests.post(url, headers=headers, params={"message": msg}, files={"imageFile": data})

def process(cam):
    if cam == 1 :
        ret, frame = cap1.read()
    elif cam == 2 :
        ret, frame = cap2.read()
    
    im_h, im_w, _ = frame.shape
    psnum = 0
    model.setInput(cv2.dnn.blobFromImage(frame, size=(300, 300), swapRB=True))
    output = model.forward()
    #Draw mask point person class
    for detection in output[0, 0, :, :]:
        confidence = detection[2]
        if confidence > .30:  #def .5
           class_id = detection[1]
           class_label = getClassLabel(class_id,COCO_labels)
           if class_id == 1.0: # 1.0 = 'person'
              psnum = psnum+1
              x=int(detection[3]*im_w)
              y=int(detection[4]*im_h)
              w=int(detection[5]*im_h/2)
              h=int(detection[6]*im_w/2)
              cv2.rectangle(frame, (x,y,w,h), (160, 200, 0), thickness=1)
              #cv2.putText(frame,class_label ,(x,y+25),cv2.FONT_HERSHEY_SIMPLEX,1,(255, 0, 255),1,cv2.LINE_AA)
              cv2.putText(frame,str(psnum) ,(x,y-5),cv2.FONT_HERSHEY_PLAIN,2,(180, 90, 255),1,cv2.LINE_AA)
              #print(str(str(class_id) + " " + class_label + " " + str(detection[2]) + "% " ))
              #print(str(class_id) + " " + class_label + " " + "%.2f" %(detection[2]*100) + "% " )
              #print("Detec[1] " + str(detection[1]) + " Detec[2] " + str(detection[2]))
    d = time.time()
    local_time = time.ctime(d)
    cv2.putText(frame,str("Date: " + str(local_time)) ,(20,20),cv2.FONT_HERSHEY_PLAIN,1,(10, 200, 250),1,cv2.LINE_4)
    cv2.putText(frame,str("person: " + str(psnum)) ,(20,40),cv2.FONT_HERSHEY_PLAIN,1,(10, 200, 250),1,cv2.LINE_4)
    print(" Person " + str(psnum))
    msgp = "Camera" + str(cam) + " Person : " + str(psnum)
    #print(msgp)
    sendimg(frame[:, :, ::-1],msgp)

#-------------------end process--------------------------------------
#-------------------Control Camera--------------------------------------
def Control_Camera(cam,view,step):
    frist = time.time()
    stop = time.time()
    delay = stop - frist
    print("delay: " + str("%.2f" %(delay)) )
    if cam == 1 : 
        if view == 0:
            urllib.request.urlopen('http://192.168.13.111:30001/' + defult) # rotation Webcam
        elif view == 1: # Camera left
            while delay < step : #delay
                stop = time.time()
                delay = stop - frist
                print("delay: " + str("%.2f" %(delay)) )
                if delay > 1.0 and delay < 2.0 :
                    urllib.request.urlopen('http://192.168.13.111:30001/' + left + '&onestep=0') # Camera left rotation
                elif delay > step  :
                    urllib.request.urlopen('http://192.168.13.111:30001/' + left + '&onestep=1') # Camera left stop
        elif view == 2: # Camera right
            while delay < step : #delay
                stop = time.time()
                delay = stop - frist
                print("delay: " + str("%.2f" %(delay)) )
                if delay > 1.0 and delay < 2.0 :
                    urllib.request.urlopen('http://192.168.13.111:30001/' + right + '&onestep=0') # Camera right rotation
                elif delay > step  :
                    urllib.request.urlopen('http://192.168.13.111:30001/' + right + '&onestep=1') # Camera right stop
        elif view == 3: # Camera right
            while delay < step : #delay
                stop = time.time()
                delay = stop - frist
                print("delay: " + str("%.2f" %(delay)) )
                if delay > 1.0 and delay < 2.0 :
                    urllib.request.urlopen('http://192.168.13.111:30001/' + down + '&onestep=0') # Camera right rotation
                elif delay > step  :
                    urllib.request.urlopen('http://192.168.13.111:30001/' + down + '&onestep=1') # Camera right stop

    if cam == 2 : 
        if view == 0:
            urllib.request.urlopen('http://192.168.13.112:30002/' + defult) # rotation Webcam
        elif view == 1: # Camera left
            while delay < step : #delay
                stop = time.time()
                delay = stop - frist
                print("delay: " + str("%.2f" %(delay)) )
                if delay > 1.0 and delay < 2.0 :
                    urllib.request.urlopen('http://192.168.13.112:30002/' + left + '&onestep=0') # Camera left rotation
                elif delay > step  :
                    urllib.request.urlopen('http://192.168.13.112:30002/' + left + '&onestep=1') # Camera left stop
        elif view == 2: # Camera right
            while delay < step : #delay
                stop = time.time()
                delay = stop - frist
                print("delay: " + str("%.2f" %(delay)) )
                if delay > 1.0 and delay < 2.0 :
                    urllib.request.urlopen('http://192.168.13.112:30002/' + right + '&onestep=0') # Camera right rotation
                elif delay > step  :
                    urllib.request.urlopen('http://192.168.13.112:30002/' + right + '&onestep=1') # Camera right stop
        elif view == 3: # Camera right
            while delay < step : #delay
                stop = time.time()
                delay = stop - frist
                print("delay: " + str("%.2f" %(delay)) )
                if delay > 1.0 and delay < 2.0 :
                    urllib.request.urlopen('http://192.168.13.112:30002/' + down + '&onestep=0') # Camera right rotation
                elif delay > step  :
                    urllib.request.urlopen('http://192.168.13.112:30002/' + down + '&onestep=1') # Camera right stop

#-------------------end Control Camera--------------------------------------

#________________ Frist Step __ Defalue Camera _____________________!!
start = time.time()
while(True) :
    t_stop = time.time()
    sec = t_stop - start
    print("Setup : " + str("%.2f" %(sec)) )

    if sec < 10.0 : #Camera1 name000        
        if sec >= 0.0 and sec < 0.5 : Control_Camera(cam=1,view=0,step=0) #rotation = view 1
        elif sec > 0.5 and sec < 1.0 : Control_Camera(cam=2,view=0,step=0) #rotation = view 2       
    elif sec > 17.0 and sec < 17.5 : Control_Camera(cam=1,view=3,step=3) # down = view 1
    elif sec > 20.0 and sec < 20.5 : Control_Camera(cam=2,view=3,step=3) # down = view 2

    elif sec >= 30.0 : break #process(2) #Send Photo



    
#________________ END Frist Step _______________________!!

now = time.time()
#local_time = time.ctime(start)
while(True):
    end = time.time()
    count = end - now
    #frame = cv2.resize(frame,(300,200),fx=0,fy=0, interpolation = cv2.INTER_CUBIC)
    
    if count < 5.0 : #Camera1 view 1      
        ret, frame = cap1.read()
        if count >= 1.0 and count <= 1.5 : process(1) #Send Photo cam 1
        elif count >= 4.5 : Control_Camera(1,1,3) # Left

    elif count >= 5.0 and count < 10.0 : #Camera1 view 2    
        ret, frame = cap1.read()
        if count >= 5.0 and count <= 6.5 : process(1) #Send Photo
        elif count >= 9.5 : Control_Camera(1,2,3) # Right

    elif count >= 10.0 and count < 15.0 : #Camera1 view 2    
        ret, frame = cap2.read()
        if count >= 10.0 and count <= 10.5 : process(2) #Send Photo
        elif count >= 14.5 : Control_Camera(2,1,3) # Right

    elif count >= 15.0 and count < 20.0 : #Camera1 view 2    
        ret, frame = cap2.read()
        if count >= 15.0 and count <= 15.5 : process(2) #Send Photo
        elif count >= 19.5 : Control_Camera(2,2,3) # Right
        
        
    
    elif count >= 10.0 : #Camera2 name002
        ret, frame = cap1.read()

    #elif count >= 75.0 and count < 88 : #Camera2 name002
        #ret, frame = cap2.read()
        #if count >= 80.0 and count <= 81.0 : Control_Camera(1,2) # right
        #elif count >= 85.0 and count <= 86.0 : process(2)    

    if count > 300.0 : #300 = 300 ms = 5 minus
        now = time.time()

    #count = count + 1
    #print("Local time:", local_time)
    cv2.imshow('monitor',frame)

    key = cv2.waitKey(1) & 0xFF
    if key == ord('q'): #key exit()
        break

    print ("Sec: %d" %(count))

#print (r.text)